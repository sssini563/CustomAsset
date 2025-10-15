<?php

namespace App\Console\Commands;

use App\Models\Document;
use Illuminate\Console\Command;

class DocumentRecompute extends Command
{
    protected $signature = 'doc:recompute {id : Document ID} {--complete : Also mark complete if eligible} {--regen-pdf : Re-generate and save PDF using the print layout}';
    protected $description = 'Recompute overall_status for a Document and optionally (re)generate the locked PDF';

    public function handle(): int
    {
        $id = (int) $this->argument('id');
        /** @var Document|null $doc */
        $doc = Document::find($id);
        if (!$doc) { $this->error('Not found'); return self::FAILURE; }
        $doc->updateOverallStatus();
        $this->info('Status: '.$doc->overall_status);

        if ($this->option('complete') && $doc->overall_status === 'complete') {
            if (empty($doc->completed_at)) {
                $doc->completed_at = now();
            }
            $doc->save();
            $this->info('Marked complete (timestamps updated).');
        }

        if ($this->option('regen-pdf')) {
            if (function_exists('set_time_limit')) { @set_time_limit(120); }
            // Build inline QR (same logic as controller, simplified for CLI)
            $doc->load(['signatures.user','requestor']);
            $roles = (strtolower($doc->type) === 'asset')
                ? ['creator','creator_manager','user','user_manager','hr']
                : ['creator','user'];
            $signatures = $doc->signatures->keyBy('role');
            $qrByRole = [];
            $qrSvgByRole = [];
            $qrSvgDataUriByRole = [];
            $sanitizeSvg = function(string $svg): string {
                $svg = preg_replace('/<\?xml[^>]*?>/i', '', $svg ?? '');
                $svg = preg_replace('/<!DOCTYPE[^>]*?>/i', '', $svg);
                return trim($svg);
            };
            $hasPngBackend = false; $backend = null; $writer = null;
            if (class_exists('\\BaconQrCode\\Renderer\\Image\\GdImageBackEnd') && function_exists('imagecreatetruecolor')) {
                $backend = new \BaconQrCode\Renderer\Image\GdImageBackEnd();
                $hasPngBackend = true;
            } elseif (class_exists('\\BaconQrCode\\Renderer\\Image\\ImagickImageBackEnd') && extension_loaded('imagick')) {
                $backend = new \BaconQrCode\Renderer\Image\ImagickImageBackEnd();
                $hasPngBackend = true;
            } elseif (class_exists('\\BaconQrCode\\Renderer\\Image\\SvgImageBackEnd')) {
                $backend = new \BaconQrCode\Renderer\Image\SvgImageBackEnd();
            }
            if ($backend) {
                $writer = new \BaconQrCode\Writer(new \BaconQrCode\Renderer\ImageRenderer(new \BaconQrCode\Renderer\RendererStyle\RendererStyle(96), $backend));
            }
            foreach ($roles as $role) {
                $sig = $signatures->get($role);
                if ($sig && $sig->status === 'signed' && $sig->signed_at) {
                    $signedAt = $sig->signed_at instanceof \Carbon\CarbonInterface ? $sig->signed_at->format('d-m-y H:i:s') : (string) $sig->signed_at;
                    $payload = 'doc='.$doc->document_number.'|name='.$sig->user_name.'|signed_at='.$signedAt;
                    try {
                        if ($writer) {
                            $img = $writer->writeString($payload);
                            if ($hasPngBackend) {
                                $qrByRole[$role] = 'data:image/png;base64,'.base64_encode($img);
                            } else {
                                $svg = $sanitizeSvg($img);
                                $qrSvgByRole[$role] = $svg;
                                $qrSvgDataUriByRole[$role] = 'data:image/svg+xml;base64,'.base64_encode($svg);
                            }
                        } else {
                            $barcode = new \Com\Tecnick\Barcode\Barcode();
                            $bobj = $barcode->getBarcodeObj('QRCODE,H', $payload, -4, -4, 'black', [0,0,0,0]);
                            $svg = $sanitizeSvg($bobj->getSvgCode());
                            $qrSvgByRole[$role] = $svg;
                            $qrSvgDataUriByRole[$role] = 'data:image/svg+xml;base64,'.base64_encode($svg);
                        }
                    } catch (\Throwable $e) {
                        $this->warn('QR gen failed for role '.$role.': '.$e->getMessage());
                    }
                }
            }

            // Choose per-type view and force pdfMode
            $vp = 'documents.'.strtolower($doc->type ?: 'asset');
            $view = view()->exists($vp.'.print') ? $vp.'.print' : 'documents.asset.print';
            $pdfMode = true;
            $html = view($view, [
                'document' => $doc,
                'qrByRole' => $qrByRole,
                'qrSvgByRole' => $qrSvgByRole,
                'qrSvgDataUriByRole' => $qrSvgDataUriByRole,
                'pdfMode' => $pdfMode,
            ])->render();
            $html = preg_replace('/<div class="print-controls[\s\S]*?<\/div>/', '', $html);
            $html = preg_replace('#<button[^>]*class=\"[^\"]*print-button[^\"]*\"[^>]*>.*?<\/button>#si', '', $html);

            $baseName = (string) ($doc->document_number ?: ('DOC-'.$doc->id));
            $baseName = preg_replace('/[^A-Za-z0-9 _\-\.]+/', '_', $baseName);
            $fileName = $baseName.'.pdf';
            $relPath = 'documents/'.$fileName;
            $bin = null;
            // Try Node-based renderer first for 1:1 print fidelity
            try {
                $tmpHtml = tempnam(sys_get_temp_dir(), 'docprint_').'.html';
                $tmpPdf  = tempnam(sys_get_temp_dir(), 'docprint_').'.pdf';
                file_put_contents($tmpHtml, $html);
                $nodeScript = base_path('node/pdf-render.js');
                if (is_file($nodeScript)) {
                    $cmd = 'node '.escapeshellarg($nodeScript).' '.escapeshellarg($tmpHtml).' '.escapeshellarg($tmpPdf);
                    $exit = null; $out = [];
                    @exec($cmd.' 2>&1', $out, $exit);
                    if ($exit === 0 && is_file($tmpPdf)) {
                        $bin = file_get_contents($tmpPdf);
                    } else {
                        $this->warn('Node pdf-render failed (code '.(string)$exit.'). Falling back.');
                    }
                }
                @unlink($tmpHtml); @unlink($tmpPdf);
            } catch (\Throwable $e) {
                $this->warn('Node renderer failed, will fallback: '.$e->getMessage());
            }
            if ($bin === null) {
                $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->setCompression(true);
                if (method_exists($pdf, 'setJPEGQuality')) { $pdf->setJPEGQuality(60); }
                if (method_exists($pdf, 'setFontSubsetting')) { $pdf->setFontSubsetting(false); }
                $pdf->SetFont('helvetica','',9);
                $pdf->SetMargins(10,10,10);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->setImageScale(1.0);
                $pdf->AddPage();
                $pdf->writeHTML($html, true, false, true, false, '');
                $bin = $pdf->Output($fileName, 'S');
            }
            \Storage::disk('local')->put($relPath, $bin);
            $doc->pdf_path = $relPath;
            $doc->save();
            $this->info('PDF regenerated: storage/app/'.$relPath);
        }
        return self::SUCCESS;
    }
}

<?php
namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\{Document, User, DocumentSignature};
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Com\Tecnick\Barcode\Barcode;
use App\Services\DocumentNumberGenerator;

class DocumentController extends Controller
{
    private function viewPrefixForType(string $type): string
    {
        $type = strtolower($type);
        $supported = ['asset','component','accessory','license','consumable'];
        return in_array($type, $supported, true) ? ('documents.'.$type) : 'documents.asset';
    }
    public function index(Request $request, string $type): ViewContract
    {
    $this->authorize('viewAny', Document::class);
    // Requestor is now a plain string field; no need to eager load relation
    $query = Document::with(['asset','signatures'])->type($type);
        if ($search = $request->get('search')) {
            $t = strtolower($type);
            $query->where(function($q) use ($search, $t) {
                                $q->where('document_number','like',"%$search%")
                                    ->orWhere('asset_number','like',"%$search%")
                                    ->orWhere('requestor','like',"%$search%")
                                    ->orWhere('checkout_user_name','like',"%$search%")
                  ->orWhereHas('asset', fn($a)=>$a->where('asset_tag','like',"%$search%"));
                // Type-specific search fields
                if ($t === 'license') {
                    $q->orWhere('license_key','like',"%$search%")
                      ->orWhere('license_vendor','like',"%$search%")
                      ->orWhere('license_seats','like',"%$search%")
                      ->orWhere('device_name','like',"%$search%")
                      ->orWhere('serial_number','like',"%$search%");
                } elseif ($t === 'accessory') {
                    $q->orWhere('accessory_part_number','like',"%$search%")
                      ->orWhere('accessory_serial_number','like',"%$search%")
                      ->orWhere('accessory_condition','like',"%$search%")
                      ->orWhere('device_name','like',"%$search%");
                } elseif ($t === 'component') {
                    $q->orWhere('component_model','like',"%$search%")
                      ->orWhere('component_part_number','like',"%$search%")
                      ->orWhere('component_serial_number','like',"%$search%")
                      ->orWhere('device_name','like',"%$search%");
                } elseif ($t === 'consumable') {
                    $q->orWhere('consumable_batch','like',"%$search%")
                      ->orWhere('consumable_unit','like',"%$search%")
                      ->orWhere('device_name','like',"%$search%");
                }
            });
        }
    $documents = $query->orderByDesc('id')->paginate(25);
    $vp = $this->viewPrefixForType($type);
    $view = view()->exists($vp.'.index') ? $vp.'.index' : 'documents.asset.index';
    return view($view, compact('documents','type'));
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);
        $document->load(['signatures.user','asset.model.manufacturer']);
        $vp = $this->viewPrefixForType($document->type);
        $view = view()->exists($vp.'.show') ? $vp.'.show' : 'documents.asset.show';
        return view($view, compact('document'));
    }

    public function print(Document $document)
    {
    $this->authorize('view', $document);
    // Ensure related data is loaded for print
    $document->load(['signatures.user']);

        // Build QR images: prefer PNG (GD), fallback to inline SVG if GD not available
    $qrByRole = [];            // PNG data URIs
    $qrSvgByRole = [];         // Raw <svg> markup strings
    $qrSvgDataUriByRole = [];  // data:image/svg+xml;base64 URIs
        $sanitizeSvg = function(string $svg): string {
            // Remove XML declaration and DOCTYPE for inline embedding
            $svg = preg_replace('/<\?xml[^>]*?>/i', '', $svg ?? '');
            $svg = preg_replace('/<!DOCTYPE[^>]*?>/i', '', $svg);
            return trim($svg);
        };
        // Pick best available backend (PNG if possible, else SVG)
        $hasPngBackend = false;
        $backend = null;
        if (class_exists('\\BaconQrCode\\Renderer\\Image\\GdImageBackEnd') && function_exists('imagecreatetruecolor')) {
            $backend = new \BaconQrCode\Renderer\Image\GdImageBackEnd();
            $hasPngBackend = true;
        } elseif (class_exists('\\BaconQrCode\\Renderer\\Image\\ImagickImageBackEnd') && extension_loaded('imagick')) {
            $backend = new \BaconQrCode\Renderer\Image\ImagickImageBackEnd();
            $hasPngBackend = true;
        } elseif (class_exists('\\BaconQrCode\\Renderer\\Image\\SvgImageBackEnd')) {
            $backend = new \BaconQrCode\Renderer\Image\SvgImageBackEnd();
        }
    $writer = $backend ? new Writer(new ImageRenderer(new RendererStyle(96), $backend)) : null;
    $roles = ($document->type === 'asset') ? ['creator','creator_manager','user','user_manager','hr'] : ['creator','user'];
        $signatures = $document->signatures->keyBy('role');
        foreach ($roles as $role) {
            try {
                /** @var DocumentSignature|null $sig */
                $sig = $signatures->get($role);
                if ($sig && $sig->status === 'signed' && $sig->signed_at) {
                    $signedAt = $sig->signed_at instanceof \Carbon\CarbonInterface
                        ? $sig->signed_at->format('d-m-y H:i:s')
                        : (string) $sig->signed_at;
                    // Create a compact, human-friendly QR content
                    $payload = 'doc='.$document->document_number
                        .'|name='.$sig->user_name
                        .'|signed_at='.$signedAt;
                    $img = null;
                    try {
                        if ($writer) {
                            $img = $writer->writeString($payload);
                            if ($hasPngBackend) {
                                $qrByRole[$role] = 'data:image/png;base64,'.base64_encode($img);
                            } else {
                                $svg = $sanitizeSvg($img); // SVG
                                $qrSvgByRole[$role] = $svg;
                                $qrSvgDataUriByRole[$role] = 'data:image/svg+xml;base64,'.base64_encode($svg);
                            }
                        } else {
                            throw new \RuntimeException('No QR writer backend available');
                        }
                    } catch (\Throwable $eInner) {
                        // Fallback to tc-lib-barcode SVG
                        try {
                            $barcode = new Barcode();
                            $bobj = $barcode->getBarcodeObj('QRCODE,H', $payload, -4, -4, 'black', [0,0,0,0]);
                            $svg = $sanitizeSvg($bobj->getSvgCode());
                            $qrSvgByRole[$role] = $svg;
                            $qrSvgDataUriByRole[$role] = 'data:image/svg+xml;base64,'.base64_encode($svg);
                        } catch (\Throwable $eFallback) {
                            \Log::warning('QR fallback generation failed', [
                                'document_id' => $document->id,
                                'role' => $role,
                                'error' => $eFallback->getMessage(),
                            ]);
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('QR generation failed for role', [
                    'document_id' => $document->id,
                    'role' => $role,
                    'error' => $e->getMessage(),
                ]);
                continue;
            }
        }
        $pdfMode = request()->boolean('download');
        // If download requested, generate PDF from the SAME print HTML.
        // Prefer TCPDF unless explicitly configured to use Node+Puppeteer to avoid long timeouts on fresh setups.
        if ($pdfMode) {
            if (function_exists('set_time_limit')) { @set_time_limit((int) env('DOCUMENT_PDF_TIMEOUT', 120)); }
            $vp = $this->viewPrefixForType($document->type);
            $view = view()->exists($vp.'.print') ? $vp.'.print' : 'documents.asset.print';
            // Indicate to the Blade that we're in PDF mode so it won't try HTTP route fallbacks for QR/images
            $pdfMode = true;
            $html = view($view, compact('document','qrByRole','qrSvgByRole','qrSvgDataUriByRole','pdfMode'))->render();
            // Remove interactive-only elements
            $html = preg_replace('/<div class="print-controls[\s\S]*?<\/div>/', '', $html);
            $html = preg_replace('#<button[^>]*class=\"[^\"]*print-button[^\"]*\"[^>]*>.*?<\/button>#si', '', $html);

            // Try Node+Puppeteer only if explicitly enabled
            if (config('documents.use_node_pdf')) {
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
                            @unlink($tmpHtml); @unlink($tmpPdf);
                            return response($bin, 200, [
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'attachment; filename="'.preg_replace('/[^A-Za-z0-9 _\-\.]+/','_',($document->document_number?:('DOC-'.$document->id))).'.pdf"'
                            ]);
                        }
                        \Log::warning('Node pdf-render failed', ['out'=>$out,'exit'=>$exit]);
                    }
                    @unlink($tmpHtml); @unlink($tmpPdf);
                } catch (\Throwable $e) {
                    \Log::warning('Node PDF generation failed; falling back to TCPDF', ['err'=>$e->getMessage()]);
                }
            }

            // Fallback to TCPDF if Browsershot is not installed/available
            $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->setCompression(true);
            if (method_exists($pdf, 'setJPEGQuality')) { $pdf->setJPEGQuality(60); }
            if (method_exists($pdf, 'setFontSubsetting')) { $pdf->setFontSubsetting(false); }
            $pdf->SetFont('helvetica','',9);
            $pdf->SetMargins(10,10,10);
            $pdf->SetCreator('Snipe-IT');
            $pdf->SetAuthor(auth()->user()->present()->fullName ?? 'System');
            $pdf->SetTitle((string) $document->document_number);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setImageScale(1.0);
            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, '');
            $downloadName = preg_replace('/[^A-Za-z0-9 _\-\.]+/','_',($document->document_number?:('DOC-'.$document->id))).'.pdf';
            return response($pdf->Output($downloadName, 'S'), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$downloadName.'"'
            ]);
        }
        $vp = $this->viewPrefixForType($document->type);
        $view = view()->exists($vp.'.print') ? $vp.'.print' : 'documents.asset.print';
        return view($view, compact('document','qrByRole','qrSvgByRole','qrSvgDataUriByRole','pdfMode'));
    }

    // Serve locked PDF from storage with auth check
    public function pdf(Document $document)
    {
        $this->authorize('view', $document);
        if ($document->overall_status !== 'complete' || empty($document->pdf_path)) {
            abort(404);
        }
        $disk = \Storage::disk('local');
        if (!$disk->exists($document->pdf_path)) {
            abort(404);
        }
        $bin = $disk->get($document->pdf_path);
        $fileName = basename($document->pdf_path);
        return response($bin, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
        ]);
    }

    public function edit(Document $document): ViewContract
    {
        $this->authorize('update', $document);
    $document->load('signatures.user');
    // Include each user's manager so the edit view can auto-cascade manager rows
    $users = User::with('manager')->orderBy('first_name')->limit(500)->get(); // limit for performance
        $vp = $this->viewPrefixForType($document->type);
        $view = view()->exists($vp.'.edit') ? $vp.'.edit' : 'documents.asset.edit';
        return view($view, compact('document','users'));
    }

    // Regenerate No Tanda Terima based on asset location and persist immediately
    public function regenNumber(Document $document)
    {
        $this->authorize('update', $document);
        // For assets, keep FAC/HO + 3 digits and require an associated asset.
        if (strtolower($document->type) === 'asset') {
            if (!$document->asset) {
                return response()->json(['message' => 'Asset not linked to document'], 422);
            }
            $new = DocumentNumberGenerator::generateForAsset($document->asset);
            $document->document_number = $new;
            if (preg_match('/(\d{3})$/', $new, $m)) { $document->document_no = $m[1]; }
        } else {
            // For non-asset types, use: "{Location} - {TYPE} - {id}"
            $new = DocumentNumberGenerator::generateForDocument($document);
            $document->document_number = $new;
            // Do not auto-change document_no for non-asset
        }
        $document->save();
    return response()->json(['document_number' => $new, 'document_no' => $document->document_no]);
    }

    // Update People email and employee_num for users on signatures
    public function updateSignaturePeople(Request $request, Document $document)
    {
        $this->authorize('update', $document);
        $updates = $request->input('people_updates', []);
        if (!is_array($updates)) { $updates = []; }
        foreach ($updates as $personId => $payload) {
            $user = User::find($personId);
            if (!$user) { continue; }
            $changed = false;
            if (array_key_exists('email', $payload)) { $user->email = $payload['email']; $changed = true; }
            if (array_key_exists('employee_num', $payload)) { $user->employee_num = $payload['employee_num']; $changed = true; }
            if ($changed) { $user->save(); }
        }
        return response()->json(['message'=>'People updated']);
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $this->authorize('update', $document);
        // Type-specific validation rules
        $type = strtolower($document->type ?? 'asset');
        $rules = [];
        if ($type === 'license') {
            $rules = [
                'license_key' => 'nullable|string|max:255',
                'license_seats' => 'nullable|integer|min:1',
                'license_vendor' => 'nullable|string|max:255',
                'license_expires_at' => 'nullable|date',
            ];
        } elseif ($type === 'accessory') {
            $rules = [
                'accessory_part_number' => 'nullable|string|max:255',
                'accessory_serial_number' => 'nullable|string|max:255',
                'accessory_condition' => 'nullable|string|max:255',
                'accessory_notes' => 'nullable|string|max:1000',
            ];
        } elseif ($type === 'component') {
            $rules = [
                'component_model' => 'nullable|string|max:255',
                'component_part_number' => 'nullable|string|max:255',
                'component_serial_number' => 'nullable|string|max:255',
                'component_spec' => 'nullable|string|max:1000',
            ];
        } elseif ($type === 'consumable') {
            $rules = [
                'consumable_batch' => 'nullable|string|max:255',
                'consumable_qty' => 'nullable|integer|min:1',
                'consumable_unit' => 'nullable|string|max:50',
                'consumable_notes' => 'nullable|string|max:1000',
            ];
        }
        if (!empty($rules)) {
            $request->validate($rules);
        }
        $data = $request->only([
            'document_no','organization_structure','position','location','requestor','nama_penerima','atasan_penerima_name','asset_number','gr_number','device_name','serial_number_device','merk','battery','type_device','serial_number_battery','processor','tas','memory','adaptor','hardisk','serial_number_adaptor','serial_number','foto_device','windows','browser','office','other_application_1','other_application_2','other_application_3','other_application_4','antivirus','compress_tools','reader_tool','dokumen_pengembalian_asset','dokumen_surat_pernyataan','catatan','doc_control_no','created_doc','effective_doc','revision_no','revision_date','author_doc'
        ]);
        // Type-specific fields
        $data += $request->only([
            'license_key','license_seats','license_vendor','license_expires_at',
            'accessory_part_number','accessory_serial_number','accessory_condition','accessory_notes',
            'component_model','component_part_number','component_serial_number','component_spec',
            'consumable_batch','consumable_qty','consumable_unit','consumable_notes'
        ]);
        // If user penerima dropdown chosen, override nama_penerima with selected user's name
        if ($request->filled('nama_penerima_user_id')) {
            if ($user = User::find($request->get('nama_penerima_user_id'))) {
                $data['nama_penerima'] = $user->present()->fullName ?? ($user->name ?? $user->username); 
            }
        }
        // Normalize empty requestor to null (keep blank consistent across views)
        if (array_key_exists('requestor', $data) && trim((string) $data['requestor']) === '') {
            $data['requestor'] = null;
        }
        $document->fill($data);
        $document->save();
        // Update signature assigned users if provided
        if ($request->has('signature_users')) {
            foreach($request->get('signature_users') as $sigId => $userId) {
                if(!$userId) continue;
                /** @var DocumentSignature|null $sig */
                $sig = $document->signatures()->where('id',$sigId)->first();
                if($sig && $sig->status==='pending') {
                    if ($u = User::find($userId)) {
                        $sig->user_id = $u->id;
                        $sig->user_name = $u->present()->fullName ?? ($u->name ?? $u->username);
                        $sig->save();
                        // No original it_manager / atasan_penerima rows anymore; only mirror atasan_penerima_name when user_manager changes
                        if ($sig->role === 'user_manager') {
                            if (empty($document->atasan_penerima_name) || $document->atasan_penerima_name !== $sig->user_name) {
                                $document->atasan_penerima_name = $sig->user_name;
                                $document->save();
                            }
                        }
                        // Mirror Nama Penerima from assigned 'user' signature to keep print/detail in sync
                        if ($sig->role === 'user') {
                            if (empty($document->nama_penerima) || $document->nama_penerima !== $sig->user_name) {
                                $document->nama_penerima = $sig->user_name;
                                $document->save();
                            }
                        }
                    }
                }
            }

            // After applying user selections, cascade manager signatures from People relations
            try {
                $sigCreator = $document->signatures()->where('role','creator')->first();
                $sigCreatorMgr = $document->signatures()->where('role','creator_manager')->first();
                $sigUser = $document->signatures()->where('role','user')->first();
                $sigUserMgr = $document->signatures()->where('role','user_manager')->first();

                $sel = $request->get('signature_users');
                // Determine the effective creator user id (selected or current)
                $creatorUserId = $sigCreator ? ($sel[$sigCreator->id] ?? $sigCreator->user_id) : null;
                if ($creatorUserId && $sigCreatorMgr && $sigCreatorMgr->status==='pending') {
                    $creator = User::find($creatorUserId);
                    if ($creator && $creator->manager_id) {
                        if ($manager = User::find($creator->manager_id)) {
                            $sigCreatorMgr->user_id = $manager->id;
                            $sigCreatorMgr->user_name = $manager->present()->fullName ?? ($manager->name ?? $manager->username);
                            $sigCreatorMgr->save();
                        }
                    }
                }
                // Determine the effective penerima user id, then set user_manager + mirror Atasan Penerima
                $userUserId = $sigUser ? ($sel[$sigUser->id] ?? $sigUser->user_id) : null;
                if ($userUserId && $sigUserMgr && $sigUserMgr->status==='pending') {
                    $penerima = User::find($userUserId);
                    if ($penerima && $penerima->manager_id) {
                        if ($manager = User::find($penerima->manager_id)) {
                            $sigUserMgr->user_id = $manager->id;
                            $sigUserMgr->user_name = $manager->present()->fullName ?? ($manager->name ?? $manager->username);
                            $sigUserMgr->save();
                            if (empty($document->atasan_penerima_name) || $document->atasan_penerima_name !== $sigUserMgr->user_name) {
                                $document->atasan_penerima_name = $sigUserMgr->user_name;
                                $document->save();
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('Failed to cascade manager signatures from People on update', [
                    'document_id' => $document->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // === Update People (User manager relationships) using new roles ===
        try {
            $creatorMgrSig = $document->signatures()->where('role','creator_manager')->first();
            $userMgrSig    = $document->signatures()->where('role','user_manager')->first();
            $creatorSig    = $document->signatures()->where('role','creator')->first();
            $userSig       = $document->signatures()->where('role','user')->first();
            if ($creatorMgrSig && $creatorSig && $creatorMgrSig->user_id && $creatorSig->user_id && $creatorMgrSig->user_id !== $creatorSig->user_id) {
                $creatorUser = User::find($creatorSig->user_id);
                if ($creatorUser && $creatorUser->manager_id != $creatorMgrSig->user_id) {
                    $creatorUser->manager_id = $creatorMgrSig->user_id;
                    $creatorUser->save();
                }
            }
            if ($userMgrSig && $userSig && $userMgrSig->user_id && $userSig->user_id && $userMgrSig->user_id !== $userSig->user_id) {
                $requestorUser = User::find($userSig->user_id);
                if ($requestorUser && $requestorUser->manager_id != $userMgrSig->user_id) {
                    $requestorUser->manager_id = $userMgrSig->user_id;
                    $requestorUser->save();
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed updating people manager relationships from document update', [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
            ]);
        }
    return redirect()->route('documents.index', ['type' => $document->type])->with('success','Document updated.');
    }

    /* Modal partial for detail */
    public function modalDetail(Document $document): View
    {
        $this->authorize('view', $document);
        $document->load(['signatures.user','asset.model.manufacturer']);
        $vp = $this->viewPrefixForType($document->type);
        $view = view()->exists($vp.'.partials.modal-detail') ? $vp.'.partials.modal-detail' : 'documents.asset.partials.modal-detail';
        return view($view, compact('document'));
    }

    /* Modal partial for approval list */
    public function modalApproval(Document $document): View
    {
        $this->authorize('view', $document);
        $document->load('signatures.user');
        foreach ($document->signatures as $sig) { if (method_exists($sig,'ensurePublicToken')) { $sig->ensurePublicToken(); } }
        $vp = $this->viewPrefixForType($document->type);
        $view = view()->exists($vp.'.partials.modal-approval') ? $vp.'.partials.modal-approval' : 'documents.asset.partials.modal-approval';
        return view($view, compact('document'));
    }

    /* Cancel approval (reset signatures to pending) */
    public function cancelApproval(Document $document)
    {
        $this->authorize('cancelApproval', $document);
        $document->load('signatures');
        foreach($document->signatures as $sig){
            if ($sig->status !== 'pending'){
                $sig->status = 'pending';
                $sig->signed_at = null;
                $sig->note = null;
                $sig->save();
            }
        }
        $document->overall_status = 'pending';
        $document->save();
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_cancel_approval',
            'note' => 'Approval reset by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Approval reset']);
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);
        $id = $document->id;
        $document->delete();
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $id,
            'action_type' => 'document_deleted',
            'note' => 'Document deleted by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Deleted']);
    }

    // Recompute overall status based on current signatures (helper for admin/debug)
    public function recompute(Document $document)
    {
        $this->authorize('update', $document);
        // Normalize legacy statuses then recompute
        if ($document->overall_status === 'signed' || $document->overall_status === 'rejected') {
            $document->overall_status = 'pending';
            $document->save();
        }
        // If status says complete but not actually locked, convert to complete_sign before recompute
        if ($document->overall_status === 'complete' && empty($document->completed_at) && empty($document->pdf_path)) {
            $document->overall_status = 'complete_sign';
            $document->save();
        }
        $document->updateOverallStatus();
        return response()->json(['message'=>'Recomputed','overall_status'=>$document->overall_status]);
    }

    // Render a simple sign page for a given role (deep link target)
    public function signPage(Document $document, string $role): View
    {
        $this->authorize('view', $document);
        $signature = $document->getSignature($role);
        abort_unless($signature, 404);
        if (method_exists($signature,'ensurePublicToken')) { $signature->ensurePublicToken(); }
        return view('documents.asset.sign', compact('document','signature'));
    }

    // Send signature link via email to the signature's user
    public function sendSignatureLink(Document $document, string $role)
    {
        $this->authorize('update', $document);
        $signature = $document->getSignature($role);
        abort_unless($signature, 404);
        if (method_exists($signature,'ensurePublicToken')) { $signature->ensurePublicToken(); }
        if (!$signature->user || !$signature->user->email) {
            return response()->json(['message'=>'No email for assignee'], 422);
        }
        $link = route('public.documents.approval.show', [$signature->public_token]);
        Mail::to($signature->user->email)->send(new \App\Mail\DocumentSignatureLinkMail($document, $signature, $link));
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_link_sent',
            'note' => 'Role '.$role.' link sent to '.$signature->user->email,
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Link sent']);
    }

    // Cancel this signature (reset only this role to pending)
    public function cancelSignature(Document $document, string $role)
    {
        $this->authorize('update', $document);
        $signature = $document->getSignature($role);
        abort_unless($signature, 404);
        $signature->status = 'pending';
        $signature->signed_at = null;
        $signature->note = null;
        $signature->save();
        // Recompute overall
        $document->overall_status = $document->signatures()->where('status','rejected')->exists() ? 'rejected' : ($document->signatures()->where('status','pending')->exists() ? 'pending' : 'signed');
        $document->save();
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_canceled',
            'note' => 'Role '.$role.' canceled by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Signature canceled']);
    }

    // Log that user copied the link (UX action)
    public function copiedSignatureLink(Document $document, string $role)
    {
        $this->authorize('view', $document);
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_link_copied',
            'note' => 'Role '.$role.' link copied by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Logged']);
    }

    public function regenerateSignatureToken(Document $document, string $role)
    {
        $this->authorize('update', $document);
        $signature = $document->getSignature($role);
        abort_unless($signature, 404);
    // Prefer settings override for token expiry when regenerating
    $settings = \App\Models\Setting::getSettings();
    $days = (int) (($settings?->document_public_token_days) ?? config('documents.public_token_days', 14));
    $signature->regeneratePublicToken($days);
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_token_regenerated',
            'note' => 'Role '.$role.' token regenerated by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Token regenerated','token'=>$signature->public_token]);
    }

    public function disableSignatureToken(Document $document, string $role)
    {
        $this->authorize('update', $document);
        $signature = $document->getSignature($role);
        abort_unless($signature, 404);
        $signature->public_token_expires_at = now()->subMinute();
        $signature->save();
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_signature_token_disabled',
            'note' => 'Role '.$role.' token disabled by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Token disabled']);
    }

    // Mark document as complete (lock it from further edits/deletes)
    public function complete(Document $document)
    {
        $this->authorize('update', $document);
        // Allow some extra time for PDF generation
        if (function_exists('set_time_limit')) { @set_time_limit(120); }
        // Only allow marking complete if:
        // - There are non-legacy steps
        // - No non-legacy step is rejected
        // - All assigned non-legacy steps are signed
        $document->loadMissing('signatures');
        $nonLegacy = $document->signatures->reject(fn($s)=> in_array($s->role,['it_manager','atasan_penerima']));
        if ($nonLegacy->count() === 0) {
            return response()->json(['message'=>'Cannot complete: no approval steps'], 422);
        }
        if ($nonLegacy->where('status','rejected')->count() > 0) {
            return response()->json(['message'=>'Cannot complete: there is a rejected approval'], 422);
        }
        $assigned = $nonLegacy->filter(fn($s)=> !is_null($s->user_id));
        if ($assigned->count() === 0 || $assigned->where('status','signed')->count() !== $assigned->count()) {
            return response()->json(['message'=>'Cannot complete: approvals not finished'], 422);
        }
        // Generate locked PDF and store path
        $document->overall_status = 'complete';
        $document->completed_at = now();
        // Build inline QR data to avoid HTTP roundtrips during PDF render
        $document->load(['signatures.user','requestor']);
        // Use the same role set as the print view to ensure parity
        $roles = (strtolower($document->type) === 'asset')
            ? ['creator','creator_manager','user','user_manager','hr']
            : ['creator','user'];
        $signatures = $document->signatures->keyBy('role');
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
                $payload = 'doc='.$document->document_number.'|name='.$sig->user_name.'|signed_at='.$signedAt;
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
                        // Fallback to tc-lib-barcode SVG
                        $barcode = new \Com\Tecnick\Barcode\Barcode();
                        $bobj = $barcode->getBarcodeObj('QRCODE,H', $payload, -4, -4, 'black', [0,0,0,0]);
                        $svg = $sanitizeSvg($bobj->getSvgCode());
                        $qrSvgByRole[$role] = $svg;
                        $qrSvgDataUriByRole[$role] = 'data:image/svg+xml;base64,'.base64_encode($svg);
                    }
                } catch (\Throwable $e) {
                    \Log::warning('QR gen (complete) failed', ['document_id'=>$document->id,'role'=>$role,'error'=>$e->getMessage()]);
                }
            }
        }
        // Render print HTML then to PDF; try Node+Puppeteer first for exact layout
    $vp = $this->viewPrefixForType($document->type);
    $view = view()->exists($vp.'.print') ? $vp.'.print' : 'documents.asset.print';
    // Force pdfMode in locked generation path as well
    $pdfMode = true;
    $html = view($view, compact('document','qrByRole','qrSvgByRole','qrSvgDataUriByRole','pdfMode'))->render();
        $html = preg_replace('/<div class="print-controls[\s\S]*?<\/div>/', '', $html);
        $html = preg_replace('#<button[^>]*class=\"[^\"]*print-button[^\"]*\"[^>]*>.*?<\/button>#si', '', $html);
    // Sanitize filename in case document_number contains spaces or special characters
    $baseName = (string) ($document->document_number ?: ('DOC-'.$document->id));
    $baseName = preg_replace('/[^A-Za-z0-9 _\-\.]+/', '_', $baseName);
    $baseName = trim($baseName);
    if ($baseName === '') { $baseName = 'DOC-'.$document->id; }
    $fileName = $baseName.'.pdf';
    $relPath = 'documents/'.$fileName;
        $bin = null;
        if (config('documents.use_node_pdf')) {
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
                        \Log::warning('Node pdf-render (lock) failed', ['out'=>$out,'exit'=>$exit]);
                    }
                }
                @unlink($tmpHtml); @unlink($tmpPdf);
            } catch (\Throwable $e) {
                \Log::warning('Node PDF (lock) failed', ['err'=>$e->getMessage()]);
            }
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
        // Store initial PDF to storage/app/documents
        \Storage::disk('local')->put($relPath, $bin);
        $document->pdf_path = $relPath;
        $document->save();

        // Immediately re-generate using the recompute pipeline for the cleanest layout
        try {
            \Artisan::call('doc:recompute', [
                'id' => (string) $document->id,
                '--complete' => true,
                '--regen-pdf' => true,
            ]);
        } catch (\Throwable $e) {
            \Log::warning('doc:recompute post-lock failed', ['document_id'=>$document->id, 'error'=>$e->getMessage()]);
        }
        \App\Models\Actionlog::create([
            'item_type' => Document::class,
            'item_id' => $document->id,
            'action_type' => 'document_completed',
            'note' => 'Document locked by user '.auth()->id(),
            'created_by' => auth()->id(),
        ]);
        return response()->json(['message'=>'Document marked complete','pdf'=>$relPath]);
    }

    // Serve QR as SVG for reliable rendering in browsers without GD
    public function qrSvg(Document $document, string $role)
    {
        $this->authorize('view', $document);
        $sig = $document->getSignature($role);
        if (!$sig || $sig->status !== 'signed' || !$sig->signed_at) {
            // Return a 1x1 transparent SVG to avoid broken images
            $empty = '<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"></svg>';
            return response($empty, 200, ['Content-Type' => 'image/svg+xml']);
        }
        $signedAt = $sig->signed_at instanceof \Carbon\CarbonInterface
            ? $sig->signed_at->format('d-m-y H:i:s')
            : (string) $sig->signed_at;
        $payload = 'doc='.$document->document_number
            .'|name='.$sig->user_name
            .'|signed_at='.$signedAt;

        $sanitizeSvg = function(string $svg): string {
            $svg = preg_replace('/<\?xml[^>]*?>/i', '', $svg ?? '');
            $svg = preg_replace('/<!DOCTYPE[^>]*?>/i', '', $svg);
            return trim($svg);
        };

        try {
            // Try BaconQrCode SVG backend first if available
            if (class_exists('\\BaconQrCode\\Renderer\\Image\\SvgImageBackEnd')) {
                $backend = new \BaconQrCode\Renderer\Image\SvgImageBackEnd();
                $renderer = new ImageRenderer(new RendererStyle(120), $backend);
                $writer = new Writer($renderer);
                $svg = $writer->writeString($payload);
                $svg = $sanitizeSvg($svg);
                return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
            }
            throw new \RuntimeException('Bacon SVG backend not available');
        } catch (\Throwable $e1) {
            try {
                // Fallback to tc-lib-barcode SVG
                $barcode = new Barcode();
                $bobj = $barcode->getBarcodeObj('QRCODE,H', $payload, -4, -4, 'black', [0,0,0,0]);
                $svg = $sanitizeSvg($bobj->getSvgCode());
                return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
            } catch (\Throwable $e2) {
                \Log::warning('QR SVG endpoint failed', [
                    'document_id' => $document->id,
                    'role' => $role,
                    'errors' => [$e1->getMessage(), $e2->getMessage()],
                ]);
                $empty = '<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"></svg>';
                return response($empty, 200, ['Content-Type' => 'image/svg+xml']);
            }
        }
    }
}

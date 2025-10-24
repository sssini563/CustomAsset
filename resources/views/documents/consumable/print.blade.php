<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Print - {{ $document->document_number }}</title>
    <link rel="shortcut icon" type="image/ico"
        href="{{ $snipeSettings && $snipeSettings->favicon != '' ? Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url') . '/favicon.ico' }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        .container {
            max-width: 180mm;
            background: white
        }

        .document-header {
            padding: 10pt 0 8pt 0;
            margin-bottom: 12pt;
            text-align: center;
            border-bottom: 0.75pt solid #D0D0D0
        }

        .header-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0
        }

        .header-table td {
            vertical-align: middle
        }

        .logo-section {
            width: 45mm;
            text-align: center
        }

        .doc-info-section {
            width: 45mm;
            text-align: left
        }

        /* Screen/default logo sizing to match asset */
        .logo-section img {
            max-height: 20mm;
            max-width: 100%;
            width: auto;
            display: block;
            margin: 0 auto
        }

        /* Smaller font for signature header cells */
        .sig-head {
            font-size: 8pt
        }

        .title-section h3 {
            margin: 0 0 1pt 0;
            font-weight: 700;
            font-size: 14pt;
            color: #212529;
            letter-spacing: -.02em
        }

        .title-section h4 {
            margin: 2pt 0 0 0;
            font-size: 11pt;
            color: #6C757D;
            font-weight: 400
        }

        .doc-info-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed
        }

        .doc-info-table td {
            border: none;
            border-bottom: .25pt solid #E9ECEF;
            padding: 1.5pt 2pt;
            font-size: 7pt
        }

        .doc-info-table .label-cell {
            font-weight: 500;
            color: #6C757D;
            background: #F8F9FA;
            padding-right: 2mm;
            width: 30mm;
            min-width: 30mm;
            max-width: 30mm;
            white-space: nowrap
        }

        .doc-info-table .colon-cell {
            width: 4mm;
            min-width: 4mm;
            max-width: 4mm;
            text-align: center;
            white-space: nowrap
        }

        .sp-info-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 6pt;
            font-size: 7.5pt;
            border: .6pt solid #CFCFCF
        }

        .sp-info-table td {
            border: .6pt solid #CFCFCF;
            padding: 3pt 5pt;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: normal
        }

        .sp-info-table td:nth-child(1),
        .sp-info-table td:nth-child(3) {
            background: #F8F9FA
        }

        .sp-info-table td:nth-child(2),
        .sp-info-table td:nth-child(4) {
            font-weight: 700
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6pt;
            font-size: 6.8pt;
            page-break-inside: avoid;
            border-spacing: 0;
            table-layout: fixed
        }

        .main-table td {
            border: none;
            border-bottom: .6pt solid #CFCFCF !important;
            padding: 2.6pt 4.5pt;
            vertical-align: top;
            background: white !important
        }

        .main-table .header-row {
            background: #F0F2F5;
            color: #212529;
            font-weight: 600;
            text-align: center;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: .5pt solid #D0D0D0
        }

        .main-table .label-cell {
            font-weight: 500;
            width: 40mm;
            min-width: 40mm;
            max-width: 40mm;
            color: #495057;
            padding-right: 1.5mm;
            text-align: left;
            white-space: nowrap
        }

        .main-table .colon-cell {
            width: 5mm;
            min-width: 5mm;
            max-width: 5mm;
            text-align: center;
            white-space: nowrap
        }

        .sig-name {
            font-weight: 600;
            margin-top: 6pt;
            text-align: center
        }

        .sig-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100px
        }

        .qr {
            width: 72px;
            height: 72px;
            display: block;
            margin: 0 auto
        }

        .stamp {
            opacity: .9
        }

        /* Signature matrix */
        .signature-matrix {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            border: 0.6pt solid #CFCFCF;
            margin-top: 8pt;
            font-size: 7pt;
        }

        .signature-matrix td {
            border: 0.6pt solid #CFCFCF;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .signature-matrix .sig-head td {
            font-weight: 500;
            border-bottom: none;
        }

        .signature-matrix .sig-role td {
            border-top: none;
        }

        .signature-matrix .sig-signs td {
            height: 15mm;
            border-top: none;
        }

        .signature-matrix .sig-name td {
            font-size: 7pt;
            border-top: none;
            border-bottom: none;
            padding-top: 2pt;
        }

        .signature-matrix .sig-date td {
            font-size: 4pt;
            border-top: none;
            padding-top: 1pt;
            color: #6C757D;
        }
    </style>
</head>

<body>
    <div class="container">
        @php
            $settings = \App\Models\Setting::getSettings();
            $logoDataUri = null;
            $logoUrl = null;
            $siteLogo = $settings->logo ?? ($settings->email_logo ?? null);
            if ($siteLogo) {
                if (preg_match('#^https?://#i', $siteLogo)) {
                    $logoUrl = $siteLogo;
                } else {
                    $siteLogo = ltrim($siteLogo, '/');
                    $p = public_path('uploads/' . $siteLogo);
                    if ($p && is_file($p)) {
                        $ext = strtolower(pathinfo($p, PATHINFO_EXTENSION));
                        $mime = $ext === 'svg' || $ext === 'svgz' ? 'image/svg+xml' : 'image/' . ($ext ?: 'png');
                        $logoDataUri = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($p));
                    } else {
                        $logoUrl = asset('/uploads/' . $siteLogo);
                    }
                }
            }
            $signs = $document->signatures->keyBy('role');
            $sigCreator = $signs->get('creator');
            $sigUser = $signs->get('user');
            $sigItSectionHead = $signs->get('it_section_head');
            $sigItManager = $signs->get('it_manager');
            $sigAtasanPenerima = $signs->get('atasan_penerima');
            $sigHr = $signs->get('hr');
            $fmtId = function ($date) {
                if (!$date) {
                    return '';
                }
                try {
                    if (is_string($date)) {
                        $date = \Carbon\Carbon::parse($date);
                    }
                } catch (\Throwable $e) {
                }
                $m = [
                    1 => 'januari',
                    2 => 'februari',
                    3 => 'maret',
                    4 => 'april',
                    5 => 'mei',
                    6 => 'juni',
                    7 => 'juli',
                    8 => 'agustus',
                    9 => 'september',
                    10 => 'oktober',
                    11 => 'november',
                    12 => 'desember',
                ];
                return ((int) $date->day) . ' ' . ($m[(int) $date->month] ?? '') . ' ' . ((int) $date->year);
            };
        @endphp
        <div class="document-header">
            <table class="header-table">
                <tr>
                    <td class="logo-section">
                        @if ($logoDataUri)
                            <img src="{{ $logoDataUri }}" alt="Logo" />
                        @elseif($logoUrl)
                            <img src="{{ $logoUrl }}" alt="Logo" />
                        @endif
                    </td>
                    <td class="title-section">
                        <h3>PT ABC KOGEN DAIRY</h3>
                        <h4>Form Tanda Terima IT</h4>
                    </td>
                </tr>
            </table>
        </div>

        <table class="sp-info-table">
            <colgroup>
                <col style="width:25%" />
                <col style="width:25%" />
                <col style="width:25%" />
                <col style="width:25%" />
            </colgroup>
            @php($s = \App\Models\Setting::getSettings())
            @php($d = is_array($s->document_defaults_consumable ?? null) ? $s->document_defaults_consumable : [])
            <tr>
                <td>Jenis Dokumen</td>
                <td>{{ $d['jenis_dokumen'] ?? ($s->document_default_jenis_dokumen ?? 'Formulir') }}</td>
                <td>Halaman</td>
                <td>{{ $d['sp_hal'] ?? ($s->document_default_sp_hal ?? '1 dari 1') }}</td>
            </tr>
            <tr>
                <td>Pemilik Proses</td>
                <td>{{ $d['pemilik_proses'] ?? ($s->document_default_pemilik_proses ?? 'IT Business Support') }}</td>
                <td>No. Dokumen</td>
                <td>{{ $d['doc_control_no'] ?? ($document->document_no ?: '') }}</td>
            </tr>
            <tr>
                <td>Tanggal Efektif</td>
                <td>{{ $fmtId($d['effective_doc'] ?? null) }}</td>
                <td>Tgl. Peninjauan</td>
                <td>{{ $fmtId($d['revision_date'] ?? null) }}</td>
            </tr>
            <tr>
                <td>Proses Bisnis</td>
                <td>{{ $d['proses_bisnis'] ?? ($s->document_default_proses_bisnis ?? 'Authorization Request') }}</td>
                <td>Petahana</td>
                <td>{{ $d['author_doc'] ?? ($sigCreator?->user_name ?? '') }}</td>
            </tr>
        </table>

        <table class="main-table">
            <colgroup>
                <col style="width:40mm" />
                <col style="width:5mm" />
                <col />
                <col style="width:40mm" />
                <col style="width:5mm" />
                <col />
            </colgroup>
            <tr>
                <td colspan="6" class="header-row">Header Information</td>
            </tr>
            <tr>
                <td class="label-cell">No Tanda Terima</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->document_number }}</td>
                <td class="label-cell">Organization Structure</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->organization_structure ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Document Number</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->document_no ?: '' }}</td>
                <td class="label-cell">Position</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->position ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Document Date</td>
                <td class="colon-cell">:</td>
                <td>{{ $fmtId($document->document_date) }}</td>
                <td class="label-cell">Location</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->location ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Requestor & ID</td>
                <td class="colon-cell">:</td>
                <td colspan="4">
                    {{ $sigUser?->user_name ?? ($document->nama_penerima ?: ($document->requestor ?: '')) }}</td>
            </tr>
        </table>

        <table class="main-table">
            <colgroup>
                <col style="width:40mm" />
                <col style="width:5mm" />
                <col />
            </colgroup>
            <tr>
                <td colspan="3" class="header-row">Consumable Details</td>
            </tr>
            <tr>
                <td class="label-cell">Batch</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->consumable_batch ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Qty</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->consumable_qty ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Unit</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->consumable_unit ?: '' }}</td>
            </tr>
            @if (!empty($document->consumable_notes))
                <tr>
                    <td class="label-cell">Notes</td>
                    <td class="colon-cell">:</td>
                    <td>{{ $document->consumable_notes }}</td>
                </tr>
            @endif
            <tr>
                <td class="label-cell">Catatan</td>
                <td class="colon-cell">:</td>
                <td>{{ $document->catatan ?: '' }}</td>
            </tr>
        </table>

        <table class="signature-matrix">
            <colgroup>
                <col style="width:16.67%" />
                <col style="width:16.67%" />
                <col style="width:16.67%" />
                <col style="width:16.67%" />
                <col style="width:16.67%" />
                <col style="width:16.67%" />
            </colgroup>
            <tr class="sig-head">
                <td>Created By<br>Creator</td>
                <td>Approved By<br>User</td>
                <td>Approved By<br>IT Section Head</td>
                <td>Approved By<br>IT Manager</td>
                <td>Approved By<br>Atasan Penerima</td>
                <td>Approved By<br>HR</td>
            </tr>
            <tr class="sig-role">
                <td>{{ $sigCreator?->user_name ?? '' }}</td>
                <td>{{ $sigUser?->user_name ?? '' }}</td>
                <td>{{ $sigItSectionHead?->user_name ?? '' }}</td>
                <td>{{ $sigItManager?->user_name ?? '' }}</td>
                <td>{{ $sigAtasanPenerima?->user_name ?? '' }}</td>
                <td>{{ $sigHr?->user_name ?? '' }}</td>
            </tr>
            <tr class="sig-signs">
                <td>@include('documents.partials.stamp', ['signature' => $sigCreator])</td>
                <td>@include('documents.partials.stamp', ['signature' => $sigUser])</td>
                <td>@include('documents.partials.stamp', ['signature' => $sigItSectionHead])</td>
                <td>@include('documents.partials.stamp', ['signature' => $sigItManager])</td>
                <td>@include('documents.partials.stamp', ['signature' => $sigAtasanPenerima])</td>
                <td>@include('documents.partials.stamp', ['signature' => $sigHr])</td>
            </tr>
            <tr class="sig-name">
                <td>{{ $sigCreator?->user_name ?? '' }}</td>
                <td>{{ $sigUser?->user_name ?? '' }}</td>
                <td>{{ $sigItSectionHead?->user_name ?? '' }}</td>
                <td>{{ $sigItManager?->user_name ?? '' }}</td>
                <td>{{ $sigAtasanPenerima?->user_name ?? '' }}</td>
                <td>{{ $sigHr?->user_name ?? '' }}</td>
            </tr>
            <tr class="sig-date">
                <td>{{ $sigCreator?->signed_at ? $fmtId($sigCreator->signed_at) : '' }}</td>
                <td>{{ $sigUser?->signed_at ? $fmtId($sigUser->signed_at) : '' }}</td>
                <td>{{ $sigItSectionHead?->signed_at ? $fmtId($sigItSectionHead->signed_at) : '' }}</td>
                <td>{{ $sigItManager?->signed_at ? $fmtId($sigItManager->signed_at) : '' }}</td>
                <td>{{ $sigAtasanPenerima?->signed_at ? $fmtId($sigAtasanPenerima->signed_at) : '' }}</td>
                <td>{{ $sigHr?->signed_at ? $fmtId($sigHr->signed_at) : '' }}</td>
            </tr>
        </table>
    </div>
</body>

</html>

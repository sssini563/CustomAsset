<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Print - {{ $document->document_number }}</title>
    <link rel="shortcut icon" type="image/ico"
        href="{{ $snipeSettings && $snipeSettings->favicon != '' ? Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url') . '/favicon.ico' }}">

    <style>
        /* Base */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #fff;
        }

        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 8pt;
            color: #000;
            line-height: 1.4;
        }

        /* Ensure background colors are preserved in print & PDF */
        :root {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Page + container */
        @page {
            size: A4 portrait;
            margin: 12mm 15mm 10mm 15mm;
        }

        .container {
            width: 100%;
            max-width: 180mm;
            margin: 0 auto;
            padding: 0;
        }

        /* Header */
        .document-header {
            text-align: center;
            margin-bottom: 8pt;
        }

        .header-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .header-table .logo-section {
            width: 25mm;
        }

        .header-table .title-section {
            width: auto;
            text-align: center;
        }

        .header-table .doc-info-section {
            width: 55mm;
        }

        .logo-section img {
            max-height: 10mm;
            max-width: 30mm;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .title-section h3 {
            margin: 0 0 2pt 0;
            font-size: 9pt;
            font-weight: 700;
        }

        .title-section h4 {
            margin: 0;
            font-size: 7pt;
            font-weight: 600;
        }

        /* Doc info table (right side) - Keep borders for metadata */
        .doc-info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
            border: 0.5pt solid #999;
        }

        .doc-info-table td {
            border: 0.5pt solid #ccc;
            padding: 3pt 5pt;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: normal;
        }

        .doc-info-table td:first-child {
            font-weight: 600;
            white-space: nowrap;
            width: 70pt;
            background: #f5f5f5;
        }

        .doc-info-table td:nth-child(2) {
            border-bottom: 0.3pt solid #e5e5e5;
        }

        .doc-info-table td:nth-child(2)::before {
            content: ': ';
        }

        .colon {
            display: none !important;
        }

        /* Main data tables - No borders, add colon */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6pt;
            font-size: 7.5pt;
            background: #fff;
        }

        .main-table td {
            border: none;
            padding: 3pt 5pt;
            vertical-align: middle;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: normal;
        }

        .main-table .header-row {
            text-transform: uppercase;
            letter-spacing: 0.3pt;
            font-size: 8pt;
            font-weight: 700;
            text-align: center !important;
            border-bottom: 0.3pt solid #999 !important;
            padding: 4pt 5pt !important;
        }

        .main-table .label-cell {
            width: 95pt;
            min-width: 95pt;
            max-width: 95pt;
            font-weight: 600;
            white-space: nowrap;
        }

        .main-table .label-cell+td {
            padding-left: 4pt;
            border-bottom: 0.3pt solid #e5e5e5;
        }

        .main-table .label-cell+td::before {
            content: ': ';
        }

        /* pastikan tabel serah terima stabil: khusus halaman detail (bukan SP) */
        .detail-page .main-table .label-cell {
            width: 130pt;
            min-width: 130pt;
            max-width: 130pt;
        }

        .main-table .label-cell+td {
            padding-left: 4pt;
        }

        /* Signature matrix - Clean, minimal borders */
        .signature-matrix {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 10pt;
            font-size: 7.5pt;
        }

        .signature-matrix td {
            border: none;
            border-right: 0.5pt solid #ddd;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .signature-matrix td:last-child {
            border-right: none;
        }

        .signature-matrix .sig-head td {
            font-weight: 700;
            padding: 4pt 2pt;
            border-bottom: 0.5pt solid #666;
        }

        .signature-matrix .sig-role td {
            font-weight: 600;
            padding: 3pt 2pt;
        }

        .signature-matrix .sig-signs td {
            height: 16mm;
        }

        .signature-matrix .sig-name td {
            font-size: 7.5pt;
            padding-top: 2pt;
            padding-bottom: 1pt;
            font-weight: 600;
        }

        .signature-matrix .sig-date td {
            font-size: 6pt;
            padding-top: 1pt;
            color: #666;
        }

        .qr {
            width: 12mm;
            height: 12mm;
            display: inline-block;
        }

        .qr svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .stamp {
            opacity: .9
        }

        /* Print button */
        .print-button {
            position: fixed;
            top: 12px;
            right: 12px;
            z-index: 1000;
            padding: 6px 10px;
            font-size: 9pt;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .print-button {
                display: none;
            }

            .detail-page {
                page-break-after: always;
            }

            .container {
                width: 100%;
                max-width: 100%;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* Hide print button in PDF mode as well */
        body.pdf-mode .print-button {
            display: none !important;
        }


        .statement .document-header {
            margin: 0 0 0pt 0;
            border-bottom: none;
        }

        /* Surat Pernyataan header: logo di atas tabel */
        .sp-header {
            margin-bottom: 6pt;
        }

        .sp-header-logo {
            margin-bottom: 4pt;
        }

        .sp-header-logo img {
            max-height: 12mm;
            max-width: 35mm;
            object-fit: contain;
            display: block;
        }

        .sp-info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
            text-align: left;
            table-layout: fixed;
            border: 0.5pt solid #999;
        }

        .sp-info-table td {
            border: 0.5pt solid #ccc;
            padding: 3pt 5pt;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: normal;
        }

        .sp-info-table td:nth-child(1),
        .sp-info-table td:nth-child(3) {
            text-align: left !important;
            font-weight: 600;
            background: #f5f5f5;
        }

        .sp-info-table td:nth-child(2),
        .sp-info-table td:nth-child(4) {
            border-bottom: 0.3pt solid #e5e5e5;
        }

        .sp-info-table td:nth-child(2)::before,
        .sp-info-table td:nth-child(4)::before {
            content: ': ';
        }

        .statement-header {
            text-align: center;
            margin-top: 6pt;
            margin-bottom: 6pt;
        }

        .statement-header .logo {
            display: inline-block;
        }

        .statement-header img {
            max-height: 12mm;
            max-width: 32mm;
            object-fit: contain;
            display: block;
            margin: 0 auto 4pt;
        }

        .statement-header .company {
            font-weight: 700;
            font-size: 9pt;
            letter-spacing: 0.2pt;
        }

        .statement .head {
            text-align: center;
            font-weight: 700;
            font-size: 9pt;
            margin: 6pt 0 8pt;
        }

        .statement .body {
            font-size: 8pt;
            text-align: justify;
        }

        .statement .body p {
            margin: 0 0 6pt 0;
        }

        .statement .kv {
            display: grid;
            grid-template-columns: 140pt 1fr;
            gap: 4pt 8pt;
            margin: 6pt 0 8pt 0;
        }

        .statement .sign-block {
            width: 65mm;
            margin-left: auto;
            text-align: center;
            margin-top: 8pt;
        }

        .statement .sign-block .qr {
            width: 14mm;
            height: 14mm;
            margin: 6pt auto;
        }

        @media print {
            .statement .sign-block .stamp {
                width: 19mm;
                height: 19mm
            }
        }

        .statement .sign-block .name {
            font-weight: 700;
            font-size: 7pt;
            border-bottom: 0.6pt solid #CFCFCF;
            padding-top: 0pt;
            margin-top: 2pt;
        }

        .statement .sign-block .meta {
            font-size: 7pt;
            color: #6C757D;
        }
    </style>
</head>

<body class="{{ !empty($pdfMode) ? 'pdf-mode' : '' }}">
    @php
        // define defaults early to avoid undefined variable errors in compiled views
        $headerLabel = $headerLabel ?? 'Software';
        $softLabel = $softLabel ?? 'Software';
    @endphp
    <button class="print-button" onclick="window.print()">🖨️ PRINT</button>

    <div class="container">
        @php
            $settings = \App\Models\Setting::getSettings();
            $logoDataUri = null;
            $logoUrl = null;
            $siteLogo = null;
            if (!empty($settings)) {
                $siteLogo = $settings->logo ?: $settings->email_logo ?? null;
            }
            if ($siteLogo) {
                if (preg_match('#^https?://#i', $siteLogo)) {
                    $logoUrl = $siteLogo; // remote URL
                } else {
                    $siteLogo = ltrim($siteLogo, '/');
                    $logoPublicPath = public_path('uploads/' . $siteLogo);
                    if ($logoPublicPath && is_file($logoPublicPath)) {
                        try {
                            $ext = strtolower(pathinfo($logoPublicPath, PATHINFO_EXTENSION));
                            $mime = $ext === 'svg' || $ext === 'svgz' ? 'image/svg+xml' : 'image/' . ($ext ?: 'png');
                            $logoDataUri =
                                'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoPublicPath));
                        } catch (\Throwable $e) {
                            $logoDataUri = null;
                        }
                    } else {
                        $logoUrl = asset('/uploads/' . $siteLogo);
                    }
                }
            }
        @endphp
        @php
            $signs = $document->signatures->keyBy('role');
            $sigCreator = $signs->get('creator');
            $sigCreatorMgr = $signs->get('creator_manager');
            $sigUser = $signs->get('user');
            $sigUserMgr = $signs->get('user_manager');
            // Indonesian date formatter: 13 januari 2025
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
                $months = [
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
                return ((int) $date->day) . ' ' . ($months[(int) $date->month] ?? '') . ' ' . ((int) $date->year);
            };
        @endphp
        {{-- Document Header --}}
        <div class="document-header">

            <div class="sp-header">
                <div class="sp-header-logo">
                    @if ($logoDataUri)
                        <img src="{{ $logoDataUri }}" alt="Logo" />
                    @elseif($logoUrl)
                        <img src="{{ $logoUrl }}" alt="Logo" />
                    @endif
                </div>
            </div>

            <table class="sp-info-table">
                <colgroup>
                    <col style="width:25%" />
                    <col style="width:25%" />
                    <col style="width:25%" />
                    <col style="width:25%" />
                </colgroup>
                @php
                    $s = \App\Models\Setting::getSettings();
                    $df = is_array($s->document_defaults_asset_form ?? null) ? $s->document_defaults_asset_form : [];
                    // ensure header label is always defined to avoid undefined variable in compiled views
                    $headerLabel = $headerLabel ?? 'Software';
                    $softLabel = $softLabel ?? 'Software';
                @endphp
                <tr>
                    <td>Jenis Dokumen</td>
                    <td>{{ $df['jenis_dokumen'] ?? ($s->document_default_jenis_dokumen ?? 'Formulir') }}</td>
                    <td>Halaman</td>
                    <td>{{ $df['sp_hal'] ?? ($s->document_default_sp_hal ?? '1 dari 1') }}</td>
                </tr>
                <tr>
                    <td>Pemilik Proses</td>
                    <td>{{ $df['pemilik_proses'] ?? ($s->document_default_pemilik_proses ?? 'IT Business Support') }}
                    </td>
                    <td>No. Dokumen</td>
                    <td>{{ $df['doc_control_no'] ?? ($document->document_no ?: '') }}
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Efektif</td>
                    <td>{{ $fmtId($df['effective_doc'] ?? null) }}</td>
                    <td>Tgl. Peninjauan</td>
                    <td>{{ $fmtId($df['revision_date'] ?? null) }}</td>
                </tr>
                <tr>
                    <td>Proses Bisnis</td>
                    <td>{{ $df['proses_bisnis'] ?? ($s->document_default_proses_bisnis ?? 'Authorization Request') }}
                    </td>
                    <td>Petahana</td>
                    <td>{{ $df['author_doc'] ?? ($sigCreator?->user_name ?? '') }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="title-section" style="width: 100%; text-align: center; padding:2pt 0;">
            <h3>FORM TANDA TERIMA IT</h3>
        </div>

        {{-- Header Information --}}
        <div class="detail-page">
            <table class="main-table">
                <tr>
                    <td colspan="4" class="header-row">Header Information</td>
                </tr>
                <tr>
                    <td class="label-cell">No Tanda Terima</td>
                    <td style="width: 150pt;">{{ $document->document_number }}</td>
                    <td class="label-cell">Organization Structure</td>
                    <td>{{ $document->organization_structure ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Document Number</td>
                    <td>{{ $document->document_no ?: '' }}</td>
                    <td class="label-cell">Position</td>
                    <td>{{ $document->position ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Document Date</td>
                    <td>{{ $fmtId($document->document_date) }}</td>
                    <td class="label-cell">Location</td>
                    <td>{{ $document->location ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Requestor & ID</td>
                    <td colspan="3">
                        @if (strtolower($document->type) !== 'asset')
                            {{ $sigUser?->user_name ?? ($document->nama_penerima ?: ($document->requestor ?: '')) }}
                        @else
                            {{ $document->requestor ?: '' }}
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Asset Information --}}
            @if (strtolower($document->type) === 'asset')
                <table class="main-table">
                    <tr>
                        <td colspan="2" class="header-row">
                            Telah diterima satu unit perangkat dengan data dibawah ini
                        </td>
                    </tr>
                    <tr>
                        <td class="label-cell">Nama Penerima</td>
                        <td>
                            {{ $document->nama_penerima ?: '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label-cell">Atasan Penerima</td>
                        <td>
                            {{ $document->atasan_penerima_name ?: '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label-cell">Asset Number</td>
                        <td>{{ $document->asset_number ?: '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">GR Number</td>
                        <td>{{ $document->gr_number ?: '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Type Asset</td>
                        <td>{{ $document->type_device ?: '' }}</td>
                    </tr>
                </table>
            @endif

            {{-- Hardware Section --}}
            <table class="main-table">
                <tr>
                    <td colspan="2" class="header-row">Hardware</td>
                </tr>
                <tr>
                    <td class="label-cell">Device Name</td>
                    <td>{{ $document->device_name ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Merk</td>
                    <td>{{ $document->merk ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Type</td>
                    <td>{{ $document->type_device ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Processor</td>
                    <td>{{ $document->processor ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Memory</td>
                    <td>{{ $document->memory ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Hardisk</td>
                    <td>{{ $document->hardisk ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Serial Number</td>
                    <td>{{ $document->serial_number ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Battery</td>
                    <td>{{ $document->battery ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Serial Number Battery</td>
                    <td>{{ $document->serial_number_battery ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Tas</td>
                    <td>{{ $document->tas ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Adaptor</td>
                    <td>{{ $document->adaptor ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Serial Number Adaptor</td>
                    <td>{{ $document->serial_number_adaptor ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Foto Device</td>
                    <td>{{ $document->foto_device ?: '' }}</td>
                </tr>
            </table>

            {{-- Software/Details Section (type-aware) --}}
            <table class="main-table">
                <tr>
                    @php
                        $t = strtolower($document->type ?? 'asset');
                        $headerLabel = 'Software';
                        switch ($t) {
                            case 'component':
                                $headerLabel = 'Component Details';
                                break;
                            case 'accessory':
                                $headerLabel = 'Accessories Details';
                                break;
                            case 'license':
                                $headerLabel = 'License Details';
                                break;
                            case 'consumable':
                                $headerLabel = 'Consumable Details';
                                break;
                        }
                    @endphp
                    <td colspan="2" class="header-row">{{ $headerLabel }}</td>
                </tr>
                <tr>
                    @if (strtolower($document->type) === 'license')
                        <td class="label-cell">License Key</td>
                        <td>{{ $document->license_key ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'accessory')
                        <td class="label-cell">Part Number</td>
                        <td>{{ $document->accessory_part_number ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'component')
                        <td class="label-cell">Model</td>
                        <td>{{ $document->component_model ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'consumable')
                        <td class="label-cell">Batch</td>
                        <td>{{ $document->consumable_batch ?: '' }}</td>
                    @else
                        <td class="label-cell">Windows</td>
                        <td>{{ $document->windows ?: '' }}</td>
                    @endif
                </tr>
                <tr>
                    @if (strtolower($document->type) === 'license')
                        <td class="label-cell">Seats</td>
                        <td>{{ $document->license_seats ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'accessory')
                        <td class="label-cell">Serial Number</td>
                        <td>{{ $document->accessory_serial_number ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'component')
                        <td class="label-cell">Part No</td>
                        <td>{{ $document->component_part_number ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'consumable')
                        <td class="label-cell">Qty</td>
                        <td>{{ $document->consumable_qty ?: '' }}</td>
                    @else
                        <td class="label-cell">Office</td>
                        <td>{{ $document->office ?: '' }}</td>
                    @endif
                </tr>
                <tr>
                    @if (strtolower($document->type) === 'license')
                        <td class="label-cell">Vendor</td>
                        <td>{{ $document->license_vendor ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'accessory')
                        <td class="label-cell">Condition</td>
                        <td>{{ $document->accessory_condition ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'component')
                        <td class="label-cell">Serial Number</td>
                        <td>{{ $document->component_serial_number ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'consumable')
                        <td class="label-cell">Unit</td>
                        <td>{{ $document->consumable_unit ?: '' }}</td>
                    @else
                        <td class="label-cell">Antivirus</td>
                        <td>{{ $document->antivirus ?: '' }}</td>
                    @endif
                </tr>
                <tr>
                    @if (strtolower($document->type) === 'license')
                        <td class="label-cell">Expiry Date</td>
                        <td>{{ optional($document->license_expires_at)->format('d M Y') }}</td>
                    @elseif(strtolower($document->type) === 'accessory')
                        <td class="label-cell">Notes</td>
                        <td>{{ $document->accessory_notes ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'component')
                        <td class="label-cell">Spec</td>
                        <td>{{ $document->component_spec ?: '' }}</td>
                    @elseif(strtolower($document->type) === 'consumable')
                        <td class="label-cell">Notes</td>
                        <td>{{ $document->consumable_notes ?: '' }}</td>
                    @else
                        <td class="label-cell">Compress Tools</td>
                        <td>{{ $document->compress_tools ?: '' }}</td>
                    @endif
                </tr>
                @if (strtolower($document->type) === 'asset')
                    <tr>
                        <td class="label-cell">Reader Tool</td>
                        <td>{{ $document->reader_tool ?: '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Browser</td>
                        <td>{{ $document->browser ?: '' }}</td>
                    </tr>
                @endif
                <tr>
                    <td class="label-cell">Other Application 1</td>
                    <td>{{ $document->other_application_1 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Other Application 2</td>
                    <td>{{ $document->other_application_2 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Other Application 3</td>
                    <td>{{ $document->other_application_3 ?: '' }}</td>
                </tr>
                <tr>
                    <td class="label-cell">Other Application 4</td>
                    <td>{{ $document->other_application_4 ?: '' }}</td>
                </tr>
                @if (strtolower($document->type) !== 'asset' && !empty($document->catatan))
                    <tr>
                        <td class="label-cell">Catatan</td>
                        <td>{{ $document->catatan }}</td>
                    </tr>
                @endif
            </table>

            {{-- Document Section --}}
            @if (strtolower($document->type) === 'asset')
                <table class="main-table">
                    <tr>
                        <td colspan="2" class="header-row">Document & Notes</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Dokumen Pengembalian Asset</td>
                        <td>{{ $document->dokumen_pengembalian_asset ?: '' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Catatan <span class="colon">:</span></td>
                        <td>{{ $document->catatan ?: '' }}</td>
                    </tr>
                </table>
            @endif

            {{-- Signatures Section (type-aware) --}}
            <table class="signature-matrix">
                <tr class="sig-head">
                    <td style="width:20%">Approved By :</td>
                    <td style="width:20%">Approved By :</td>
                    <td style="width:20%">Approved By :</td>
                    <td style="width:20%">Approved By :</td>
                    <td style="width:20%">Approved By :</td>
                </tr>
                <tr class="sig-role">
                    <td style="width:20%">IT Section Head</td>
                    <td style="width:20%">IT Manager</td>
                    <td style="width:20%">User</td>
                    <td style="width:20%">Atasan Penerima</td>
                    <td style="width:20%">HR</td>
                </tr>
                <tr class="sig-signs">
                    <td style="width:20%">
                        @include('documents.partials.stamp', ['signature' => $sigCreator])
                    </td>
                    <td style="width:20%">
                        @include('documents.partials.stamp', ['signature' => $sigCreatorMgr])
                    </td>
                    <td style="width:20%">
                        @include('documents.partials.stamp', ['signature' => $sigUser])
                    </td>
                    <td style="width:20%">
                        @include('documents.partials.stamp', ['signature' => $sigUserMgr])
                    </td>
                    <td style="width:20%">
                        @include('documents.partials.stamp', ['signature' => $signs->get('hr')])
                    </td>
                </tr>
                <tr class="sig-name">
                    <td style="width:20%">{{ $sigCreator?->user_name ?? '-' }}</td>
                    <td style="width:20%">{{ $sigCreatorMgr?->user_name ?? '-' }}</td>
                    <td style="width:20%">{{ $sigUser?->user_name ?? '-' }}</td>
                    <td style="width:20%">{{ $document->atasan_penerima_name ?: $sigUserMgr?->user_name ?? '-' }}</td>
                    <td style="width:20%">{{ $signs->get('hr')?->user_name ?? '-' }}</td>
                </tr>
                <tr class="sig-date">
                    <td style="width:20%">
                        {{ $sigCreator?->signed_at ? \Carbon\Carbon::parse($sigCreator->signed_at)->format('d-m-Y H:i:s') : '-' }}
                    </td>
                    <td style="width:20%">
                        {{ $sigCreatorMgr?->signed_at ? \Carbon\Carbon::parse($sigCreatorMgr->signed_at)->format('d-m-Y H:i:s') : '-' }}
                    </td>
                    <td style="width:20%">
                        {{ $sigUser?->signed_at ? \Carbon\Carbon::parse($sigUser->signed_at)->format('d-m-Y H:i:s') : '-' }}
                    </td>
                    <td style="width:20%">
                        {{ $sigUserMgr?->signed_at ? \Carbon\Carbon::parse($sigUserMgr->signed_at)->format('d-m-Y H:i:s') : '-' }}
                    </td>
                    <td style="width:20%">
                        {{ $signs->get('hr')?->signed_at ? \Carbon\Carbon::parse($signs->get('hr')->signed_at)->format('d-m-Y H:i:s') : '-' }}
                    </td>
                </tr>
            </table>
        </div>

        @php
            // derived sign / user variables used in the statement page
            $signUserModel = $sigUser?->user;
            $deptName = $signUserModel?->department?->name;
            $nama = $sigUser?->user_name ?: '';
            $nik = $signUserModel?->employee_num;
            $jabatan = $document->position;
            $departemen = $deptName;
            $lokasi = $document->location;
        @endphp

        @if (strtolower($document->type) === 'asset')
            <div class="statement">
                <div class="sp-header">
                    <div class="sp-header-logo">
                        @if ($logoDataUri)
                            <img src="{{ $logoDataUri }}" alt="Logo" />
                        @elseif($logoUrl)
                            <img src="{{ $logoUrl }}" alt="Logo" />
                        @endif
                    </div>
                    <table class="sp-info-table">
                        <colgroup>
                            <col style="width:25%" />
                            <col style="width:25%" />
                            <col style="width:25%" />
                            <col style="width:25%" />
                        </colgroup>
                        @php
                            $ds = is_array($s->document_defaults_asset_sp ?? null)
                                ? $s->document_defaults_asset_sp
                                : [];
                        @endphp
                        <tr>
                            <td>Jenis Dokumen</td>
                            <td>{{ $ds['jenis_dokumen'] ?? ($s->document_default_jenis_dokumen ?? 'Formulir') }}</td>
                            <td>Halaman</td>
                            <td>{{ $ds['sp_hal'] ?? ($s->document_default_sp_hal ?? '1 dari 1') }}</td>
                        </tr>
                        <tr>
                            <td>Pemilik Proses</td>
                            <td>{{ $ds['pemilik_proses'] ?? ($s->document_default_pemilik_proses ?? 'IT Business Support') }}
                            </td>
                            <td>No. Dokumen</td>
                            <td>{{ $ds['doc_control_no'] ?? ($document->document_no ?: '') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Efektif</td>
                            <td>{{ $fmtId($ds['effective_doc'] ?? null) }}</td>
                            <td>Tgl. Peninjauan</td>
                            <td>{{ $fmtId($ds['revision_date'] ?? null) }}</td>
                        </tr>
                        <tr>
                            <td>Proses Bisnis</td>
                            <td>{{ $ds['proses_bisnis'] ?? ($s->document_default_proses_bisnis ?? 'Authorization Request') }}
                            </td>
                            <td>Petahana</td>
                            <td>{{ $ds['author_doc'] ?? ($sigCreator?->user_name ?? '') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="head">SURAT PERNYATAAN</div>
                <div class="body">
                    <p>Saya yang bertanda tangan di bawah ini:</p>
                    <div class="kv"">
                        <div style="padding-left: 30pt;">Nama</div>
                        <div>: {{ $nama }}</div>
                        <div style="padding-left: 30pt;">Nomor Induk Karyawan</div>
                        <div>: {{ $nik ?: '' }}</div>
                        <div style="padding-left: 30pt;">Jabatan</div>
                        <div>: {{ $jabatan ?: '' }}</div>
                        <div style="padding-left: 30pt;">Departemen</div>
                        <div>: {{ $departemen ?: '' }}</div>
                        <div style="padding-left: 30pt;">Lokasi Kerja</div>
                        <div>: {{ $lokasi ?: '' }}</div>
                    </div>
                    <p><strong style="padding:0 15pt; "></strong>Menyatakan bahwa saya
                        telah membaca, memahami, menerima dan akan mematuhi ketentuan-ketentuan perihal penggunaan
                        Perangkat Elektronik (termasuk namun tidak terbatas pada perangkat komputer baik yang berupa
                        <em>Desktop</em> maupun <em>Laptop</em> beserta seluruh aksesoris penunjangnya berupa
                        <em>monitor, keyboard, mouse</em> dan lain sebagainya) sebagaimana ditetapkan oleh PT ABC Kogen
                        Dairy ("AKD") kepada seluruh Pekerjanya sebagai berikut:
                    </p>
                    <ol style="padding-left:37pt">
                        <li style="padding-left:5pt; padding-bottom:3pt;">Perangkat Elektronik yang disediakan oleh AKD
                            untuk Pekerjanya adalah merupakan fasilitas yang diberikan sebagai penunjang produktifitas
                            kerja selama bekerja di AKD dengan status pinjam pakai.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Perangkat Elektronik berupa komputer dan/atau
                            laptop yang disediakan oleh AKD telah dilengkapi dengan perangkat lunak (<em>software</em>)
                            memadai yang diperlukan oleh Pekerja selama penggunaan Perangkat Elektronik tersebut.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja wajib untuk menjaga dan merawat
                            seluruh Perangkat Elektronik yang dipinjamkan oleh AKD kepadanya.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">AKD adalah perusahaan yang menganut sistem
                            <em>Good Corporate Governance</em> serta menghormati Hak Cipta (Lisensi) dan Hukum, sehingga
                            semua Perangkat Elektronik baik perangkat keras (<em>hardware</em>) maupun <em>software</em>
                            yang dibeli oleh AKD adalah asli (orisinil) yang dibeli dari Distributor resmi.
                        </li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Seluruh Perangkat Elektronik beserta
                            aksesoris dan <em>software</em> yang <em>ter-install</em> di dalamnya adalah milik AKD,
                            sehingga AKD berhak untuk mengambil kembali perangkat tersebut sewaktu-waktu tanpa harus
                            meminta persetujuan dari Pekerja selaku <em>user</em>.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja wajib menjaga dan memelihara
                            Perangkat Elektronik beserta aksesoris, <em>software</em> yang <em>ter-install</em> di
                            dalamnya, data, dokumen, <em>file</em>, <em>user id</em>, <em>password</em> dengan
                            sebaik-baiknya.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja dilarang untuk menyalahi-gunakan
                            dalam bentuk apapun dan/atau menyalahgunakan seluruh data yang tersimpan dalam Perangkat
                            Elektronik kepada pihak manapun di luar AKD.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja dilarang untuk menggunakan Perangkat
                            Elektronik beserta aksesoris, <em>software</em> yang <em>ter-install</em> di dalamnya untuk
                            melakukan hal-hal yang bertentangan dengan hukum yang berlaku maupun hal-hal yang tidak etis
                            serta melanggar norma kesusilaan.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja dilarang untuk menambah dan/atau
                            mengurangi serta memodifikasi <em>software</em> yang <em>ter-install</em> dalam Perangkat
                            Elektronik tanpa persetujuan tertulis dari IT &amp; Business Support Department.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja dilarang untuk memindahtangankan
                            dan/atau meminjamkan Perangkat Elektronik yang disediakan AKD kepada pihak manapun tanpa
                            persetujuan tertulis dari atasan langsung dan Departemen IT &amp; Business Support
                            Department.</li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">AKD, berdasarkan diskresinya, berhak dan
                            memiliki wewenang secara penuh untuk melakukan audit dan/atau pemeriksaan sewaktu-waktu
                            terhadap Perangkat Elektronik beserta aksesoris dan <em>software</em> yang
                            <em>ter-install</em> di dalamnya tanpa harus meminta persetujuan dari Pekerja selaku
                            <em>user</em>, termasuk dalam hal ini melakukan akses dan/atau <em>remote access</em>
                            terhadap <em>file</em>, data dan e-mail yang terdapat di dalam Desktop dan/atau Laptop
                            Pekerja.
                        </li>
                        <li style="padding-left:5pt; padding-bottom:3pt;">Atas permintaan AKD, Pekerja wajib untuk
                            mengembalikan Perangkat Elektronik yang ada padanya kepada AKD sesuai tenggang waktu
                            pengembalian yang ditentukan oleh AKD.</li>
                    </ol>
                    <p><strong style="padding:0 15pt;"></strong>Apabila saya tidak mematuhi dan/atau melanggar
                        ketentuan sebagaimana diatur dalam Surat Pernyataan ini, Peraturan Perusahaan, SK Direksi dan
                        Internal Memo beserta pedoman etika bisnis (<em>code of business conduct</em>) yang diterbitkan
                        oleh AKD dari waktu ke waktu, maka saya bersedia untuk dikenakan sanksi sesuai yang ditetapkan
                        oleh AKD, termasuk sanksi Pemutusan Hubungan Kerja (PHK). Segala akibat yang akan timbul baik
                        secara perdata maupun pidana akan sepenuhnya menjadi tanggung jawab saya dan saya dengan ini
                        membebaskan AKD dari seluruh tuntutan maupun tanggung jawab baik secara pidana maupun perdata
                        atas terjadinya hal-hal tersebut.</p>
                    <p><strong style="padding:0 15pt;"></strong>Demikian Surat Pernyataan ini saya buat secara sadar,
                        tanpa paksaan serta saya setujui. Saya memberikan persetujuan tertulis saya atas seluruh isi
                        dari Surat Pernyataan ini, untuk selanjutnya seluruh isi dari Surat Pernyataan ini mengikat saya
                        secara hukum untuk dapat dipergunakan sebagaimana mestinya.</p>
                    <div class="sign-block">
                        <div>Yang Menyatakan</div>
                        <div style="height:15mm; margin:4pt 0;">
                            @include('documents.partials.stamp', ['signature' => $sigUser])
                        </div>
                        <div class="name">{{ $sigUser?->user_name ?? '-' }}</div>
                        <div class="meta">
                            @if ($sigUser?->signed_at)
                                {{ \Carbon\Carbon::parse($sigUser->signed_at)->format('d-m-Y H.i.s') }}@else-
                            @endif
                        </div>
                    </div>
                </div>
        @endif


    </div>
</body>

</html>

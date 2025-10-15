<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Print - {{ $document->document_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 180mm;
            /* Removed custom print footer */
            background: white;
        }

        .document-header {
            border: none;
            padding: 10pt 0 8pt 0;
            margin-bottom: 12pt;
            text-align: center;
            border-bottom: 0.75pt solid #D0D0D0;
        }

    /* Header as real table for consistent PDF rendering */
    .header-table { width: 100%; margin: 0 auto; border-collapse: separate; border-spacing: 0; }
    .header-table td { vertical-align: middle; }
    /* Make left and right columns equal width so the title stays perfectly centered */
    .header-table .logo-section { width: 45mm; }
    .header-table .doc-info-section { width: 45mm; }

        .logo-section {
            font-size: 8pt;
            color: #6C757D;
            text-align: center;
        }

        .title-section {
            flex: 1;
            text-align: center;
        }
        .title-section h3 {
            margin: 0 0 1pt 0;
            font-weight: 700;
            font-size: 14pt;
            color: #212529;
            letter-spacing: -0.02em;
        }
        .title-section h4 {
            margin: 2pt 0 0 0;
            font-size: 11pt;
            color: #6C757D;
            font-weight: 400;
        }

        .doc-info-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .doc-info-table td {
            width: auto;
            border: none;
            border-bottom: 0.25pt solid #E9ECEF;
            padding: 1.5pt 2pt;
            font-size: 7pt;
        }

        .doc-info-table td:first-child {
            font-weight: 500;
            color: #6C757D;
            background: #F8F9FA;
            padding-right: 6pt;
        }

        /* no pseudo colon here; we render ':' in markup for PDF parity */

        /* more space for the value */
        /* .doc-info-table td + td {
            padding-left: 10pt;
        } */

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12pt;
            border: none;
            font-size: 9pt;
        }

        .main-table td {
            border: none;
            border-bottom: 0.25pt solid #E5E5E5;
            padding: 6pt 8pt;
            vertical-align: top;
        }

        .main-table .header-row {
            background: #F8F9FA;
            color: #212529;
            font-weight: 600;
            text-align: center;
            font-size: 10pt;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 0.5pt solid #D0D0D0;
        }

        .main-table .label-cell {
            font-weight: 500;
            width: 25%;
            color: #495057;
            background: transparent;
            position: relative;
            padding-right: 2pt; /* tighter space for aligned colon */
        }

        /* colon is now rendered in markup for PDF compatibility */

        /* add value-side spacing in main table */
        .main-table .label-cell + td {
            padding-left: 6pt;
        }

        .main-table tr:nth-child(even) td {
            background: #FAFBFC;
        }

        .main-table tr:nth-child(odd) td {
            background: white;
        }

        /* Section spacing */
        .main-table + .main-table {
            margin-top: 16pt;
        }

    /* Signature helpers */
    .sig-name { font-weight: 600; margin-top: 6pt; text-align: center; }
    .sig-meta { font-size: 7pt; color: #6C757D; margin-top: 0pt; }
    .sig-box { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100px; }
    .qr { width: 72px; height: 72px; display: block; margin: 0 auto; }
    .signatures-row td { text-align: center; vertical-align: middle; }
    .qr svg { width: 100%; height: 100%; display: block; }

        /* Screen/default logo sizing */
        .logo-section img {
            max-height: 20mm;
            max-width: 100%;
            width: auto;
            display: block;
            margin: 0 auto;
        }

        @media print {
            @page {
                size: A4;
                margin: 10mm 10mm; /* more generous side margins */
            }

            body {
                background: white !important;
                padding: 0;
                margin: 0;
                font-size: 7pt;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .container {
                max-width: 180mm; /* keep inner content away from edges */
                margin: 0 auto;
                width: auto;
                padding: 0;
            }

            /* removed custom print footer */

            .main-table {
                font-size: 6.8pt;
                margin-bottom: 4pt;
                page-break-inside: avoid;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .main-table td {
                padding: 2.6pt 4.5pt;
                border: none;
                border-bottom: 0.6pt solid #CFCFCF !important;
                background: white !important;
            }

            .main-table .label-cell {
                width: 100pt;
                min-width: 100pt;
                max-width: 100pt;
                text-align: left;
                padding-right: 4pt; /* tighter space for aligned colon on print */
                white-space: nowrap;
                position: relative;
            }

            /* no pseudo colon; rendered in markup */

            .main-table .label-cell + td {
                padding-left: 4pt; /* print: value spacing tighter */
            }

            .main-table .header-row {
                background: #F0F2F5 !important;
                color: #212529 !important;
                font-size: 8pt;
                -webkit-print-color-adjust: exact;
                text-align: center;
                padding-top: 1pt;
                padding-bottom: 3pt;
            }
            .main-table .header-row + tr td { border-top: none; }

            /* Use per-cell bottom border for consistent separators across columns */
            /* Disable zebra striping to avoid seam artifacts in print */
            .main-table tr:nth-child(even) td { background: white !important; }


            .logo-section img { max-height: 20mm; max-width: 100%; width: auto; display: block; margin: 0 auto; font-size: 7pt; }
            /* Balance side columns in header so title stays centered, pulled closer */
            .header-table .logo-section { width: 45mm; }
            .header-table .doc-info-section { width: 45mm; }

            .title-section h3 {
                font-size: 10pt;
                margin: 0 0 1pt 0;
            }

            .title-section h4 {
                font-size: 8pt;
                margin: 1pt 0 0 0;
            }

            .doc-info-section { font-size: 6pt; padding-left: 4pt; text-align: left; }

            .doc-info-table { table-layout: fixed; width: 100%; }
            .doc-info-table td {
                padding: 2pt 3pt;
                font-size: 5.8pt;
                line-height: 1.25;
                border-bottom: 0.4pt solid #D0D0D0;
            }
            .doc-info-table td:first-child {
                width: 72pt;
                white-space: nowrap;
                padding-right: 6pt;
            }
            .doc-info-table td + td { width: auto; }

            .doc-info-table td:first-child {
                position: relative;
                padding-right: 8pt; /* print: space for aligned colon */
            }

            /* no pseudo colon in print mode either */

            /* print: give value a bit more space */
            .doc-info-table td + td {
                padding-left: 10pt;
            }

            .signature-section {
                margin-top: 7pt;
                font-size: 7pt;
            }

            .signature-table {
                font-size: 7pt;
            }

            .signature-table td {
                padding: 2pt 3pt;
                font-size: 7pt;
            }

            .signature-table .signature-cell { height: 45pt; }
            .sig-box { height: 85pt; justify-content: center; }

            /* Use physical units for print for consistent scanability */
            .qr { width: 18mm; height: 18mm; margin: 0 auto; }
            .qr svg { width: 100%; height: 100%; }

            /* Mengurangi spacing antar section */
            .main-table + .main-table {
                margin-top: 5pt;
            }
            /* Avoid double border at table end */
            .main-table tr:last-child td { border-bottom: 0.45pt solid #D0D0D0 !important; }
        }

        /* Screen/default overrides (outside print) */
    .doc-info-section { width: 120px; text-align: left; }
        .logo-section { width: 60px; font-size: 7pt; }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            z-index: 1000;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-family: 'Segoe UI', 'Arial', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            min-width: 120px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .print-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .print-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.6);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .print-button:hover::before {
            left: 100%;
        }

        .print-button:active {
            transform: translateY(-1px) scale(1.02);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .print-button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
        }

        @media screen {
            .print-button {
                display: block;
            }
            /* removed custom print footer */
        }

        @media print {
            .print-button {
                display: none;
            }
        }

    /* helpers: align ':' consistently at the right edge of label cells */
    .colon { position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 5pt; text-align: center; }
    /* No PDF-specific overrides; PDF engine will use @media print CSS to keep layout identical */

    /* Page controls */
    .page-break { page-break-before: always; break-before: page; }
    .detail-page { page-break-after: always; }
    .statement { margin-top: 6pt; }
    .statement .head { text-align: center; font-weight: 700; font-size: 12pt; margin-bottom: 8pt; color: #212529; }
    .statement .body { font-size: 9pt; color: #111; text-align: justify; }
    .statement .body p { margin: 0 0 6pt 0; text-align: inherit; }
    .statement .kv { display: grid; grid-template-columns: 140pt 1fr; gap: 4pt 8pt; margin: 6pt 0 8pt 0; }
    .statement ol { margin: 4pt 0 4pt 18pt; }
    .statement .muted { color: #6C757D; font-size: 8pt; margin-top: 6pt; }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ PRINT</button>
    
    <div class="container">
        @php
            $settings = \App\Models\Setting::getSettings();
            $logoDataUri = null; $logoUrl = null;
            $siteLogo = null;
            if (!empty($settings)) {
                $siteLogo = $settings->logo ?: ($settings->email_logo ?? null);
            }
            if ($siteLogo) {
                if (preg_match('#^https?://#i', $siteLogo)) {
                    $logoUrl = $siteLogo; // remote URL
                } else {
                    $siteLogo = ltrim($siteLogo,'/');
                    $logoPublicPath = public_path('uploads/'.$siteLogo);
                    if ($logoPublicPath && is_file($logoPublicPath)) {
                        try {
                            $ext = strtolower(pathinfo($logoPublicPath, PATHINFO_EXTENSION));
                            $mime = ($ext === 'svg' || $ext === 'svgz') ? 'image/svg+xml' : ('image/'.($ext ?: 'png'));
                            $logoDataUri = 'data:'.$mime.';base64,'.base64_encode(file_get_contents($logoPublicPath));
                        } catch (\Throwable $e) { $logoDataUri = null; }
                    } else {
                        $logoUrl = asset('/uploads/'.$siteLogo);
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
            $fmtId = function($date){
                if (!$date) return '';
                try { if (is_string($date)) { $date = \Carbon\Carbon::parse($date); } } catch (\Throwable $e) {}
                $months = [1=>'januari',2=>'februari',3=>'maret',4=>'april',5=>'mei',6=>'juni',7=>'juli',8=>'agustus',9=>'september',10=>'oktober',11=>'november',12=>'desember'];
                return ((int)$date->day).' '.($months[(int)$date->month] ?? '').' '.((int)$date->year);
            };
        @endphp
        {{-- Document Header --}}
        <div class="document-header">
            <table class="header-table">
                <tr>
                    <td class="logo-section">
                        @if($logoDataUri)
                            <img src="{{ $logoDataUri }}" alt="Logo" />
                        @elseif($logoUrl)
                            <img src="{{ $logoUrl }}" alt="Logo" />
                        @endif
                    </td>
                    <td class="title-section">
                        <h3>PT ABC KOGEN DAIRY</h3>
                        <h4>Form Tanda Terima IT</h4>
                    </td>
                    <td class="doc-info-section">
                        <table class="doc-info-table">
                            <tr>
                                <td>Doc. Control No <span class="colon">:</span></td>
                                <td>{{ $document->doc_control_no ?: '' }}</td>
                            </tr>
                            <tr>
                                <td>Created Doc <span class="colon">:</span></td>
                                <td>{{ $document->created_doc ? $document->created_doc->format('d M Y') : '' }}</td>
                            </tr>
                            <tr>
                                <td>Effective Doc <span class="colon">:</span></td>
                                <td>{{ $document->effective_doc ? $document->effective_doc->format('d M Y') : '' }}</td>
                            </tr>
                            <tr>
                                <td>Revision No <span class="colon">:</span></td>
                                <td>{{ $document->revision_no ?: '' }}</td>
                            </tr>
                            <tr>
                                <td>Revision Date <span class="colon">:</span></td>
                                <td>{{ $document->revision_date ? $document->revision_date->format('d M Y') : '' }}</td>
                            </tr>
                            <tr>
                                <td>Author Doc <span class="colon">:</span></td>
                                <td>{{ $document->author_doc ?: '' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Header Information --}}
    <div class="detail-page">
        <table class="main-table">
            <tr>
                <td colspan="4" class="header-row">Header Information</td>
            </tr>
            <tr>
                <td class="label-cell" >No Tanda Terima <span class="colon">:</span></td>
                <td style="width: 150pt;">{{ $document->document_number }}</td>
                <td class="label-cell">Organization Structure <span class="colon">:</span></td>
                <td>{{ $document->organization_structure ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Document Number <span class="colon">:</span></td>
                <td>{{ $document->document_no ?: '' }}</td>
                <td class="label-cell">Position <span class="colon">:</span></td>
                <td>{{ $document->position ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Document Date <span class="colon">:</span></td>
                <td>{{ $fmtId($document->document_date) }}</td>
                <td class="label-cell">Location <span class="colon">:</span></td>
                <td>{{ $document->location ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Requestor & ID <span class="colon">:</span></td>
                <td colspan="3">
                    @if(strtolower($document->type)!=='asset')
                        {{ $sigUser?->user_name ?? ($document->nama_penerima ?: ($document->requestor ?: '')) }}
                    @else
                        {{ $document->requestor ?: '' }}
                    @endif
                </td>
            </tr>
        </table>

        {{-- Asset Information --}}
        @if(strtolower($document->type)==='asset')
        <table class="main-table">
            <tr>
                <td colspan="2" class="header-row">
                    Telah diterima satu unit perangkat dengan data dibawah ini
                </td>
            </tr>
            <tr>
                <td class="label-cell">Nama Penerima <span class="colon">:</span></td>
                <td>
                  {{ $document->nama_penerima ?: '' }}
                </td>
            </tr>
            <tr>
                <td class="label-cell">Atasan Penerima <span class="colon">:</span></td>
                <td>
                  {{ $document->atasan_penerima_name ?: '' }}
                </td>
            </tr>
            <tr>
                <td class="label-cell">Asset Number <span class="colon">:</span></td>
                <td>{{ $document->asset_number ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">GR Number <span class="colon">:</span></td>
                <td>{{ $document->gr_number ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Type Asset <span class="colon">:</span></td>
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
                <td class="label-cell">Device Name <span class="colon">:</span></td>
                <td>{{ $document->device_name ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Merk <span class="colon">:</span></td>
                <td>{{ $document->merk ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Type <span class="colon">:</span></td>
                <td>{{ $document->type_device ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Processor <span class="colon">:</span></td>
                <td>{{ $document->processor ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Memory <span class="colon">:</span></td>
                <td>{{ $document->memory ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Hardisk <span class="colon">:</span></td>
                <td>{{ $document->hardisk ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Serial Number <span class="colon">:</span></td>
                <td>{{ $document->serial_number ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Battery <span class="colon">:</span></td>
                <td>{{ $document->battery ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Serial Number Battery <span class="colon">:</span></td>
                <td>{{ $document->serial_number_battery ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Tas <span class="colon">:</span></td>
                <td>{{ $document->tas ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Adaptor <span class="colon">:</span></td>
                <td>{{ $document->adaptor ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Serial Number Adaptor <span class="colon">:</span></td>
                <td>{{ $document->serial_number_adaptor ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Foto Device <span class="colon">:</span></td>
                <td>{{ $document->foto_device ?: '' }}</td>
            </tr>
        </table>

        {{-- Software/Details Section (type-aware) --}}
        <table class="main-table">
            <tr>
                                @php
                                    $softLabel = 'Software';
                                    switch (strtolower($document->type)) {
                                        case 'component': $softLabel = 'Component Details'; break;
                                        case 'accessory': $softLabel = 'Accessories Details'; break;
                                        case 'license': $softLabel = 'License Details'; break;
                                        case 'consumable': $softLabel = 'Consumable Details'; break;
                                    }
                                @endphp
                                <td colspan="2" class="header-row">{{ $softLabel }}</td>
            </tr>
            <tr>
                                @if(strtolower($document->type)==='license')
                                    <td class="label-cell">License Key <span class="colon">:</span></td>
                                    <td>{{ $document->license_key ?: '' }}</td>
                                @elseif(strtolower($document->type)==='accessory')
                                    <td class="label-cell">Part Number <span class="colon">:</span></td>
                                    <td>{{ $document->accessory_part_number ?: '' }}</td>
                                @elseif(strtolower($document->type)==='component')
                                    <td class="label-cell">Model <span class="colon">:</span></td>
                                    <td>{{ $document->component_model ?: '' }}</td>
                                @elseif(strtolower($document->type)==='consumable')
                                    <td class="label-cell">Batch <span class="colon">:</span></td>
                                    <td>{{ $document->consumable_batch ?: '' }}</td>
                                @else
                                    <td class="label-cell">Windows <span class="colon">:</span></td>
                                    <td>{{ $document->windows ?: '' }}</td>
                                @endif
            </tr>
            <tr>
                                @if(strtolower($document->type)==='license')
                                    <td class="label-cell">Seats <span class="colon">:</span></td>
                                    <td>{{ $document->license_seats ?: '' }}</td>
                                @elseif(strtolower($document->type)==='accessory')
                                    <td class="label-cell">Serial Number <span class="colon">:</span></td>
                                    <td>{{ $document->accessory_serial_number ?: '' }}</td>
                                @elseif(strtolower($document->type)==='component')
                                    <td class="label-cell">Part No <span class="colon">:</span></td>
                                    <td>{{ $document->component_part_number ?: '' }}</td>
                                @elseif(strtolower($document->type)==='consumable')
                                    <td class="label-cell">Qty <span class="colon">:</span></td>
                                    <td>{{ $document->consumable_qty ?: '' }}</td>
                                @else
                                    <td class="label-cell">Office <span class="colon">:</span></td>
                                    <td>{{ $document->office ?: '' }}</td>
                                @endif
            </tr>
            <tr>
                                @if(strtolower($document->type)==='license')
                                    <td class="label-cell">Vendor <span class="colon">:</span></td>
                                    <td>{{ $document->license_vendor ?: '' }}</td>
                                @elseif(strtolower($document->type)==='accessory')
                                    <td class="label-cell">Condition <span class="colon">:</span></td>
                                    <td>{{ $document->accessory_condition ?: '' }}</td>
                                @elseif(strtolower($document->type)==='component')
                                    <td class="label-cell">Serial Number <span class="colon">:</span></td>
                                    <td>{{ $document->component_serial_number ?: '' }}</td>
                                @elseif(strtolower($document->type)==='consumable')
                                    <td class="label-cell">Unit <span class="colon">:</span></td>
                                    <td>{{ $document->consumable_unit ?: '' }}</td>
                                @else
                                    <td class="label-cell">Antivirus <span class="colon">:</span></td>
                                    <td>{{ $document->antivirus ?: '' }}</td>
                                @endif
            </tr>
            <tr>
                                @if(strtolower($document->type)==='license')
                                    <td class="label-cell">Expiry Date <span class="colon">:</span></td>
                                    <td>{{ optional($document->license_expires_at)->format('d M Y') }}</td>
                                @elseif(strtolower($document->type)==='accessory')
                                    <td class="label-cell">Notes <span class="colon">:</span></td>
                                    <td>{{ $document->accessory_notes ?: '' }}</td>
                                @elseif(strtolower($document->type)==='component')
                                    <td class="label-cell">Spec <span class="colon">:</span></td>
                                    <td>{{ $document->component_spec ?: '' }}</td>
                                @elseif(strtolower($document->type)==='consumable')
                                    <td class="label-cell">Notes <span class="colon">:</span></td>
                                    <td>{{ $document->consumable_notes ?: '' }}</td>
                                @else
                                    <td class="label-cell">Compress Tools <span class="colon">:</span></td>
                                    <td>{{ $document->compress_tools ?: '' }}</td>
                                @endif
            </tr>
                        @if(strtolower($document->type)==='asset')
                            <tr>
                                    <td class="label-cell">Reader Tool <span class="colon">:</span></td>
                                    <td>{{ $document->reader_tool ?: '' }}</td>
                            </tr>
                            <tr>
                                    <td class="label-cell">Browser <span class="colon">:</span></td>
                                    <td>{{ $document->browser ?: '' }}</td>
                            </tr>
                        @endif
            <tr>
                <td class="label-cell">Other Application 1 <span class="colon">:</span></td>
                <td>{{ $document->other_application_1 ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Other Application 2 <span class="colon">:</span></td>
                <td>{{ $document->other_application_2 ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Other Application 3 <span class="colon">:</span></td>
                <td>{{ $document->other_application_3 ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Other Application 4 <span class="colon">:</span></td>
                <td>{{ $document->other_application_4 ?: '' }}</td>
            </tr>
            @if(strtolower($document->type)!=='asset' && !empty($document->catatan))
            <tr>
                <td class="label-cell">Catatan <span class="colon">:</span></td>
                <td>{{ $document->catatan }}</td>
            </tr>
            @endif
        </table>

    {{-- Document Section --}}
        @if(strtolower($document->type)==='asset')
        <table class="main-table">
            <tr>
                <td colspan="2" class="header-row">Document & Notes</td>
            </tr>
            <tr>
                <td class="label-cell">Dokumen Pengembalian Asset <span class="colon">:</span></td>
                <td>{{ $document->dokumen_pengembalian_asset ?: '' }}</td>
            </tr>
            <tr>
                <td class="label-cell">Catatan <span class="colon">:</span></td>
                <td>{{ $document->catatan ?: '' }}</td>
            </tr>
        </table>
        @endif

    {{-- Signatures Section (type-aware) --}}
        <table class="main-table">
            @if(strtolower($document->type)==='asset')
              <tr>
                  <td class="header-row" style="text-align: center;">Created By<br>Creator</td>
                  <td class="header-row" style="text-align: center;">Approved By<br>IT Manager</td>
                  <td class="header-row" style="text-align: center;">Approved By<br>User</td>
                  <td class="header-row" style="text-align: center;">Approved By<br>Atasan Penerima</td>
                  <td class="header-row" style="text-align: center;">Approved By<br>HR</td>
              </tr>
              <tr class="signatures-row" style="height: 110px;">
                <td>
                    <div class="sig-box">
                        @if(!empty($qrByRole['creator'] ?? null))
                            <img class="qr" src="{{ $qrByRole['creator'] }}" alt="QR creator" />
                        @elseif(!empty($qrSvgDataUriByRole['creator'] ?? null))
                            <img class="qr" src="{{ $qrSvgDataUriByRole['creator'] }}" alt="QR creator" />
                        @elseif(!empty($qrSvgByRole['creator'] ?? null))
                            <div class="qr" style="width:50px;height:50px;">{!! $qrSvgByRole['creator'] !!}</div>
                        @elseif(isset($document) && method_exists($document, 'getRouteKey') && empty($pdfMode))
                            <img class="qr" src="{{ route('documents.qr.svg', [$document, 'creator']) }}" alt="QR creator" />
                        @endif
                        <div class="sig-name">{{ $sigCreator?->user_name ?? '' }}</div>
                    </div>
                </td>
                <td>
                    <div class="sig-box">
                        @if(!empty($qrByRole['creator_manager'] ?? null))
                            <img class="qr" src="{{ $qrByRole['creator_manager'] }}" alt="QR creator manager" />
                        @elseif(!empty($qrSvgDataUriByRole['creator_manager'] ?? null))
                            <img class="qr" src="{{ $qrSvgDataUriByRole['creator_manager'] }}" alt="QR creator manager" />
                        @elseif(!empty($qrSvgByRole['creator_manager'] ?? null))
                            <div class="qr" style="width:50px;height:50px;">{!! $qrSvgByRole['creator_manager'] !!}</div>
                        @elseif(isset($document) && method_exists($document, 'getRouteKey') && empty($pdfMode))
                            <img class="qr" src="{{ route('documents.qr.svg', [$document, 'creator_manager']) }}" alt="QR creator manager" />
                        @endif
                        <div class="sig-name">{{ $sigCreatorMgr?->user_name ?? '' }}</div>
                    </div>
                </td>
                <td>
                    <div class="sig-box">
                        @if(!empty($qrByRole['user'] ?? null))
                            <img class="qr" src="{{ $qrByRole['user'] }}" alt="QR user" />
                        @elseif(!empty($qrSvgDataUriByRole['user'] ?? null))
                            <img class="qr" src="{{ $qrSvgDataUriByRole['user'] }}" alt="QR user" />
                        @elseif(!empty($qrSvgByRole['user'] ?? null))
                            <div class="qr" style="width:50px;height:50px;">{!! $qrSvgByRole['user'] !!}</div>
                        @elseif(isset($document) && method_exists($document, 'getRouteKey') && empty($pdfMode))
                            <img class="qr" src="{{ route('documents.qr.svg', [$document, 'user']) }}" alt="QR user" />
                        @endif
                        <div class="sig-name">{{ $sigUser?->user_name ?? '' }}</div>
                    </div>
                </td>
                <td>
                    <div class="sig-box">
                        @if(!empty($qrByRole['user_manager'] ?? null))
                            <img class="qr" src="{{ $qrByRole['user_manager'] }}" alt="QR user manager" />
                        @elseif(!empty($qrSvgDataUriByRole['user_manager'] ?? null))
                            <img class="qr" src="{{ $qrSvgDataUriByRole['user_manager'] }}" alt="QR user manager" />
                        @elseif(!empty($qrSvgByRole['user_manager'] ?? null))
                            <div class="qr" style="width:50px;height:50px;">{!! $qrSvgByRole['user_manager'] !!}</div>
                        @elseif(isset($document) && method_exists($document, 'getRouteKey') && empty($pdfMode))
                            <img class="qr" src="{{ route('documents.qr.svg', [$document, 'user_manager']) }}" alt="QR user manager" />
                        @endif
                        <div class="sig-name">{{ $document->atasan_penerima_name ?: ($sigUserMgr?->user_name ?? '') }}</div>
                    </div>
                </td>
                <td>
                    <div class="sig-box">
                        @if(!empty($qrByRole['hr'] ?? null))
                            <img class="qr" src="{{ $qrByRole['hr'] }}" alt="QR HR" />
                        @elseif(!empty($qrSvgDataUriByRole['hr'] ?? null))
                            <img class="qr" src="{{ $qrSvgDataUriByRole['hr'] }}" alt="QR HR" />
                        @elseif(!empty($qrSvgByRole['hr'] ?? null))
                            <div class="qr" style="width:50px;height:50px;">{!! $qrSvgByRole['hr'] !!}</div>
                        @elseif(isset($document) && method_exists($document, 'getRouteKey') && empty($pdfMode))
                            <img class="qr" src="{{ route('documents.qr.svg', [$document, 'hr']) }}" alt="QR HR" />
                        @endif
                        @php($hrSig = $signs->get('hr'))
                        <div class="sig-name">{{ $hrSig?->user_name ?? '' }}</div>
                    </div>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td class="header-row" style="text-align: center;">Created By<br>Creator</td>
                                <td class="header-row" style="text-align: center;">Approved By<br>User</td>
                            </tr>
                            <tr class="signatures-row" style="height: 110px;">
                                <td>
                                    <div class="sig-box">
                                        @if(!empty($qrByRole['creator'] ?? null))
                                                <img class="qr" src="{{ $qrByRole['creator'] }}" alt="QR creator" />
                                        @elseif(!empty($qrSvgDataUriByRole['creator'] ?? null))
                                                <img class="qr" src="{{ $qrSvgDataUriByRole['creator'] }}" alt="QR creator" />
                                        @elseif(!empty($qrSvgByRole['creator'] ?? null))
                                                <div class="qr" style="width:50px;height:50px;">{!! $qrSvgByRole['creator'] !!}</div>
                                        @elseif(isset($document) && method_exists($document, 'getRouteKey') && empty($pdfMode))
                                                <img class="qr" src="{{ route('documents.qr.svg', [$document, 'creator']) }}" alt="QR creator" />
                                        @endif
                                        <div class="sig-name">{{ $signs->get('creator')?->user_name ?? '' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="sig-box">
                                        @if(!empty($qrByRole['user'] ?? null))
                                                <img class="qr" src="{{ $qrByRole['user'] }}" alt="QR user" />
                                        @elseif(!empty($qrSvgDataUriByRole['user'] ?? null))
                                                <img class="qr" src="{{ $qrSvgDataUriByRole['user'] }}" alt="QR user" />
                                        @elseif(!empty($qrSvgByRole['user'] ?? null))
                                                <div class="qr" style="width:50px;height:50px;">{!! $qrSvgByRole['user'] !!}</div>
                                        @elseif(isset($document) && method_exists($document, 'getRouteKey') && empty($pdfMode))
                                                <img class="qr" src="{{ route('documents.qr.svg', [$document, 'user']) }}" alt="QR user" />
                                        @endif
                                        <div class="sig-name">{{ $signs->get('user')?->user_name ?? '' }}</div>
                                    </div>
                                </td>
                            </tr>
                        @endif
        </table>
    </div>
        
        @php($signUserModel = $sigUser?->user)
        @php($deptName = $signUserModel?->department?->name)
        @php($nama = $sigUser?->user_name ?: '')
        @php($nik = $signUserModel?->employee_num)
        @php($jabatan = $document->position)
        @php($departemen = $deptName)
        @php($lokasi = $document->location)

        <div class="page-break"></div>
    @if(strtolower($document->type)==='asset')
    <div class="statement">
            <div class="head" style="padding-top:15pt;padding-bottom:10pt;">SURAT PERNYATAAN</div>
            <div class="body">
                <p>Saya yang bertanda tangan di bawah ini:</p>
                <div class="kv" style="padding:10pt 0;">
                    <div style="padding-left: 32pt;">Nama</div><div>: {{ $nama }}</div>
                    <div style="padding-left: 32pt;">Nomor Induk Karyawan</div><div>: {{ $nik ?: '' }}</div>
                    <div style="padding-left: 32pt;">Jabatan</div><div>: {{ $jabatan ?: '' }}</div>
                    <div style="padding-left: 32pt;">Departemen</div><div>: {{ $departemen ?: '' }}</div>
                    <div style="padding-left: 32pt;">Lokasi Kerja</div><div>: {{ $lokasi ?: '' }}</div>
                </div>
                <p style="padding-bottom:5pt;"><strong style="padding:0 15pt; "></strong>Menyatakan bahwa saya telah membaca, memahami, menerima dan akan mematuhi ketentuan-ketentuan perihal penggunaan Perangkat Elektronik (termasuk namun tidak terbatas pada perangkat komputer baik yang berupa <em>Desktop</em> maupun <em>Laptop</em> beserta seluruh aksesoris penunjangnya berupa <em>monitor, keyboard, mouse</em> dan lain sebagainya) sebagaimana ditetapkan oleh PT ABC Kogen Dairy ("AKD") kepada seluruh Pekerjanya sebagai berikut:</p>
                <ol style="padding-left:20pt">
                    <li style="padding-left:5pt; padding-bottom:3pt;">Perangkat Elektronik yang disediakan oleh AKD untuk Pekerjanya adalah merupakan fasilitas yang diberikan sebagai penunjang produktifitas kerja selama bekerja di AKD dengan status pinjam pakai.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Perangkat Elektronik berupa komputer dan/atau laptop yang disediakan oleh AKD telah dilengkapi dengan perangkat lunak (<em>software</em>) memadai yang diperlukan oleh Pekerja selama penggunaan Perangkat Elektronik tersebut.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja wajib untuk menjaga dan merawat seluruh Perangkat Elektronik yang dipinjamkan oleh AKD kepadanya.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">AKD adalah perusahaan yang menganut sistem <em>Good Corporate Governance</em> serta menghormati Hak Cipta (Lisensi) dan Hukum, sehingga semua Perangkat Elektronik baik perangkat keras (<em>hardware</em>) maupun <em>software</em> yang dibeli oleh AKD adalah asli (orisinil) yang dibeli dari Distributor resmi.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Seluruh Perangkat Elektronik beserta aksesoris dan <em>software</em> yang <em>ter-install</em> di dalamnya adalah milik AKD, sehingga AKD berhak untuk mengambil kembali perangkat tersebut sewaktu-waktu tanpa harus meminta persetujuan dari Pekerja selaku <em>user</em>.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja wajib menjaga dan memelihara Perangkat Elektronik beserta aksesoris, <em>software</em> yang <em>ter-install</em> di dalamnya, data, dokumen, <em>file</em>, <em>user id</em>, <em>password</em> dengan sebaik-baiknya.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja dilarang untuk menyalahi-gunakan dalam bentuk apapun dan/atau menyalahgunakan seluruh data yang tersimpan dalam Perangkat Elektronik kepada pihak manapun di luar AKD.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja dilarang untuk menggunakan Perangkat Elektronik beserta aksesoris, <em>software</em> yang <em>ter-install</em> di dalamnya untuk melakukan hal-hal yang bertentangan dengan hukum yang berlaku maupun hal-hal yang tidak etis serta melanggar norma kesusilaan.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja dilarang untuk menambah dan/atau mengurangi serta memodifikasi <em>software</em> yang <em>ter-install</em> dalam Perangkat Elektronik tanpa persetujuan tertulis dari IT &amp; Business Support Department.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Pekerja dilarang untuk memindahtangankan dan/atau meminjamkan Perangkat Elektronik yang disediakan AKD kepada pihak manapun tanpa persetujuan tertulis dari atasan langsung dan Departemen IT &amp; Business Support Department.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">AKD, berdasarkan diskresinya, berhak dan memiliki wewenang secara penuh untuk melakukan audit dan/atau pemeriksaan sewaktu-waktu terhadap Perangkat Elektronik beserta aksesoris dan <em>software</em> yang <em>ter-install</em> di dalamnya tanpa harus meminta persetujuan dari Pekerja selaku <em>user</em>, termasuk dalam hal ini melakukan akses dan/atau <em>remote access</em> terhadap <em>file</em>, data dan e-mail yang terdapat di dalam Desktop dan/atau Laptop Pekerja.</li>
                    <li style="padding-left:5pt; padding-bottom:3pt;">Atas permintaan AKD, Pekerja wajib untuk mengembalikan Perangkat Elektronik yang ada padanya kepada AKD sesuai tenggang waktu pengembalian yang ditentukan oleh AKD.</li>
                </ol>
                <p><strong style="padding:0 15pt;"></strong>Apabila saya tidak mematuhi dan/atau melanggar ketentuan sebagaimana diatur dalam Surat Pernyataan ini, Peraturan Perusahaan, SK Direksi dan Internal Memo beserta pedoman etika bisnis (<em>code of business conduct</em>) yang diterbitkan oleh AKD dari waktu ke waktu, maka saya bersedia untuk dikenakan sanksi sesuai yang ditetapkan oleh AKD, termasuk sanksi Pemutusan Hubungan Kerja (PHK). Segala akibat yang akan timbul baik secara perdata maupun pidana akan sepenuhnya menjadi tanggung jawab saya dan saya dengan ini membebaskan AKD dari seluruh tuntutan maupun tanggung jawab baik secara pidana maupun perdata atas terjadinya hal-hal tersebut.</p>
                <p><strong style="padding:0 15pt;"></strong>Demikian Surat Pernyataan ini saya buat secara sadar, tanpa paksaan serta saya setujui. Saya memberikan persetujuan tertulis saya atas seluruh isi dari Surat Pernyataan ini, untuk selanjutnya seluruh isi dari Surat Pernyataan ini mengikat saya secara hukum untuk dapat dipergunakan sebagaimana mestinya.</p>
                <div>
                    <div style="width:100%; justify-content: right; display: flex; margin-top: 12pt;">
                            <div style="width:100pt; text-align:center">
                                Yang Menyatakan,
                                    <div class="sig-box">
                                        @if(!empty($qrByRole['user'] ?? null))
                                            <img class="qr" src="{{ $qrByRole['user'] }}" alt="QR user" />
                                        @elseif(!empty($qrSvgDataUriByRole['user'] ?? null))
                                            <img class="qr" src="{{ $qrSvgDataUriByRole['user'] }}" alt="QR user" />
                                        @elseif(!empty($qrSvgByRole['user'] ?? null))
                                            <div class="qr" style="width:50px;height:50px;">{!! $qrSvgByRole['user'] !!}</div>
                                        @elseif(isset($document) && method_exists($document, 'getRouteKey') && empty($pdfMode))
                                            <img class="qr" src="{{ route('documents.qr.svg', [$document, 'user']) }}" alt="QR user" />
                                        @endif
                                    <div class="sig-name">{{ $sigUser?->user_name ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endif
        
    
    </div>
</body>
</html>
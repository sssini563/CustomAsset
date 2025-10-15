<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document Print - {{ $document->document_number }}</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    .container{max-width:180mm;background:white}
    .document-header{padding:10pt 0 8pt 0;margin-bottom:12pt;text-align:center;border-bottom:0.75pt solid #D0D0D0}
    .header-table{width:100%;border-collapse:separate;border-spacing:0}
    .header-table td{vertical-align:middle}
    .logo-section{width:45mm;text-align:center}
  .doc-info-section{width:45mm;text-align:left}
  /* Screen/default logo sizing to match asset */
  .logo-section img{max-height:20mm;max-width:100%;width:auto;display:block;margin:0 auto}
  /* Smaller font for signature header cells */
  .sig-head{font-size:8pt}
    .title-section h3{margin:0 0 1pt 0;font-weight:700;font-size:14pt;color:#212529;letter-spacing:-.02em}
    .title-section h4{margin:2pt 0 0 0;font-size:11pt;color:#6C757D;font-weight:400}
  .doc-info-table{width:100%;border-collapse:collapse;table-layout:fixed}
  .doc-info-table td{border:none;border-bottom:.25pt solid #E9ECEF;padding:1.5pt 2pt;font-size:7pt}
  .doc-info-table .label-cell{font-weight:500;color:#6C757D;background:#F8F9FA;padding-right:2mm;width:30mm;min-width:30mm;max-width:30mm;white-space:nowrap}
  .doc-info-table .colon-cell{width:4mm;min-width:4mm;max-width:4mm;text-align:center;white-space:nowrap}
  .main-table{width:100%;border-collapse:collapse;margin-bottom:6pt;font-size:6.8pt;page-break-inside:avoid;border-spacing:0;table-layout:fixed}
  .main-table td{border:none;border-bottom:.6pt solid #CFCFCF!important;padding:2.6pt 4.5pt;vertical-align:top;background:white!important}
  .main-table .header-row{background:#F0F2F5;color:#212529;font-weight:600;text-align:center;font-size:8pt;text-transform:uppercase;letter-spacing:.05em;border-bottom:.5pt solid #D0D0D0}
  .main-table .label-cell{font-weight:500;width:40mm;min-width:40mm;max-width:40mm;color:#495057;padding-right:1.5mm;text-align:left;white-space:nowrap}
  .main-table .colon-cell{width:5mm;min-width:5mm;max-width:5mm;text-align:center;white-space:nowrap}
    .sig-name{font-weight:600;margin-top:6pt;text-align:center}
    .sig-box{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100px}
    .qr{width:72px;height:72px;display:block;margin:0 auto}
  @media print{ @page{ size:A4; margin:10mm 10mm } body{ background:white!important;padding:0;margin:0;font-size:7pt;-webkit-print-color-adjust:exact;print-color-adjust:exact } .qr{width:18mm;height:18mm} .logo-section img{max-height:20mm;max-width:100%;width:auto;display:block;margin:0 auto} .sig-head{font-size:6.8pt!important} }
  </style>
</head>
<body>
  <div class="container">
    @php
      $settings = \App\Models\Setting::getSettings();
      $logoDataUri = null; $logoUrl = null; $siteLogo = $settings->logo ?? ($settings->email_logo ?? null);
      if ($siteLogo) {
        if (preg_match('#^https?://#i', $siteLogo)) { $logoUrl = $siteLogo; }
        else { $siteLogo = ltrim($siteLogo,'/'); $p = public_path('uploads/'.$siteLogo); if ($p && is_file($p)) { $ext = strtolower(pathinfo($p, PATHINFO_EXTENSION)); $mime = ($ext==='svg'||$ext==='svgz')?'image/svg+xml':('image/'.($ext?:'png')); $logoDataUri = 'data:'.$mime.';base64,'.base64_encode(file_get_contents($p)); } else { $logoUrl = asset('/uploads/'.$siteLogo); } }
      }
      $signs = $document->signatures->keyBy('role');
      $sigCreator = $signs->get('creator');
      $sigUser = $signs->get('user');
      $fmtId = function($date){ if(!$date) return ''; try{ if(is_string($date)){ $date = \Carbon\Carbon::parse($date);} }catch(\Throwable $e){} $m=[1=>'januari',2=>'februari',3=>'maret',4=>'april',5=>'mei',6=>'juni',7=>'juli',8=>'agustus',9=>'september',10=>'oktober',11=>'november',12=>'desember']; return ((int)$date->day).' '.($m[(int)$date->month]??'').' '.((int)$date->year); };
    @endphp
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
              <tr><td class="label-cell">Doc. Control No</td><td class="colon-cell">:</td><td>{{ $document->doc_control_no ?: '' }}</td></tr>
              <tr><td class="label-cell">Created Doc</td><td class="colon-cell">:</td><td>{{ $document->created_doc ? $document->created_doc->format('d M Y') : '' }}</td></tr>
              <tr><td class="label-cell">Effective Doc</td><td class="colon-cell">:</td><td>{{ $document->effective_doc ? $document->effective_doc->format('d M Y') : '' }}</td></tr>
              <tr><td class="label-cell">Revision No</td><td class="colon-cell">:</td><td>{{ $document->revision_no ?: '' }}</td></tr>
              <tr><td class="label-cell">Revision Date</td><td class="colon-cell">:</td><td>{{ $document->revision_date ? $document->revision_date->format('d M Y') : '' }}</td></tr>
              <tr><td class="label-cell">Author Doc</td><td class="colon-cell">:</td><td>{{ $document->author_doc ?: '' }}</td></tr>
            </table>
          </td>
        </tr>
      </table>
    </div>

    <table class="main-table">
      <colgroup>
        <col style="width:40mm" />
        <col style="width:5mm" />
        <col />
        <col style="width:40mm" />
        <col style="width:5mm" />
        <col />
      </colgroup>
      <tr><td colspan="6" class="header-row">Header Information</td></tr>
      <tr>
        <td class="label-cell">No Tanda Terima</td><td class="colon-cell">:</td><td>{{ $document->document_number }}</td>
        <td class="label-cell">Organization Structure</td><td class="colon-cell">:</td><td>{{ $document->organization_structure ?: '' }}</td>
      </tr>
      <tr>
        <td class="label-cell">Document Number</td><td class="colon-cell">:</td><td>{{ $document->document_no ?: '' }}</td>
        <td class="label-cell">Position</td><td class="colon-cell">:</td><td>{{ $document->position ?: '' }}</td>
      </tr>
      <tr>
        <td class="label-cell">Document Date</td><td class="colon-cell">:</td><td>{{ $fmtId($document->document_date) }}</td>
        <td class="label-cell">Location</td><td class="colon-cell">:</td><td>{{ $document->location ?: '' }}</td>
      </tr>
      <tr>
        <td class="label-cell">Requestor & ID</td><td class="colon-cell">:</td><td colspan="4">{{ $sigUser?->user_name ?? ($document->nama_penerima ?: ($document->requestor ?: '')) }}</td>
      </tr>
    </table>

    <table class="main-table">
      <colgroup>
        <col style="width:40mm" />
        <col style="width:5mm" />
        <col />
      </colgroup>
      <tr><td colspan="3" class="header-row">License Details</td></tr>
      <tr><td class="label-cell">License Key</td><td class="colon-cell">:</td><td>{{ $document->license_key ?: '' }}</td></tr>
      <tr><td class="label-cell">Seats</td><td class="colon-cell">:</td><td>{{ $document->license_seats ?: '' }}</td></tr>
      <tr><td class="label-cell">Vendor</td><td class="colon-cell">:</td><td>{{ $document->license_vendor ?: '' }}</td></tr>
      <tr><td class="label-cell">Expiry Date</td><td class="colon-cell">:</td><td>{{ optional($document->license_expires_at)->format('d M Y') }}</td></tr>
      <tr><td class="label-cell">Catatan</td><td class="colon-cell">:</td><td>{{ $document->catatan ?: '' }}</td></tr>
    </table>

    <table class="main-table">
      <tr>
  <td class="header-row sig-head" style="text-align:center;">Created By<br>Creator</td>
  <td class="header-row sig-head" style="text-align:center;">Approved By<br>User</td>
      </tr>
      <tr class="signatures-row" style="height:110px;">
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
      </tr>
    </table>
  </div>
</body>
</html>

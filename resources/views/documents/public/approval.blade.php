<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Approval • {{ $document->document_number }}</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    :root{
      --bg:#f6f7f9; --card:#ffffff; --text:#1f2937; --muted:#6b7280; --border:#e5e7eb;
      --primary:#2563eb; --primary-600:#1d4ed8; --danger:#e11d48; --danger-600:#be123c;
      --success:#16a34a; --radius:12px; --shadow:0 10px 22px rgba(0,0,0,.06);
    }
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);color:var(--text);font:400 15px/1.55 system-ui,-apple-system,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial}
    .wrap{max-width:860px;margin:28px auto;padding:0 16px}
    .card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden}
    .header{display:flex;gap:14px;align-items:center;padding:18px 20px;border-bottom:1px solid var(--border)}
    .brand{display:flex;gap:12px;align-items:center;min-height:40px}
    .brand img{height:36px;object-fit:contain}
    .title{margin:0;font-weight:700;font-size:18px}
    .sub{color:var(--muted);font-size:13px;margin-top:2px}
    .pill{display:inline-flex;align-items:center;gap:6px;padding:3px 8px;border-radius:999px;font-size:12px}
    .pill.pending{background:#eef2ff;color:#3730a3}
    .pill.signed{background:#ecfdf5;color:#065f46}
    .pill.rejected{background:#fef2f2;color:#991b1b}
    .content{padding:18px 20px}
    h3{margin:0 0 12px 0;font-size:14px;letter-spacing:.02em;color:#374151}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:8px 16px}
    .row{display:contents}
    .k{color:var(--muted);font-size:13px}
    .v{background:#fafafa;border:1px solid var(--border);border-radius:8px;padding:8px 10px;min-height:34px}
    .footnote{margin-top:12px;color:var(--muted);font-size:12px}
    .alerts{padding:0 20px}
    .alert{margin:14px 0;padding:10px 12px;border-radius:10px}
    .alert-success{background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0}
    .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
  .actions{padding:18px 20px;border-top:1px solid var(--border);background:linear-gradient(#fff, #fcfcfc)}
  .actions-row{display:flex;gap:16px;align-items:center;justify-content:space-between}
  .actions-left{display:flex;align-items:center;gap:10px}
  .actions-right{margin-left:auto;text-align:right;display:flex;align-items:center;gap:8px}
  .reject-row{display:flex;align-items:center;gap:8px}
  .signature-info{margin-top:12px;color:var(--text);font-size:14px;font-weight:700}
    .btn{appearance:none;border:none;border-radius:10px;padding:10px 14px;cursor:pointer;font-weight:700;letter-spacing:.2px;transition:.15s all ease}
    .btn-lg{padding:12px 18px;font-size:16px}
    .btn-primary{background:var(--primary);color:#fff}
    .btn-primary:hover{background:var(--primary-600)}
    .btn-danger{background:var(--danger);color:#fff}
    .btn-danger:hover{background:var(--danger-600)}
    .input{width:260px;max-width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:10px;font:inherit}
  .statement{margin-top:16px;border:1px solid var(--border);border-radius:10px;background:#fff}
  .statement .head{padding:14px 16px;border-bottom:1px solid var(--border);text-align:center;font-weight:800}
  .statement .body{padding:16px 18px;color:#111}
  .statement .body p{margin:0 0 10px 0}
  .statement .body ol{margin:8px 0 8px 20px}
  .statement .kv{display:grid;grid-template-columns:160px 1fr;gap:6px 10px;margin:10px 0 14px 0}
  .agree-box{display:flex;align-items:flex-start;gap:10px;margin-top:14px;background:#f9fafb;border:1px dashed var(--border);padding:10px;border-radius:10px}
  .muted{color:var(--muted)}
    @media (max-width:720px){
      .grid{grid-template-columns:1fr}
      .v{min-height:unset}
      .actions-row{flex-direction:column;align-items:stretch}
      .actions-left,.actions-right{width:100%}
      .actions-right{margin-left:0;text-align:left}
      .reject-row{flex-direction:column;align-items:stretch}
      .actions form{width:100%}
      .btn,.input{width:100%}
    }
  </style>
  @php($settings = \App\Models\Setting::getSettings())
  @php($statusClass = $signature->status === 'signed' ? 'signed' : ($signature->status === 'rejected' ? 'rejected' : 'pending'))
  @php($roleName = ucfirst(str_replace('_',' ', $signature->role)))
  @php($documentDate = $document->document_date ? $document->document_date->format('d M Y') : '')
  @php($signUser = $signature->user)
  @php($deptName = $signUser?->department?->name)
  @php($reqName = $document->requestor ?: '')
  @php($typeLower = strtolower($document->type ?? 'asset'))
</head>
<body>
  <div class="wrap">
    <div class="card">
      <div class="header">
        <div class="brand">
          @if(!empty($settings) && !empty($settings->brand) && !empty($settings->brand['logo']))
            <img src="{{ asset('/uploads/'.ltrim($settings->brand['logo'],'/')) }}" alt="Logo">
          @endif
          <div>
            <h1 class="title">Approval • {{ $document->document_number }}</h1>
            <div class="sub">
              Status: <span class="pill {{ $statusClass }}">{{ $signature->status }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="alerts">
        @if(session('status'))
          <div class="alert alert-success"><i class="fa fa-check"></i> {{ session('status') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-error"><i class="fa fa-exclamation-triangle"></i> {{ $errors->first() }}</div>
        @endif
      </div>

      <div class="content">
        <h3>Detail Dokumen</h3>
        @includeIf('documents.public.details.' . $typeLower, ['document' => $document, 'documentDate' => $documentDate, 'reqName' => $reqName])
        @if($typeLower === 'asset' && $signature->role === 'user' && $signature->status === 'pending')
          @php(
            $nama = $signUser?->present()?->fullName ?? ($signature->user_name ?: '')
          )
          @php($nik = $signUser?->employee_num)
          @php($jabatan = $document->position)
          @php($departemen = $deptName)
          @php($lokasi = $document->location)
          <div class="statement" aria-labelledby="statement-title">
            <div class="head" id="statement-title">SURAT PERNYATAAN</div>
            <div class="body">
              <p>Saya yang bertanda tangan di bawah ini:</p>
              <div class="kv">
                <div>Nama</div><div>: {{ $nama }}</div>
                <div>Nomor Induk Karyawan (NIK)</div><div>: {{ $nik ?: '—' }}</div>
                <div>Jabatan</div><div>: {{ $jabatan ?: '—' }}</div>
                <div>Departemen</div><div>: {{ $departemen ?: '—' }}</div>
                <div>Lokasi Kerja</div><div>: {{ $lokasi ?: '—' }}</div>
              </div>
              <p>Menyatakan bahwa saya telah membaca, memahami, menerima dan akan mematuhi ketentuan-ketentuan perihal penggunaan Perangkat Elektronik (termasuk namun tidak terbatas pada perangkat komputer baik yang berupa <em>Desktop</em> maupun <em>Laptop</em> beserta seluruh aksesoris penunjangnya berupa <em>monitor, keyboard, mouse</em> dan lain sebagainya) sebagaimana ditetapkan oleh PT ABC Kogen Dairy ("AKD") kepada seluruh Pekerjanya sebagai berikut:</p>
              <ol>
                <li>Perangkat Elektronik yang disediakan oleh AKD untuk Pekerjanya adalah merupakan fasilitas yang diberikan sebagai penunjang produktifitas kerja selama bekerja di AKD dengan status pinjam pakai.</li>
                <li>Perangkat Elektronik berupa komputer dan/atau laptop yang disediakan oleh AKD telah dilengkapi dengan perangkat lunak (<em>software</em>) memadai yang diperlukan oleh Pekerja selama penggunaan Perangkat Elektronik tersebut.</li>
                <li>Pekerja wajib untuk menjaga dan merawat seluruh Perangkat Elektronik yang dipinjamkan oleh AKD kepadanya.</li>
                <li>AKD adalah perusahaan yang menganut sistem <em>Good Corporate Governance</em> serta menghormati Hak Cipta (Lisensi) dan Hukum, sehingga semua Perangkat Elektronik baik perangkat keras (<em>hardware</em>) maupun <em>software</em> yang dibeli oleh AKD adalah asli (orisinil) yang dibeli dari Distributor resmi.</li>
                <li>Seluruh Perangkat Elektronik beserta aksesoris dan <em>software</em> yang <em>ter-install</em> di dalamnya adalah milik AKD, sehingga AKD berhak untuk mengambil kembali perangkat tersebut sewaktu-waktu tanpa harus meminta persetujuan dari Pekerja selaku <em>user</em>.</li>
                <li>Pekerja wajib menjaga dan memelihara Perangkat Elektronik beserta aksesoris, <em>software</em> yang <em>ter-install</em> di dalamnya, data, dokumen, <em>file</em>, <em>user id</em>, <em>password</em> dengan sebaik-baiknya.</li>
                <li>Pekerja dilarang untuk menyalahi-gunakan dalam bentuk apapun dan/atau menyalahgunakan seluruh data yang tersimpan dalam Perangkat Elektronik kepada pihak manapun di luar AKD.</li>
                <li>Pekerja dilarang untuk menggunakan Perangkat Elektronik beserta aksesoris, <em>software</em> yang <em>ter-install</em> di dalamnya untuk melakukan hal-hal yang bertentangan dengan hukum yang berlaku maupun hal-hal yang tidak etis serta melanggar norma kesusilaan.</li>
                <li>Pekerja dilarang untuk menambah dan/atau mengurangi serta memodifikasi <em>software</em> yang <em>ter-install</em> dalam Perangkat Elektronik tanpa persetujuan tertulis dari IT &amp; Business Support Department.</li>
                <li>Pekerja dilarang untuk memindahtangankan dan/atau meminjamkan Perangkat Elektronik yang disediakan AKD kepada pihak manapun tanpa persetujuan tertulis dari atasan langsung dan Departemen IT &amp; Business Support Department.</li>
                <li>AKD, berdasarkan diskresinya, berhak dan memiliki wewenang secara penuh untuk melakukan audit dan/atau pemeriksaan sewaktu-waktu terhadap Perangkat Elektronik beserta aksesoris dan <em>software</em> yang <em>ter-install</em> di dalamnya tanpa harus meminta persetujuan dari Pekerja selaku <em>user</em>, termasuk dalam hal ini melakukan akses dan/atau <em>remote access</em> terhadap <em>file</em>, data dan e-mail yang terdapat di dalam Desktop dan/atau Laptop Pekerja.</li>
                <li>Atas permintaan AKD, Pekerja wajib untuk mengembalikan Perangkat Elektronik yang ada padanya kepada AKD sesuai tenggang waktu pengembalian yang ditentukan oleh AKD.</li>
              </ol>
              <p>Apabila saya tidak mematuhi dan/atau melanggar ketentuan sebagaimana diatur dalam Surat Pernyataan ini, Peraturan Perusahaan, SK Direksi dan Internal Memo beserta pedoman etika bisnis (<em>code of business conduct</em>) yang diterbitkan oleh AKD dari waktu ke waktu, maka saya bersedia untuk dikenakan sanksi sesuai yang ditetapkan oleh AKD, termasuk sanksi Pemutusan Hubungan Kerja (PHK). Segala akibat yang akan timbul baik secara perdata maupun pidana akan sepenuhnya menjadi tanggung jawab saya dan saya dengan ini membebaskan AKD dari seluruh tuntutan maupun tanggung jawab baik secara pidana maupun perdata atas terjadinya hal-hal tersebut.</p>
              <p>Demikian Surat Pernyataan ini saya buat secara sadar, tanpa paksaan serta saya setujui. Saya memberikan persetujuan tertulis saya atas seluruh isi dari Surat Pernyataan ini, untuk selanjutnya seluruh isi dari Surat Pernyataan ini mengikat saya secara hukum untuk dapat dipergunakan sebagaimana mestinya.</p>
              <div class="muted" style="margin-top:8px;">Yang Menyatakan: <strong>{{ $nama }}</strong></div>
              <div class="agree-box">
                <input id="agree" type="checkbox" aria-describedby="agree-help">
                <label for="agree"><strong>Saya telah membaca dan setuju</strong> dengan seluruh isi Surat Pernyataan di atas.</label>
              </div>
              <div id="agree-help" class="muted">Centang kotak persetujuan untuk mengaktifkan tombol Approve.</div>
            </div>
          </div>
        @endif
      </div>

      <div class="actions">
        @if($canAct)
          <div class="actions-row">
            <div class="actions-left">
              <form method="post" action="{{ route('public.documents.approval.approve', [$signature->public_token]) }}">@csrf
                <button id="approve-btn" class="btn btn-primary btn-lg" type="submit" aria-label="Setujui dokumen">
                  <i class="fa fa-check"></i> Approve
                </button>
              </form>
            </div>
            <div class="actions-right">
              <form method="post" action="{{ route('public.documents.approval.reject', [$signature->public_token]) }}" onsubmit="if(!this.note.value.trim()){alert('Mohon isi alasan reject');this.note.focus();return false}">@csrf
                <div class="reject-row">
                  <input class="input" type="text" name="note" placeholder="Alasan reject (wajib)" aria-label="Alasan penolakan" />
                  <button id="reject-btn" class="btn btn-danger" type="submit" aria-label="Tolak dokumen"><i class="fa fa-times"></i> Reject</button>
                </div>
              </form>
            </div>
          </div>
        @endif
        <div class="signature-info">Penandatangan: {{ $signature->user_name ?: '—' }}</div>
        @unless($canAct)
          <div class="sub">Status: {{ $signature->status }}.</div>
        @endunless
      </div>
    </div>
  </div>
  <script>
  (function(){
    var approveBtn = document.getElementById('approve-btn');
    var rejectBtn = document.getElementById('reject-btn');
    var agree = document.getElementById('agree');
    var canAct = {{ $canAct ? 'true' : 'false' }};
    // Bind consent gating only when the statement/agree box is present (user role & pending)
    if (approveBtn && agree) {
      var toggle = function(){ approveBtn.disabled = !agree.checked; };
      agree.addEventListener('change', toggle);
      toggle();
    }
    if (approveBtn) approveBtn.addEventListener('click', function(e){ if (approveBtn.disabled) { e.preventDefault(); } });
    if (rejectBtn) rejectBtn.addEventListener('click', function(e){ if (rejectBtn.disabled) { e.preventDefault(); } });
  })();
  </script>
</body>
</html>

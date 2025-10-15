<div class="grid">
  <div class="row"><div class="k">No Tanda Terima</div><div class="v">{{ $document->document_number }}</div></div>
  <div class="row"><div class="k">Tanggal</div><div class="v">{{ $documentDate }}</div></div>

  <div class="row"><div class="k">Nama Penerima</div><div class="v">{{ $document->nama_penerima ?: '' }}</div></div>
  <div class="row"><div class="k">Atasan Penerima</div><div class="v">{{ $document->atasan_penerima_name }}</div></div>

  <div class="row"><div class="k">Asset Number</div><div class="v">{{ $document->asset_number }}</div></div>
  <div class="row"><div class="k">Serial Number</div><div class="v">{{ $document->serial_number }}</div></div>

  <div class="row"><div class="k">Device Name</div><div class="v">{{ $document->device_name }}</div></div>
  <div class="row"><div class="k">Merk</div><div class="v">{{ $document->merk }}</div></div>

  <div class="row"><div class="k">Location</div><div class="v">{{ $document->location }}</div></div>
  <div class="row"><div class="k">Requestor</div><div class="v">{{ $reqName }}</div></div>
</div>

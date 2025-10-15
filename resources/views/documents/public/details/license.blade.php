<div class="grid">
  <div class="row"><div class="k">No Tanda Terima</div><div class="v">{{ $document->document_number }}</div></div>
  <div class="row"><div class="k">Tanggal</div><div class="v">{{ $documentDate }}</div></div>

  <div class="row"><div class="k">License Key</div><div class="v">{{ $document->license_key ?: '' }}</div></div>
  <div class="row"><div class="k">Seats</div><div class="v">{{ $document->license_seats ?: '' }}</div></div>
  <div class="row"><div class="k">Vendor</div><div class="v">{{ $document->license_vendor ?: '' }}</div></div>
  <div class="row"><div class="k">Expiry Date</div><div class="v">{{ optional($document->license_expires_at)->format('d M Y') }}</div></div>
  <div class="row"><div class="k">Catatan</div><div class="v">{{ $document->catatan ?: '' }}</div></div>

  <div class="row"><div class="k">Location</div><div class="v">{{ $document->location }}</div></div>
  <div class="row"><div class="k">Requestor</div><div class="v">{{ $reqName }}</div></div>
</div>

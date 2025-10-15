<div class="grid">
  <div class="row"><div class="k">No Tanda Terima</div><div class="v">{{ $document->document_number }}</div></div>
  <div class="row"><div class="k">Tanggal</div><div class="v">{{ $documentDate }}</div></div>

  <div class="row"><div class="k">Model</div><div class="v">{{ $document->component_model ?: '' }}</div></div>
  <div class="row"><div class="k">Part No</div><div class="v">{{ $document->component_part_number ?: '' }}</div></div>
  <div class="row"><div class="k">Serial Number</div><div class="v">{{ $document->component_serial_number ?: '' }}</div></div>
  <div class="row"><div class="k">Spec</div><div class="v">{{ $document->component_spec ?: '' }}</div></div>
  <div class="row"><div class="k">Catatan</div><div class="v">{{ $document->catatan ?: '' }}</div></div>

  <div class="row"><div class="k">Location</div><div class="v">{{ $document->location }}</div></div>
  <div class="row"><div class="k">Requestor</div><div class="v">{{ $reqName }}</div></div>
</div>

<div class="grid">
  <div class="row"><div class="k">No Tanda Terima</div><div class="v">{{ $document->document_number }}</div></div>
  <div class="row"><div class="k">Tanggal</div><div class="v">{{ $documentDate }}</div></div>

  <div class="row"><div class="k">Part Number</div><div class="v">{{ $document->accessory_part_number ?: '' }}</div></div>
  <div class="row"><div class="k">Serial Number</div><div class="v">{{ $document->accessory_serial_number ?: '' }}</div></div>
  <div class="row"><div class="k">Condition</div><div class="v">{{ $document->accessory_condition ?: '' }}</div></div>
  @if(!empty($document->accessory_notes))
    <div class="row"><div class="k">Notes</div><div class="v">{{ $document->accessory_notes }}</div></div>
  @endif
  <div class="row"><div class="k">Catatan</div><div class="v">{{ $document->catatan ?: '' }}</div></div>

  <div class="row"><div class="k">Location</div><div class="v">{{ $document->location }}</div></div>
  <div class="row"><div class="k">Requestor</div><div class="v">{{ $reqName }}</div></div>
</div>

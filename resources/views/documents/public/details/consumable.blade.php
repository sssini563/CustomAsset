<div class="grid">
  <div class="row"><div class="k">No Tanda Terima</div><div class="v">{{ $document->document_number }}</div></div>
  <div class="row"><div class="k">Tanggal</div><div class="v">{{ $documentDate }}</div></div>

  <div class="row"><div class="k">Batch</div><div class="v">{{ $document->consumable_batch ?: '' }}</div></div>
  <div class="row"><div class="k">Qty</div><div class="v">{{ $document->consumable_qty ?: '' }}</div></div>
  <div class="row"><div class="k">Unit</div><div class="v">{{ $document->consumable_unit ?: '' }}</div></div>
  @if(!empty($document->consumable_notes))
    <div class="row"><div class="k">Notes</div><div class="v">{{ $document->consumable_notes }}</div></div>
  @endif
  <div class="row"><div class="k">Catatan</div><div class="v">{{ $document->catatan ?: '' }}</div></div>

  <div class="row"><div class="k">Location</div><div class="v">{{ $document->location }}</div></div>
  <div class="row"><div class="k">Requestor</div><div class="v">{{ $reqName }}</div></div>
</div>

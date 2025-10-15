<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title"><i class="fa fa-file-text-o text-info"></i> Detail License <strong>{{ $document->document_number }}</strong>
    @php($statusClass = match($document->overall_status){ 'signed'=>'label-success','rejected'=>'label-danger', default=>'label-warning'})
    <span class="label {{ $statusClass }}" style="margin-left:8px;vertical-align:middle;">{{ $document->overall_status }}</span>
  </h4>
</div>
<div class="modal-body doc-detail-modal">
  <div class="detail-section">
    <h5><i class="fa fa-id-badge"></i> Header Information</h5>
    <div class="doc-detail-grid">
      <div class="doc-detail-item"><dt>No Tanda Terima</dt><dd>{{ $document->document_number }}</dd></div>
      <div class="doc-detail-item"><dt>Organization Structure</dt><dd>{{ $document->organization_structure ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Document Number</dt><dd>{{ $document->document_no ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Position</dt><dd>{{ $document->position ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Document Date</dt><dd>{{ $document->document_date?->format('d M Y') }}</dd></div>
      <div class="doc-detail-item"><dt>Location</dt><dd>{{ $document->location ?: '' }}</dd></div>
      @php($signs = $document->signatures->keyBy('role'))
      <div class="doc-detail-item"><dt>Requestor &amp; ID</dt><dd>{{ $signs->get('user')?->user_name ?: ($document->nama_penerima ?: $document->requestor) }}</dd></div>
    </div>
  </div>
  <div class="detail-section">
    <h5><i class="fa fa-key"></i> License Details</h5>
    <div class="doc-detail-grid">
      <div class="doc-detail-item"><dt>License Key</dt><dd>{{ $document->license_key ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Seats</dt><dd>{{ $document->license_seats ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Vendor</dt><dd>{{ $document->license_vendor ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Expiry Date</dt><dd>{{ $document->license_expires_at?->format('d M Y') }}</dd></div>
      @if(!empty($document->catatan))
      <div class="doc-detail-item" style="width:100%"><dt>Catatan</dt><dd>{{ $document->catatan }}</dd></div>
      @endif
    </div>
  </div>
  <div class="detail-section">
    <h5><i class="fa fa-check-square-o"></i> Approvals</h5>
    <div class="doc-detail-grid">
      <div class="doc-detail-item"><dt>Creator</dt><dd>{{ $signs->get('creator')?->user_name }} <small class="text-muted">{{ $signs->get('creator')?->status }}</small></dd></div>
      <div class="doc-detail-item"><dt>User</dt><dd>{{ $signs->get('user')?->user_name }} <small class="text-muted">{{ $signs->get('user')?->status }}</small></dd></div>
    </div>
  </div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
<style>
  .doc-detail-modal{max-height:65vh;overflow:auto;padding-top:5px;}
  .doc-detail-modal .detail-section{margin-bottom:18px;padding:12px 15px;background:#fafafa;border:1px solid #e5e5e5;border-radius:4px;}
  .doc-detail-modal .detail-section h5{margin-top:0;font-weight:600;text-transform:uppercase;font-size:12px;letter-spacing:.5px;color:#555;border-bottom:1px solid #e0e0e0;padding-bottom:4px;margin-bottom:10px;}
  .doc-detail-grid{display:flex;flex-wrap:wrap;margin:0 -6px;}
  .doc-detail-item{width:50%;padding:4px 6px;display:flex;border-bottom:1px dotted #eee;}
  .doc-detail-item dt{margin:0;font-weight:600;min-width:110px;color:#333;}
  .doc-detail-item dd{margin:0;flex:1;}
  .doc-detail-item:nth-last-child(-n+2){border-bottom:none;}
  @media (max-width:640px){ .doc-detail-item{width:100%;} }
</style>

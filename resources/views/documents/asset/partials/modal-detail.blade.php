<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title"><i class="fa fa-file-text-o text-info"></i> Detail Document <strong>{{ $document->document_number }}</strong>
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
      <div class="doc-detail-item"><dt>Document Date</dt><dd>
        @php($months=[1=>'januari',2=>'februari',3=>'maret',4=>'april',5=>'mei',6=>'juni',7=>'juli',8=>'agustus',9=>'september',10=>'oktober',11=>'november',12=>'desember'])
        @if($document->document_date)
          {{ (int)$document->document_date->day }} {{ $months[(int)$document->document_date->month] ?? '' }} {{ (int)$document->document_date->year }}
        @endif
      </dd></div>
      <div class="doc-detail-item"><dt>Location</dt><dd>{{ $document->location ?: '' }}</dd></div>
  <div class="doc-detail-item"><dt>Requestor &amp; ID</dt><dd>{{ $document->requestor ?: '' }}</dd></div>
    </div>
  </div>
  <div class="detail-section">
    <h5><i class="fa fa-user"></i> Penerima</h5>
    <div class="doc-detail-grid">
  @php($signs = $document->signatures->keyBy('role'))
  <div class="doc-detail-item"><dt>Nama Penerima</dt><dd>{{ $document->nama_penerima ?: '' }}</dd></div>
  <div class="doc-detail-item"><dt>Atasan Penerima</dt><dd>{{ $document->atasan_penerima_name ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Asset Number</dt><dd>{{ $document->asset_number ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>GR Number</dt><dd>{{ $document->gr_number ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Type Asset</dt><dd>{{ $document->type_device ?: '' }}</dd></div>
    </div>
  </div>
  <div class="detail-section">
    <h5><i class="fa fa-desktop"></i> Hardware</h5>
    <div class="doc-detail-grid">
      <div class="doc-detail-item"><dt>Device Name</dt><dd>{{ $document->device_name ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Merk</dt><dd>{{ $document->merk ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Type</dt><dd>{{ $document->type_device ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Processor</dt><dd>{{ $document->processor ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Memory</dt><dd>{{ $document->memory ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Hardisk</dt><dd>{{ $document->hardisk ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Serial Number</dt><dd>{{ $document->serial_number ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Battery</dt><dd>{{ $document->battery ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Serial Number Battery</dt><dd>{{ $document->serial_number_battery ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Tas</dt><dd>{{ $document->tas ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Adaptor</dt><dd>{{ $document->adaptor ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Serial Number Adaptor</dt><dd>{{ $document->serial_number_adaptor ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Foto Device</dt><dd>{{ $document->foto_device ?: '' }}</dd></div>
    </div>
  </div>
  <div class="detail-section">
    <h5><i class="fa fa-cubes"></i> Software</h5>
    <div class="doc-detail-grid">
      <div class="doc-detail-item"><dt>Windows</dt><dd>{{ $document->windows ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Office</dt><dd>{{ $document->office ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Antivirus</dt><dd>{{ $document->antivirus ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Compress Tools</dt><dd>{{ $document->compress_tools ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Reader Tool</dt><dd>{{ $document->reader_tool ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Browser</dt><dd>{{ $document->browser ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Other Application 1</dt><dd>{{ $document->other_application_1 ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Other Application 2</dt><dd>{{ $document->other_application_2 ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Other Application 3</dt><dd>{{ $document->other_application_3 ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Other Application 4</dt><dd>{{ $document->other_application_4 ?: '' }}</dd></div>
    </div>
  </div>
  <div class="detail-section">
    <h5><i class="fa fa-file-text-o"></i> Document &amp; Notes</h5>
    <div class="doc-detail-grid">
      <div class="doc-detail-item"><dt>Dokumen Pengembalian Asset</dt><dd>{{ $document->dokumen_pengembalian_asset ?: '' }}</dd></div>
      <div class="doc-detail-item"><dt>Dokumen Surat Pernyataan</dt><dd>{{ $document->dokumen_surat_pernyataan ?: '' }}</dd></div>
      <div class="doc-detail-item" style="width:100%"><dt>Catatan</dt><dd>{{ $document->catatan ?: '' }}</dd></div>
    </div>
  </div>
  <div class="detail-section">
    <h5><i class="fa fa-info-circle"></i> Metadata</h5>
    <div class="doc-detail-grid">
      <div class="doc-detail-item"><dt>Doc Control</dt><dd>{{ $document->doc_control_no }}</dd></div>
      <div class="doc-detail-item"><dt>Created</dt><dd>{{ $document->created_doc?->format('d M Y') }}</dd></div>
      <div class="doc-detail-item"><dt>Effective</dt><dd>{{ $document->effective_doc?->format('d M Y') }}</dd></div>
      <div class="doc-detail-item"><dt>Revision No</dt><dd>{{ $document->revision_no }}</dd></div>
      <div class="doc-detail-item"><dt>Revision Date</dt><dd>{{ $document->revision_date?->format('d M Y') }}</dd></div>
      <div class="doc-detail-item"><dt>Author</dt><dd>{{ $document->author_doc }}</dd></div>
    </div>
  </div>
  <div class="detail-section">
    <h5><i class="fa fa-check-square-o"></i> Approvals</h5>
    @php($signs = $document->signatures->keyBy('role'))
    <div class="doc-detail-grid">
      <div class="doc-detail-item"><dt>Creator</dt><dd>{{ $signs->get('creator')?->user_name }} <small class="text-muted">{{ $signs->get('creator')?->status }}</small></dd></div>
      <div class="doc-detail-item"><dt>IT Manager</dt><dd>{{ $signs->get('creator_manager')?->user_name }} <small class="text-muted">{{ $signs->get('creator_manager')?->status }}</small></dd></div>
      <div class="doc-detail-item"><dt>User</dt><dd>{{ $signs->get('user')?->user_name }} <small class="text-muted">{{ $signs->get('user')?->status }}</small></dd></div>
      <div class="doc-detail-item"><dt>Atasan Penerima</dt><dd>{{ $document->atasan_penerima_name ?: $signs->get('user_manager')?->user_name }} <small class="text-muted">{{ $signs->get('user_manager')?->status }}</small></dd></div>
      <div class="doc-detail-item"><dt>HR</dt><dd>{{ $signs->get('hr')?->user_name }} <small class="text-muted">{{ $signs->get('hr')?->status }}</small></dd></div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
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
  .doc-detail-modal .well{background:#fff;border:1px solid #e5e5e5;}
</style>

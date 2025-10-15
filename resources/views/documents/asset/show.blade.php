@extends('layouts/default')
@section('title') Document {{ $document->document_number }} @stop
@section('content')
<div class="box box-default">
  <div class="box-header with-border">
  <h3 class="box-title">Document {{ $document->document_number }} ({{ $document->overall_status }})</h3>
    <div class="box-tools">
  <a href="{{ route('documents.print',$document->id) }}" target="_blank" class="btn btn-default" title="Cetak"><i class="fa fa-print"></i></a>
      @can('update', $document)
  <button class="btn btn-default" id="btn-recompute" title="Hitung Ulang Status"><i class="fa fa-refresh"></i></button>
        @php
          $legacy = ['it_manager','atasan_penerima'];
          $assignedAll = $document->signatures->reject(fn($s)=> in_array($s->role,$legacy))->filter(fn($s)=> !is_null($s->user_id));
          $canComplete = (in_array($document->overall_status,['pending','complete_sign'])) && $assignedAll->count()>0 && ($assignedAll->where('status','signed')->count()===$assignedAll->count());
        @endphp
        @if($canComplete)
          <button class="btn btn-success" id="btn-complete" title="Kunci &amp; Buat PDF"><i class="fa fa-lock"></i></button>
        @endif
      @endcan
      @if(auth()->user()->isSuperUser() && $document->overall_status==='pending')
  <a href="{{ route('documents.edit',$document->id) }}" class="btn btn-primary" title="Ubah"><i class="fa fa-pencil"></i></a>
      @endif
    </div>
  </div>
  <div class="box-body">
    <ul class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#detail" role="tab" data-toggle="tab">Detail</a></li>
      <li><a href="#approval" role="tab" data-toggle="tab">Approval</a></li>
      <li><a href="#preview" role="tab" data-toggle="tab">Print Preview</a></li>
    </ul>
    <div class="tab-content" style="margin-top:15px;">
      <div class="tab-pane active" id="detail">
        <h4>Header Information</h4>
        <table class="table table-bordered table-condensed">
          <tr>
            <th style="width:18%">No Tanda Terima</th><td style="width:32%">{{ $document->document_number }}</td>
            <th style="width:18%">Organization Structure</th><td style="width:32%">{{ $document->organization_structure ?: '' }}</td>
          </tr>
          <tr>
            <th>Document Number</th><td>{{ $document->document_no ?: '' }}</td>
            <th>Position</th><td>{{ $document->position ?: '' }}</td>
          </tr>
          <tr>
            <th>Document Date</th>
            <td>
              @php($months=[1=>'januari',2=>'februari',3=>'maret',4=>'april',5=>'mei',6=>'juni',7=>'juli',8=>'agustus',9=>'september',10=>'oktober',11=>'november',12=>'desember'])
              @if($document->document_date)
                {{ (int)$document->document_date->day }} {{ $months[(int)$document->document_date->month] ?? '' }} {{ (int)$document->document_date->year }}
              @endif
            </td>
            <th>Location</th><td>{{ $document->location ?: '' }}</td>
          </tr>
          <tr>
            <th>Requestor &amp; ID</th>
            <td colspan="3">{{ $document->requestor ?: '' }}</td>
          </tr>
        </table>

        <h4>Asset Information</h4>
        <table class="table table-bordered table-condensed">
          <tr>
            <th style="width:18%">Nama Penerima</th>
            <td style="width:82%">{{ $document->nama_penerima ?: '' }}</td>
          </tr>
          <tr>
            <th>Atasan Penerima</th><td>{{ $document->atasan_penerima_name ?: '' }}</td>
          </tr>
          <tr>
            <th>Asset Number</th><td>{{ $document->asset_number ?: '' }}</td>
          </tr>
          <tr>
            <th>GR Number</th><td>{{ $document->gr_number ?: '' }}</td>
          </tr>
          <tr>
            <th>Type Asset</th><td>{{ $document->type_device ?: '' }}</td>
          </tr>
        </table>

        <h4>Hardware</h4>
        <table class="table table-bordered table-condensed">
          <tr><th style="width:18%">Device Name</th><td style="width:82%">{{ $document->device_name ?: '' }}</td></tr>
          <tr><th>Merk</th><td>{{ $document->merk ?: '' }}</td></tr>
          <tr><th>Type</th><td>{{ $document->type_device ?: '' }}</td></tr>
          <tr><th>Processor</th><td>{{ $document->processor ?: '' }}</td></tr>
          <tr><th>Memory</th><td>{{ $document->memory ?: '' }}</td></tr>
          <tr><th>Hardisk</th><td>{{ $document->hardisk ?: '' }}</td></tr>
          <tr><th>Serial Number</th><td>{{ $document->serial_number ?: '' }}</td></tr>
          <tr><th>Battery</th><td>{{ $document->battery ?: '' }}</td></tr>
          <tr><th>Serial Number Battery</th><td>{{ $document->serial_number_battery ?: '' }}</td></tr>
          <tr><th>Tas</th><td>{{ $document->tas ?: '' }}</td></tr>
          <tr><th>Adaptor</th><td>{{ $document->adaptor ?: '' }}</td></tr>
          <tr><th>Serial Number Adaptor</th><td>{{ $document->serial_number_adaptor ?: '' }}</td></tr>
          <tr><th>Foto Device</th><td>{{ $document->foto_device ?: '' }}</td></tr>
        </table>

        @php
          $softLabel = 'Software';
          switch (strtolower($document->type)) {
            case 'component': $softLabel = 'Component Details'; break;
            case 'accessory': $softLabel = 'Accessories Details'; break;
            case 'license': $softLabel = 'License Details'; break;
            case 'consumable': $softLabel = 'Consumable Details'; break;
          }
        @endphp
        <h4>{{ $softLabel }}</h4>
        <table class="table table-bordered table-condensed">
          @if(strtolower($document->type)==='license')
            <tr><th style="width:18%">License Key</th><td style="width:82%">{{ $document->license_key ?: '' }}</td></tr>
            <tr><th>Seats</th><td>{{ $document->license_seats ?: '' }}</td></tr>
            <tr><th>Vendor</th><td>{{ $document->license_vendor ?: '' }}</td></tr>
            <tr><th>Expiry Date</th><td>{{ optional($document->license_expires_at)->format('d M Y') }}</td></tr>
          @elseif(strtolower($document->type)==='accessory')
            <tr><th style="width:18%">Part Number</th><td style="width:82%">{{ $document->accessory_part_number ?: '' }}</td></tr>
            <tr><th>Serial Number</th><td>{{ $document->accessory_serial_number ?: '' }}</td></tr>
            <tr><th>Condition</th><td>{{ $document->accessory_condition ?: '' }}</td></tr>
            <tr><th>Notes</th><td>{{ $document->accessory_notes ?: '' }}</td></tr>
          @elseif(strtolower($document->type)==='component')
            <tr><th style="width:18%">Model</th><td style="width:82%">{{ $document->component_model ?: '' }}</td></tr>
            <tr><th>Part No</th><td>{{ $document->component_part_number ?: '' }}</td></tr>
            <tr><th>Serial Number</th><td>{{ $document->component_serial_number ?: '' }}</td></tr>
            <tr><th>Spec</th><td>{{ $document->component_spec ?: '' }}</td></tr>
          @elseif(strtolower($document->type)==='consumable')
            <tr><th style="width:18%">Batch</th><td style="width:82%">{{ $document->consumable_batch ?: '' }}</td></tr>
            <tr><th>Qty</th><td>{{ $document->consumable_qty ?: '' }}</td></tr>
            <tr><th>Unit</th><td>{{ $document->consumable_unit ?: '' }}</td></tr>
            <tr><th>Notes</th><td>{{ $document->consumable_notes ?: '' }}</td></tr>
          @else
            <tr><th style="width:18%">Windows</th><td style="width:82%">{{ $document->windows ?: '' }}</td></tr>
            <tr><th>Office</th><td>{{ $document->office ?: '' }}</td></tr>
            <tr><th>Antivirus</th><td>{{ $document->antivirus ?: '' }}</td></tr>
            <tr><th>Compress Tools</th><td>{{ $document->compress_tools ?: '' }}</td></tr>
            <tr><th>Reader Tool</th><td>{{ $document->reader_tool ?: '' }}</td></tr>
            <tr><th>Browser</th><td>{{ $document->browser ?: '' }}</td></tr>
            <tr><th>Other Application 1</th><td>{{ $document->other_application_1 ?: '' }}</td></tr>
            <tr><th>Other Application 2</th><td>{{ $document->other_application_2 ?: '' }}</td></tr>
            <tr><th>Other Application 3</th><td>{{ $document->other_application_3 ?: '' }}</td></tr>
            <tr><th>Other Application 4</th><td>{{ $document->other_application_4 ?: '' }}</td></tr>
          @endif
        </table>

        <h4>Document &amp; Notes</h4>
        <table class="table table-bordered table-condensed">
          <tr><th style="width:18%">Dokumen Pengembalian Asset</th><td style="width:82%">{{ $document->dokumen_pengembalian_asset ?: '' }}</td></tr>
          <tr><th>Dokumen Surat Pernyataan</th><td>{{ $document->dokumen_surat_pernyataan ?: '' }}</td></tr>
          <tr><th>Catatan</th><td>{{ $document->catatan ?: '' }}</td></tr>
        </table>

        <h4>Metadata</h4>
        <table class="table table-bordered table-condensed">
          <tr><th style="width:18%">Doc Control No</th><td style="width:32%">{{ $document->doc_control_no ?: '' }}</td><th style="width:18%">Created Doc</th><td style="width:32%">{{ $document->created_doc?->format('d M Y') }}</td></tr>
          <tr><th>Effective Doc</th><td>{{ $document->effective_doc?->format('d M Y') }}</td><th>Revision No</th><td>{{ $document->revision_no ?: '' }}</td></tr>
          <tr><th>Revision Date</th><td>{{ $document->revision_date?->format('d M Y') }}</td><th>Author Doc</th><td>{{ $document->author_doc ?: '' }}</td></tr>
        </table>
      </div>
      <div class="tab-pane" id="approval">
        @php
          $legacy = ['it_manager','atasan_penerima'];
          $assigned = $document->signatures->reject(fn($s)=> in_array($s->role,$legacy))->filter(fn($s)=> !is_null($s->user_id));
          $pendingAssigned = $assigned->where('status','pending');
          $rejectedAssigned = $assigned->where('status','rejected');
        @endphp
        <div class="alert alert-info" style="margin-bottom:10px;">
          <strong>Approval summary:</strong>
          <span>assigned: {{ $assigned->count() }}, signed: {{ $assigned->where('status','signed')->count() }}, pending: {{ $pendingAssigned->count() }}, rejected: {{ $rejectedAssigned->count() }}.</span>
          @if($pendingAssigned->count() > 0)
            <br><small>Pending steps: {{ $pendingAssigned->pluck('role')->implode(', ') }}</small>
          @endif
          @if($rejectedAssigned->count() > 0)
            <br><small>Rejected steps: {{ $rejectedAssigned->pluck('role')->implode(', ') }}</small>
          @endif
        </div>
        <table class="table table-striped">
          <thead><tr><th>Role</th><th>User</th><th>Email</th><th>Employee ID</th><th>Status</th><th>Timestamp</th><th>Action</th></tr></thead>
          <tbody>
            @foreach($document->signatures->sortBy('ordering') as $sig)
              @if(strtolower($document->type)!=='asset' && !in_array($sig->role,['creator','user']))
                @continue
              @endif
              {{-- Hide legacy roles (kept only for backward compatibility in DB) --}}
              @if(in_array($sig->role, ['it_manager','atasan_penerima']))
                @continue
              @endif
              @php $displayRole = $sig->role; @endphp
              @if($sig->role==='creator_manager') @php $displayRole = 'IT Manager'; @endphp @endif
              @if($sig->role==='user_manager') @php $displayRole = 'Atasan Penerima'; @endphp @endif
              @if($sig->role==='hr') @php $displayRole = 'HR'; @endphp @endif
              @if($sig->role==='creator') @php $displayRole = 'Creator'; @endphp @endif
              @if($sig->role==='user') @php $displayRole = 'User'; @endphp @endif
              <tr>
                <td>{{ $displayRole }}</td>
                <td>{{ optional($sig->user)->present()->fullName ?? $sig->user_name }}</td>
                <td>{{ optional($sig->user)->email }}</td>
                <td>{{ optional($sig->user)->employee_num }}</td>
                <td>{{ $sig->status }}</td>
                <td>{{ $sig->signed_at }}</td>
                <td>
                  @if($sig->status=='pending' && (!$sig->user_id || $sig->user_id==auth()->id()))
                    <button class="btn btn-xs btn-success" data-action="sign" data-role="{{ $sig->role }}" data-id="{{ $document->id }}">Approve</button>
                    <button class="btn btn-xs btn-danger" data-action="reject" data-role="{{ $sig->role }}" data-id="{{ $document->id }}">Reject</button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="preview" style="height:calc(100vh - 250px);">
        <iframe src="{{ route('documents.print',$document->id) }}" style="width:100%;height:100%;border:1px solid #ccc;"></iframe>
      </div>
    </div>
  </div>
</div>
@endsection
@section('moar_scripts')
<script>
var BASE_URL = "{{ url('') }}";
document.addEventListener('click', function(e){
  if(e.target.closest && e.target.closest('#btn-recompute')){
    var btn = e.target.closest('#btn-recompute');
    var orig = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
    fetch(BASE_URL+'/documents/{{ $document->id }}'+'/recompute', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}})
      .then(async r=>{ if(!r.ok){ let m='Failed'; try{const j=await r.json(); if(j.message) m=j.message;}catch(_){} throw new Error(m);} return r.json(); })
      .then(()=> location.reload())
      .catch(err=>{ alert(err.message||'Error'); btn.disabled=false; btn.innerHTML=orig; });
    return;
  }
  if(e.target.closest && e.target.closest('#btn-complete')){
    var btn = e.target.closest('#btn-complete');
    var orig = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
    fetch(BASE_URL+'/documents/{{ $document->id }}'+'/complete', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}})
      .then(async r=>{ if(!r.ok){ let m='Failed'; try{const j=await r.json(); if(j.message) m=j.message;}catch(_){} throw new Error(m);} return r.json(); })
      .then(function(data){
        // If server returns stored pdf path, redirect to secure PDF route
        window.location.href = "{{ route('documents.pdf',$document->id) }}";
      })
      .catch(function(err){ alert(err.message||'Error'); btn.disabled=false; btn.innerHTML=orig; })
    return;
  }
  if(e.target.matches('[data-action]')){
    var btn=e.target; var role=btn.getAttribute('data-role'); var id=btn.getAttribute('data-id'); var action=btn.getAttribute('data-action');
    fetch(BASE_URL+'/documents/'+id+'/'+action+'/'+role,{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}})
      .then(r=>r.json()).then(data=>{location.reload();}).catch(err=>alert('Error'));
  }
});
</script>
@endsection

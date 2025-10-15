@extends('layouts/default')
@section('title') Edit Document {{ $document->document_number }} @stop
@section('content')

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Edit Document {{ $document->document_number }}</h3>
  </div>
  <form method="POST" action="{{ route('documents.update',$document) }}" class="form-horizontal">
    @csrf
    <div class="box-body">
      <!-- Nav tabs -->
      @php
        $softLabel = 'Software';
        switch (strtolower($document->type)) {
          case 'component': $softLabel = 'Component Details'; break;
          case 'accessory': $softLabel = 'Accessories Details'; break;
          case 'license': $softLabel = 'License Details'; break;
          case 'consumable': $softLabel = 'Consumable Details'; break;
        }
      @endphp
      <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#header" role="tab" data-toggle="tab">Header</a></li>
        <li><a href="#recipient" role="tab" data-toggle="tab">Penerima</a></li>
        @if(strtolower($document->type)==='asset')
          <li><a href="#hardware" role="tab" data-toggle="tab">Hardware</a></li>
        @endif
        <li><a href="#software" role="tab" data-toggle="tab">{{ $softLabel }}</a></li>
        @if(strtolower($document->type)==='asset')
          <li><a href="#documents" role="tab" data-toggle="tab">Documents & Notes</a></li>
        @endif
        <li><a href="#signatures" role="tab" data-toggle="tab">Signatures</a></li>
        <li><a href="#metadata" role="tab" data-toggle="tab">Metadata</a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content" style="margin-top:20px;">
        <div class="tab-pane active" id="header">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"><label class="col-sm-4 control-label">No Tanda Terima</label><div class="col-sm-8"><div class="input-group"><input value="{{ $document->document_number }}" class="form-control" disabled/><span class="input-group-btn"><button type="button" id="btn-regen-number" class="btn btn-default" title="Generate ulang"><i class="fa fa-refresh"></i></button></span></div></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Document Number</label><div class="col-sm-8"><input name="document_no" value="{{ old('document_no',$document->document_no) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Document Date</label><div class="col-sm-8"><input value="{{ $document->document_date?->format('d F Y') }}" class="form-control" disabled/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Requestor &amp; ID</label><div class="col-sm-8">
                @php $userSig = $document->signatures->firstWhere('role','user'); @endphp
                @if(strtolower($document->type)!=='asset')
                  @php $reqName = optional($userSig?->user)->present()->fullName ?? ($userSig?->user_name ?? $document->nama_penerima ?? ''); @endphp
                  <input value="{{ $reqName }}" class="form-control" disabled/>
                  <input type="hidden" name="requestor" value="{{ $reqName }}" />
                  <p class="help-block">Untuk dokumen non-asset, Requestor otomatis diisi dengan User (Penerima).</p>
                @else
                  <input name="requestor" value="{{ old('requestor',$document->requestor) }}" class="form-control" placeholder="Contoh: John Doe (12345)"/>
                  <p class="help-block">Tulis nama dan ID secara bebas. Biarkan kosong jika tidak ada.</p>
                @endif
              </div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Organization Structure</label><div class="col-sm-8"><input name="organization_structure" value="{{ old('organization_structure',$document->organization_structure) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Position</label><div class="col-sm-8"><input name="position" value="{{ old('position',$document->position) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Location</label><div class="col-sm-8"><input name="location" value="{{ old('location',$document->location) }}" class="form-control"/></div></div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="recipient">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"><label class="col-sm-4 control-label">Nama Penerima</label><div class="col-sm-8">
                <input value="{{ optional($userSig?->user)->present()->fullName ?? ($userSig?->user_name ?? '') }}" class="form-control" disabled>
                <p class="help-block">Ubah melalui bagian Signatures di bawah.</p>
              </div></div>
              @if(strtolower($document->type)==='asset')
                <div class="form-group"><label class="col-sm-4 control-label">Atasan Penerima</label><div class="col-sm-8"><input name="atasan_penerima_name" value="{{ old('atasan_penerima_name',$document->atasan_penerima_name) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Type Asset</label><div class="col-sm-8"><input name="type_device" value="{{ old('type_device',$document->type_device) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Asset Number</label><div class="col-sm-8"><input name="asset_number" value="{{ old('asset_number',$document->asset_number) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">GR Number</label><div class="col-sm-8"><input name="gr_number" value="{{ old('gr_number',$document->gr_number) }}" class="form-control"/></div></div>
              @endif
            </div>
          </div>
        </div>
        <div class="tab-pane" id="signatures">
          <div class="row">
            <div class="col-md-12">
              
              <table class="table table-condensed table-bordered">
                <thead><tr><th>Role</th><th>Current User</th><th>Email</th><th>Employee ID</th><th>Status</th><th>Assign User</th></tr></thead>
                <tbody>
                @foreach($document->signatures->sortBy('ordering') as $sig)
                  @if(strtolower($document->type)!=='asset' && !in_array($sig->role,['creator','user']))
                    @continue
                  @endif
                  {{-- Skip legacy roles (kept for backward compat) --}}
                  @if(in_array($sig->role, ['it_manager','atasan_penerima']))
                    @continue
                  @endif
                  @php $displayRole = $sig->role; @endphp
                  @if($sig->role==='creator_manager') @php $displayRole = 'IT Manager'; @endphp @endif
                  @if($sig->role==='user_manager') @php $displayRole = 'Atasan Penerima'; @endphp @endif
                  @if($sig->role==='hr') @php $displayRole = 'HR'; @endphp @endif
                  <tr>
                    <td>{{ $displayRole }}</td>
                    <td><span class="sig-cell sig-name" data-sig-id="{{ $sig->id }}">{{ optional($sig->user)->present()->fullName ?? $sig->user_name }}</span></td>
                    <td><span class="sig-cell sig-email" data-sig-id="{{ $sig->id }}">{{ optional($sig->user)->email }}</span></td>
                    <td><span class="sig-cell sig-employee" data-sig-id="{{ $sig->id }}">{{ optional($sig->user)->employee_num }}</span></td>
                    <td>{{ $sig->status }}</td>
                    <td>
                      @php
                        // Unlock Requestor/User: allow editing the 'user' row when status is pending.
                        // Keep IT Manager (creator_manager) editable, and generally allow edits when pending or for the creator.
                        $allowEdit = ($sig->role==='creator' || $sig->role==='creator_manager' || $sig->status==='pending');
                      @endphp
                      @if($allowEdit)
                        <div class="input-group input-group-sm">
                          <select name="signature_users[{{ $sig->id }}]" class="form-control input-sm sig-select" data-role="{{ $sig->role }}" data-sig-id="{{ $sig->id }}">
                            <option value="">-- pilih user --</option>
                            @foreach($users as $u)
                              <option value="{{ $u->id }}" {{ $sig->user_id==$u->id ? 'selected' : '' }}>{{ $u->present()->fullName ?? ($u->name ?? $u->username) }}</option>
                            @endforeach
                          </select>
                          @php $p = optional($sig->user); @endphp
                          <span class="input-group-btn"><button type="button" class="btn btn-default btn-edit-person" title="Edit" data-sig-id="{{ $sig->id }}" data-user-id="{{ $p->id }}" data-user-name="{{ $p->present()->fullName ?? ($p->name ?? $p->username) }}" data-email="{{ $p->email }}" data-employee-num="{{ $p->employee_num }}"><i class="fa fa-pencil"></i></button></span>
                        </div>
                      @else
                        <em>Locked</em>
                      @endif
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
  @if(strtolower($document->type)==='asset')
  <div class="tab-pane" id="hardware">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"><label class="col-sm-4 control-label">Device Name</label><div class="col-sm-8"><input name="device_name" value="{{ old('device_name',$document->device_name) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Merk</label><div class="col-sm-8"><input name="merk" value="{{ old('merk',$document->merk) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Processor</label><div class="col-sm-8"><input name="processor" value="{{ old('processor',$document->processor) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Memory</label><div class="col-sm-8"><input name="memory" value="{{ old('memory',$document->memory) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Harddisk</label><div class="col-sm-8"><input name="hardisk" value="{{ old('hardisk',$document->hardisk) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Serial Number</label><div class="col-sm-8"><input name="serial_number" value="{{ old('serial_number',$document->serial_number) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Battery</label><div class="col-sm-8"><input name="battery" value="{{ old('battery',$document->battery) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Serial Number Battery</label><div class="col-sm-8"><input name="serial_number_battery" value="{{ old('serial_number_battery',$document->serial_number_battery) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Tas</label><div class="col-sm-8"><input name="tas" value="{{ old('tas',$document->tas) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Adaptor</label><div class="col-sm-8"><input name="adaptor" value="{{ old('adaptor',$document->adaptor) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Serial Number Adaptor</label><div class="col-sm-8"><input name="serial_number_adaptor" value="{{ old('serial_number_adaptor',$document->serial_number_adaptor) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Foto Device</label><div class="col-sm-8"><input name="foto_device" value="{{ old('foto_device',$document->foto_device) }}" class="form-control"/></div></div>
            </div>
          </div>
  </div>
  @endif
        <div class="tab-pane" id="software">
          <div class="row">
            <div class="col-md-6">
              @if(strtolower($document->type)==='license')
                <div class="form-group"><label class="col-sm-4 control-label">License Key</label><div class="col-sm-8"><input name="license_key" value="{{ old('license_key',$document->license_key) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Seats</label><div class="col-sm-8"><input type="number" name="license_seats" value="{{ old('license_seats',$document->license_seats) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Vendor</label><div class="col-sm-8"><input name="license_vendor" value="{{ old('license_vendor',$document->license_vendor) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Expiry Date</label><div class="col-sm-8"><input type="date" name="license_expires_at" value="{{ old('license_expires_at', optional($document->license_expires_at)->format('Y-m-d')) }}" class="form-control"/></div></div>
              @elseif(strtolower($document->type)==='accessory')
                <div class="form-group"><label class="col-sm-4 control-label">Part Number</label><div class="col-sm-8"><input name="accessory_part_number" value="{{ old('accessory_part_number',$document->accessory_part_number) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Serial Number</label><div class="col-sm-8"><input name="accessory_serial_number" value="{{ old('accessory_serial_number',$document->accessory_serial_number) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Condition</label><div class="col-sm-8"><input name="accessory_condition" value="{{ old('accessory_condition',$document->accessory_condition) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Notes</label><div class="col-sm-8"><textarea name="accessory_notes" class="form-control" rows="3">{{ old('accessory_notes',$document->accessory_notes) }}</textarea></div></div>
              @elseif(strtolower($document->type)==='component')
                <div class="form-group"><label class="col-sm-4 control-label">Model</label><div class="col-sm-8"><input name="component_model" value="{{ old('component_model',$document->component_model) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Part No</label><div class="col-sm-8"><input name="component_part_number" value="{{ old('component_part_number',$document->component_part_number) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Serial Number</label><div class="col-sm-8"><input name="component_serial_number" value="{{ old('component_serial_number',$document->component_serial_number) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Spec</label><div class="col-sm-8"><textarea name="component_spec" class="form-control" rows="3">{{ old('component_spec',$document->component_spec) }}</textarea></div></div>
              @elseif(strtolower($document->type)==='consumable')
                <div class="form-group"><label class="col-sm-4 control-label">Batch</label><div class="col-sm-8"><input name="consumable_batch" value="{{ old('consumable_batch',$document->consumable_batch) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Qty</label><div class="col-sm-8"><input type="number" name="consumable_qty" value="{{ old('consumable_qty',$document->consumable_qty) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Unit</label><div class="col-sm-8"><input name="consumable_unit" value="{{ old('consumable_unit',$document->consumable_unit) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Notes</label><div class="col-sm-8"><textarea name="consumable_notes" class="form-control" rows="3">{{ old('consumable_notes',$document->consumable_notes) }}</textarea></div></div>
              @else
                <div class="form-group"><label class="col-sm-4 control-label">@if(strtolower($document->type)==='asset') Windows @else Detail 1 @endif</label><div class="col-sm-8"><input name="windows" value="{{ old('windows',$document->windows) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">@if(strtolower($document->type)==='asset') Office @else Detail 2 @endif</label><div class="col-sm-8"><input name="office" value="{{ old('office',$document->office) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">@if(strtolower($document->type)==='asset') Antivirus @else Detail 3 @endif</label><div class="col-sm-8"><input name="antivirus" value="{{ old('antivirus',$document->antivirus) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">@if(strtolower($document->type)==='asset') Compress Tools @else Detail 4 @endif</label><div class="col-sm-8"><input name="compress_tools" value="{{ old('compress_tools',$document->compress_tools) }}" class="form-control"/></div></div>
              @endif
              @if(strtolower($document->type)==='asset')
                <div class="form-group"><label class="col-sm-4 control-label">Reader Tools</label><div class="col-sm-8"><input name="reader_tool" value="{{ old('reader_tool',$document->reader_tool) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Browser</label><div class="col-sm-8"><input name="browser" value="{{ old('browser',$document->browser) }}" class="form-control"/></div></div>
              @endif
              @if(strtolower($document->type)!=='asset')
                <div class="form-group"><label class="col-sm-4 control-label">Catatan</label><div class="col-sm-8"><textarea name="catatan" class="form-control" rows="3">{{ old('catatan',$document->catatan) }}</textarea></div></div>
              @endif
            </div>
            <div class="col-md-6">
              @if(strtolower($document->type)==='asset')
                <div class="form-group"><label class="col-sm-4 control-label">Other App 1</label><div class="col-sm-8"><input name="other_application_1" value="{{ old('other_application_1',$document->other_application_1) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Other App 2</label><div class="col-sm-8"><input name="other_application_2" value="{{ old('other_application_2',$document->other_application_2) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Other App 3</label><div class="col-sm-8"><input name="other_application_3" value="{{ old('other_application_3',$document->other_application_3) }}" class="form-control"/></div></div>
                <div class="form-group"><label class="col-sm-4 control-label">Other App 4</label><div class="col-sm-8"><input name="other_application_4" value="{{ old('other_application_4',$document->other_application_4) }}" class="form-control"/></div></div>
              @endif
            </div>
          </div>
        </div>
        @if(strtolower($document->type)==='asset')
        <div class="tab-pane" id="documents">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group"><label class="col-sm-2 control-label">Dokumen Pengembalian Asset</label><div class="col-sm-10"><input name="dokumen_pengembalian_asset" value="{{ old('dokumen_pengembalian_asset',$document->dokumen_pengembalian_asset) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-2 control-label">Dokumen Surat Pernyataan</label><div class="col-sm-10"><input name="dokumen_surat_pernyataan" value="{{ old('dokumen_surat_pernyataan',$document->dokumen_surat_pernyataan) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-2 control-label">Catatan</label><div class="col-sm-10"><textarea name="catatan" class="form-control" rows="3">{{ old('catatan',$document->catatan) }}</textarea></div></div>
            </div>
          </div>
        </div>
        @endif
        <div class="tab-pane" id="metadata">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group"><label class="col-sm-4 control-label">Doc Control No</label><div class="col-sm-8"><input name="doc_control_no" value="{{ old('doc_control_no',$document->doc_control_no) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Created Doc</label><div class="col-sm-8"><input type="date" name="created_doc" value="{{ old('created_doc',$document->created_doc?->format('Y-m-d')) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Effective Doc</label><div class="col-sm-8"><input type="date" name="effective_doc" value="{{ old('effective_doc',$document->effective_doc?->format('Y-m-d')) }}" class="form-control"/></div></div>
            </div>
            <div class="col-md-6">
              <div class="form-group"><label class="col-sm-4 control-label">Revision No</label><div class="col-sm-8"><input name="revision_no" value="{{ old('revision_no',$document->revision_no) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Revision Date</label><div class="col-sm-8"><input type="date" name="revision_date" value="{{ old('revision_date',$document->revision_date?->format('Y-m-d')) }}" class="form-control"/></div></div>
              <div class="form-group"><label class="col-sm-4 control-label">Author Doc</label><div class="col-sm-8"><input name="author_doc" value="{{ old('author_doc',$document->author_doc) }}" class="form-control"/></div></div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="box-footer">
      <button class="btn btn-primary">Save</button>
  <a href="{{ route('documents.index', ['type' => $document->type]) }}" class="btn btn-default">Cancel</a>
    </div>
  </form>
</div>
<script type="application/json" id="users-data">{!! json_encode(
  $users->mapWithKeys(function($u){
    return [$u->id => [
      'name' => $u->present()->fullName ?? ($u->name ?? $u->username),
      'email' => $u->email,
      'employee_num' => $u->employee_num,
      'manager_id' => $u->manager_id,
      'manager_name' => $u->manager?->present()->fullName ?? ($u->manager?->name ?? $u->manager?->username),
    ]];
  })
) !!}</script>
<!-- Per-row People Edit Modal -->
<div class="modal fade" id="personEditModal" tabindex="-1" role="dialog" aria-labelledby="personEditModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="personEditModalLabel">Edit Email & Employee ID</h4>
      </div>
      <div class="modal-body">
        <form id="person-edit-form">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="people_updates[_id][id]" id="person-id" value="">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="person-name" value="" disabled>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="people_updates[_id][email]" id="person-email" value="">
          </div>
          <div class="form-group">
            <label>Employee ID</label>
            <input type="text" class="form-control" name="people_updates[_id][employee_num]" id="person-employee" value="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="person-edit-save">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('moar_scripts')
<script>
(function(){
  // Expose Users map for fallback (when signature has no user yet)
  var USERS_MAP = (function(){
    try {
      return JSON.parse(document.getElementById('users-data').textContent);
    } catch(e){ return {}; }
  })();
  // Update a row's display cells (name/email/employee) based on selected user
  function updateRowDisplayBySigId(sigId, userId){
    var nameEl = document.querySelector('.sig-name[data-sig-id="'+sigId+'"]');
    var emailEl = document.querySelector('.sig-email[data-sig-id="'+sigId+'"]');
    var empEl = document.querySelector('.sig-employee[data-sig-id="'+sigId+'"]');
    var user = USERS_MAP[userId] || {};
    if(nameEl) nameEl.textContent = user.name || '';
    if(emailEl) emailEl.textContent = user.email || '';
    if(empEl) empEl.textContent = user.employee_num || '';
    // Keep the row's pencil button in sync
    var btn = document.querySelector('.btn-edit-person[data-sig-id="'+sigId+'"]');
    if(btn){
      btn.setAttribute('data-user-id', userId || '');
      btn.setAttribute('data-user-name', user.name || '');
      btn.setAttribute('data-email', user.email || '');
      btn.setAttribute('data-employee-num', user.employee_num || '');
    }
  }
  // Quick map of manager->name for selects display (optional)
  function getManagerIdOf(userId){
    var u = USERS_MAP[userId];
    return u && u.manager_id ? String(u.manager_id) : '';
  }
  function getUserName(userId){
    var u = USERS_MAP[userId];
    return u && u.name ? u.name : '';
  }
  // Signature roles selects
  var sigSelects = Array.prototype.slice.call(document.querySelectorAll('select.sig-select'));
  var selectsByRole = sigSelects.reduce(function(acc, el){ acc[el.getAttribute('data-role')] = el; return acc; }, {});
  // Any selection change should update its own display cells
  sigSelects.forEach(function(sel){
    sel.addEventListener('change', function(){
      var sigId = this.getAttribute('data-sig-id');
      updateRowDisplayBySigId(sigId, this.value || '');
    });
  });
  // Helper: set select to value if option exists, and trigger change event
  function setSelectValue(sel, val){
    if(!sel) return;
    var strVal = (val==null? '': String(val));
    if(!strVal) return;
    var found = false;
    for (var i=0;i<sel.options.length;i++){ if (String(sel.options[i].value)===strVal) { found=true; break; } }
    if(found){ sel.value = strVal; var evt = document.createEvent('HTMLEvents'); evt.initEvent('change', true, false); sel.dispatchEvent(evt); }
  }
  // When creator changes, auto-fill creator_manager from People (manager_id).
  if (selectsByRole['creator'] && selectsByRole['creator_manager']){
    selectsByRole['creator'].addEventListener('change', function(){
      var creatorId = this.value;
      var mgrId = getManagerIdOf(creatorId);
      if (mgrId){ setSelectValue(selectsByRole['creator_manager'], mgrId); }
    });
  }
  // When user (penerima) changes, auto-fill user_manager from People, and mirror Atasan Penerima text input.
  var atasanInput = document.querySelector('input[name="atasan_penerima_name"]');
  if (selectsByRole['user'] && selectsByRole['user_manager']){
    selectsByRole['user'].addEventListener('change', function(){
      var userId = this.value;
      var mgrId = getManagerIdOf(userId);
      if (mgrId){ setSelectValue(selectsByRole['user_manager'], mgrId); }
      if (atasanInput){ atasanInput.value = getUserName(mgrId) || atasanInput.value; }
    });
  }
  // Also when user_manager explicitly changed by operator, keep Atasan Penerima in sync.
  if (selectsByRole['user_manager']){
    selectsByRole['user_manager'].addEventListener('change', function(){
      if (atasanInput){ atasanInput.value = getUserName(this.value) || atasanInput.value; }
    });
  }
  var activePersonId = null;
  var btn = document.getElementById('btn-regen-number');
  if(btn){
    btn.addEventListener('click', function(){
      var orig = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
      fetch("{{ route('documents.regenNumber',$document) }}", {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}})
        .then(async r=>{ if(!r.ok){ let m='Gagal generate'; try{const j=await r.json(); if(j.message) m=j.message;}catch(_){} throw new Error(m);} return r.json(); })
        .then(function(data){
          var input = btn.closest('.input-group').querySelector('input.form-control');
          if(input && data.document_number){ input.value = data.document_number; }
          var docNo = document.querySelector('input[name=\"document_no\"]');
          if(docNo && data.document_no){ docNo.value = data.document_no; }
        })
        .catch(function(err){ alert(err.message||'Error'); })
        .finally(function(){ btn.disabled=false; btn.innerHTML = orig; });
    });
  }
  // Open per-row modal to edit People
  document.addEventListener('click', function(e){
    var btnEdit = e.target.closest && e.target.closest('.btn-edit-person');
    if(btnEdit){
      var id = btnEdit.getAttribute('data-user-id');
      var name = btnEdit.getAttribute('data-user-name') || '';
      var email = btnEdit.getAttribute('data-email') || '';
      var emp = btnEdit.getAttribute('data-employee-num') || '';

      // If no user on signature, use the selected value from the sibling select
      if(!id){
        var group = btnEdit.closest('.input-group');
        var sel = group ? group.querySelector('select') : null;
        var selId = sel && sel.value ? sel.value : '';
        if(selId){
          id = selId;
          var u = USERS_MAP[selId] || {};
          name = u.name || (sel ? (sel.options[sel.selectedIndex] ? sel.options[sel.selectedIndex].text : '') : '');
          email = u.email || '';
          emp = u.employee_num || '';
        }
      }

      if(!id){ return alert('Pilih user dulu pada kolom Assign User.'); }

      // Fill modal
      document.getElementById('person-id').value = id;
      document.getElementById('person-name').value = name;
      document.getElementById('person-email').value = email;
      document.getElementById('person-employee').value = emp;
      activePersonId = id;
      $('#personEditModal').modal('show');
    }
  });
  // Save single People update
  var personSave = document.getElementById('person-edit-save');
  if(personSave){
    personSave.addEventListener('click', function(){
      var id = activePersonId;
      if(!id){ return alert('User belum dipilih.'); }
      var fd = new FormData();
      fd.append('_token','{{ csrf_token() }}');
      fd.append('people_updates['+id+'][id]', id);
      fd.append('people_updates['+id+'][email]', document.getElementById('person-email').value || '');
      fd.append('people_updates['+id+'][employee_num]', document.getElementById('person-employee').value || '');
      fetch("{{ route('documents.updateSignaturePeople',$document) }}", {method:'POST', body: fd})
        .then(async r=>{ if(!r.ok){ let m='Gagal simpan'; try{const j=await r.json(); if(j.message) m=j.message;}catch(_){} throw new Error(m);} return r.text(); })
        .then(function(){ location.reload(); })
        .catch(function(err){ alert(err.message||'Error'); });
    });
  }
})();
</script>
@endsection

@extends('layouts/default')
@section('title') Edit Accessory Document {{ $document->document_number }} @stop
@section('content')
    <div class="box box-default" style="border: 1px solid #d2d6de; box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
        <div class="box-header with-border" style="border-bottom: 1px solid #d2d6de; padding: 15px;">
            <h3 class="box-title" style="font-size: 18px; font-weight: 600;">Edit Accessory {{ $document->document_number }}
            </h3>
        </div>
        <form method="POST" action="{{ route('documents.update', $document) }}" class="form-horizontal">@csrf
            <div class="box-body" style="padding: 20px;">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#header" role="tab" data-toggle="tab">Header</a></li>
                    <li><a href="#details" role="tab" data-toggle="tab">Accessory Details</a></li>
                    <li><a href="#signatures" role="tab" data-toggle="tab">Signatures</a></li>
                    <li><a href="#metadata" role="tab" data-toggle="tab">Metadata</a></li>
                </ul>
                <div class="tab-content" style="margin-top:20px;">
                    <div class="tab-pane active" id="header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label class="col-sm-4 control-label">No Tanda Terima</label>
                                    <div class="col-sm-8"><input value="{{ $document->document_number }}"
                                            class="form-control" disabled /></div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Document Number</label>
                                    <div class="col-sm-8"><input name="document_no"
                                            value="{{ old('document_no', $document->document_no) }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Document Date</label>
                                    <div class="col-sm-8"><input value="{{ $document->document_date?->format('d F Y') }}"
                                            class="form-control" disabled /></div>
                                </div>
                                @php $userSig = $document->signatures->firstWhere('role','user'); @endphp
                                <div class="form-group"><label class="col-sm-4 control-label">Requestor &amp; ID</label>
                                    <div class="col-sm-8">
                                        @php $reqName = optional($userSig?->user)->present()->fullName ?? ($userSig?->user_name ?? $document->nama_penerima ?? ''); @endphp
                                        <input name="requestor" value="{{ old('requestor', $reqName) }}"
                                            class="form-control" />
                                        <p class="help-block">Untuk Accessory, Requestor otomatis diisi dengan User
                                            (Penerima) namun bisa diubah.</p>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Organization Structure</label>
                                    <div class="col-sm-8"><input name="organization_structure"
                                            value="{{ old('organization_structure', $document->organization_structure) }}"
                                            class="form-control" /></div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Position</label>
                                    <div class="col-sm-8"><input name="position"
                                            value="{{ old('position', $document->position) }}" class="form-control" /></div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Location</label>
                                    <div class="col-sm-8"><input name="location"
                                            value="{{ old('location', $document->location) }}" class="form-control" /></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="details">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label class="col-sm-4 control-label">Part Number</label>
                                    <div class="col-sm-8"><input name="accessory_part_number"
                                            value="{{ old('accessory_part_number', $document->accessory_part_number) }}"
                                            class="form-control" /></div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Serial Number</label>
                                    <div class="col-sm-8"><input name="accessory_serial_number"
                                            value="{{ old('accessory_serial_number', $document->accessory_serial_number) }}"
                                            class="form-control" /></div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Condition</label>
                                    <div class="col-sm-8"><input name="accessory_condition"
                                            value="{{ old('accessory_condition', $document->accessory_condition) }}"
                                            class="form-control" /></div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Notes</label>
                                    <div class="col-sm-8">
                                        <textarea name="accessory_notes" class="form-control" rows="3">{{ old('accessory_notes', $document->accessory_notes) }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Catatan</label>
                                    <div class="col-sm-8">
                                        <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $document->catatan) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="signatures">
                        @include('documents.asset.partials.signatures_table', [
                            'document' => $document,
                            'users' => $users,
                        ])
                    </div>
                    <div class="tab-pane" id="metadata">
                        @include('documents.asset.partials.metadata', ['document' => $document])
                    </div>
                </div>
            </div>
            <div class="box-footer"
                style="padding: 15px; border-top: 1px solid #d2d6de; overflow: hidden; display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('documents.index', ['type' => 'accessory']) }}" class="btn btn-default"
                    style="float: left;">Cancel</a>
                <button class="btn btn-primary"
                    style="background-color:#5dade2 !important; border-color:#5dade2 !important; float: right;">Save</button>
            </div>
        </form>
    </div>
@endsection
@section('moar_scripts')
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
    @include('documents.asset.signatures_script')
@endsection

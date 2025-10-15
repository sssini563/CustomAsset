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

<div class="row">
  <div class="col-md-6">
    <div class="form-group"><label class="col-sm-4 control-label">Jenis Dokumen</label><div class="col-sm-8"><input name="jenis_dokumen" value="{{ old('jenis_dokumen',$document->jenis_dokumen) }}" class="form-control"/></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Pemilik Proses</label><div class="col-sm-8"><input name="pemilik_proses" value="{{ old('pemilik_proses',$document->pemilik_proses) }}" class="form-control"/></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Tanggal Efektif</label><div class="col-sm-8"><input type="date" name="effective_doc" value="{{ old('effective_doc',$document->effective_doc?->format('Y-m-d')) }}" class="form-control"/></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Proses Bisnis</label><div class="col-sm-8"><input name="proses_bisnis" value="{{ old('proses_bisnis',$document->proses_bisnis) }}" class="form-control"/></div></div>
  </div>
  <div class="col-md-6">
    <div class="form-group"><label class="col-sm-4 control-label">Halaman</label><div class="col-sm-8"><input name="sp_hal" value="{{ old('sp_hal',$document->sp_hal) }}" class="form-control"/></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">No. Dokumen</label><div class="col-sm-8"><input name="doc_control_no" value="{{ old('doc_control_no',$document->doc_control_no ?: $document->document_no) }}" class="form-control"/></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Tgl. Peninjauan</label><div class="col-sm-8"><input type="date" name="revision_date" value="{{ old('revision_date',$document->revision_date?->format('Y-m-d')) }}" class="form-control"/></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Petahana</label><div class="col-sm-8"><input name="author_doc" value="{{ old('author_doc',$document->author_doc) }}" class="form-control"/></div></div>
  </div>
</div>

@extends('layouts/default')

@section('title')
    Document Metadata Defaults
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary">{{ trans('general.back') }}</a>
@stop

@section('content')
    <form method="POST" autocomplete="off" class="form-horizontal" role="form">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="panel box box-default">
                    <div class="box-header with-border">
                        <h2 class="box-title">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            Document Metadata Defaults
                        </h2>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <fieldset class="bottom-padded">
                                <legend class="highlight">Surat Pernyataan (SP) Style</legend>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label for="document_default_jenis_dokumen">Jenis Dokumen</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" id="document_default_jenis_dokumen"
                                            name="document_default_jenis_dokumen" type="text"
                                            value="{{ old('document_default_jenis_dokumen', $setting->document_default_jenis_dokumen) }}"
                                            placeholder="Formulir" />
                                        <p class="help-block">Example: Form, Statement Letter, etc.</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label for="document_default_sp_hal">Halaman</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" id="document_default_sp_hal"
                                            name="document_default_sp_hal" type="text"
                                            value="{{ old('document_default_sp_hal', $setting->document_default_sp_hal) }}"
                                            placeholder="1 dari 1" />
                                        <p class="help-block">Example: 1 of 1</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label for="document_default_pemilik_proses">Pemilik Proses</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" id="document_default_pemilik_proses"
                                            name="document_default_pemilik_proses" type="text"
                                            value="{{ old('document_default_pemilik_proses', $setting->document_default_pemilik_proses) }}"
                                            placeholder="IT Business Support" />
                                        <p class="help-block">Example: IT Business Support</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label for="document_default_proses_bisnis">Proses Bisnis</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" id="document_default_proses_bisnis"
                                            name="document_default_proses_bisnis" type="text"
                                            value="{{ old('document_default_proses_bisnis', $setting->document_default_proses_bisnis) }}"
                                            placeholder="Authorization Request" />
                                        <p class="help-block">Example: Authorization Request</p>
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-primary">{{ trans('general.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

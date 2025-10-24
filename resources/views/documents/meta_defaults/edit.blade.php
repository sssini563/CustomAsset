@extends('layouts/default')

@section('title') Document Metadata Defaults @stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Document Metadata Defaults</h3>
                </div>
                <form method="post" action="{{ route('documents.meta.defaults.update') }}">
                    @csrf
                    <div class="box-body">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach ($types as $i => $t)
                                @php($label = $t === 'asset_form' ? 'Asset - Form Serah Terima' : ($t === 'asset_sp' ? 'Asset - Surat Pernyataan' : ucfirst($t)))
                                <li role="presentation" class="{{ $i === 0 ? 'active' : '' }}"><a
                                        href="#tab-{{ $t }}" aria-controls="tab-{{ $t }}"
                                        role="tab" data-toggle="tab">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                        <div class="tab-content" style="margin-top:15px">
                            @foreach ($types as $i => $t)
                                @php($d = $defaults[$t] ?? [])
                                <div role="tabpanel" class="tab-pane {{ $i === 0 ? 'active' : '' }}"
                                    id="tab-{{ $t }}">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Jenis Dokumen</label>
                                                <input type="text" class="form-control"
                                                    name="{{ $t }}[jenis_dokumen]"
                                                    value="{{ $d['jenis_dokumen'] ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Halaman (SP Hal)</label>
                                                <input type="text" class="form-control"
                                                    name="{{ $t }}[sp_hal]" value="{{ $d['sp_hal'] ?? '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Pemilik Proses</label>
                                                <input type="text" class="form-control"
                                                    name="{{ $t }}[pemilik_proses]"
                                                    value="{{ $d['pemilik_proses'] ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Proses Bisnis</label>
                                                <input type="text" class="form-control"
                                                    name="{{ $t }}[proses_bisnis]"
                                                    value="{{ $d['proses_bisnis'] ?? '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>No. Dokumen</label>
                                                <input type="text" class="form-control"
                                                    name="{{ $t }}[doc_control_no]"
                                                    value="{{ $d['doc_control_no'] ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tanggal Efektif</label>
                                                <input type="date" class="form-control"
                                                    name="{{ $t }}[effective_doc]"
                                                    value="{{ $d['effective_doc'] ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tgl. Peninjauan</label>
                                                <input type="date" class="form-control"
                                                    name="{{ $t }}[revision_date]"
                                                    value="{{ $d['revision_date'] ?? '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Petahana</label>
                                                <input type="text" class="form-control"
                                                    name="{{ $t }}[author_doc]"
                                                    value="{{ $d['author_doc'] ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="alert alert-info" style="margin-top:24px">
                                                Pastikan nilai sesuai contoh di header form/SP (lihat gambar). Semua field
                                                di atas akan digunakan sebagai metadata default.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{ route('documents.index', ['type' => 'consumable']) }}"
                            class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

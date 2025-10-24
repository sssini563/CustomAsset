<div class="modal-header"
    style="background: linear-gradient(to right, #f8f9fa, #ffffff); border-bottom: 2px solid #5dade2; padding: 20px;">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" style="font-size: 20px; font-weight: 600; color: #2c3e50;">
        <i class="fa fa-file-text-o" style="color: #5dade2;"></i> Detail Document
        <strong style="color: #5dade2;">{{ $document->document_number }}</strong>
        @php
            $statusClass = match ($document->overall_status) {
                'signed' => 'label-success',
                'rejected' => 'label-danger',
                default => 'label-warning',
            };
        @endphp
        <span class="label {{ $statusClass }}"
            style="margin-left:10px; vertical-align:middle; padding: 5px 12px; font-size: 12px; border-radius: 3px;">{{ strtoupper($document->overall_status) }}</span>
    </h4>
</div>
<div class="modal-body doc-detail-modal">
    <div class="detail-section">
        <h5><i class="fa fa-id-badge"></i> Header Information</h5>
        <div class="doc-detail-grid">
            <div class="doc-detail-item">
                <dt>No Tanda Terima</dt>
                <dd>{{ $document->document_number }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Organization Structure</dt>
                <dd>{{ $document->organization_structure ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Document Number</dt>
                <dd>{{ $document->document_no ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Position</dt>
                <dd>{{ $document->position ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Document Date</dt>
                <dd>
                    @if ($document->document_date)
                        @php
                            $months = [
                                1 => 'januari',
                                2 => 'februari',
                                3 => 'maret',
                                4 => 'april',
                                5 => 'mei',
                                6 => 'juni',
                                7 => 'juli',
                                8 => 'agustus',
                                9 => 'september',
                                10 => 'oktober',
                                11 => 'november',
                                12 => 'desember',
                            ];
                        @endphp
                        {{ (int) $document->document_date->day }}
                        {{ $months[(int) $document->document_date->month] ?? '' }}
                        {{ (int) $document->document_date->year }}
                    @endif
                </dd>
            </div>
            <div class="doc-detail-item">
                <dt>Location</dt>
                <dd>{{ $document->location ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Requestor &amp; ID</dt>
                <dd>{{ $document->requestor ?: '' }}</dd>
            </div>
        </div>
    </div>
    <div class="detail-section">
        <h5><i class="fa fa-user"></i> Penerima</h5>
        <div class="doc-detail-grid">
            <div class="doc-detail-item">
                <dt>Nama Penerima</dt>
                <dd>{{ $document->nama_penerima ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Atasan Penerima</dt>
                <dd>{{ $document->atasan_penerima_name ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Asset Number</dt>
                <dd>{{ $document->asset_number ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>GR Number</dt>
                <dd>{{ $document->gr_number ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Type Asset</dt>
                <dd>{{ $document->type_device ?: '' }}</dd>
            </div>
        </div>
    </div>
    <div class="detail-section">
        <h5><i class="fa fa-desktop"></i> Hardware</h5>
        <div class="doc-detail-grid">
            <div class="doc-detail-item">
                <dt>Device Name</dt>
                <dd>{{ $document->device_name ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Merk</dt>
                <dd>{{ $document->merk ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Type</dt>
                <dd>{{ $document->type_device ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Processor</dt>
                <dd>{{ $document->processor ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Memory</dt>
                <dd>{{ $document->memory ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Hardisk</dt>
                <dd>{{ $document->hardisk ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Serial Number</dt>
                <dd>{{ $document->serial_number ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Battery</dt>
                <dd>{{ $document->battery ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Serial Number Battery</dt>
                <dd>{{ $document->serial_number_battery ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Tas</dt>
                <dd>{{ $document->tas ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Adaptor</dt>
                <dd>{{ $document->adaptor ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Serial Number Adaptor</dt>
                <dd>{{ $document->serial_number_adaptor ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Foto Device</dt>
                <dd>{{ $document->foto_device ?: '' }}</dd>
            </div>
        </div>
    </div>
    <div class="detail-section">
        <h5><i class="fa fa-cubes"></i> Software</h5>
        <div class="doc-detail-grid">
            <div class="doc-detail-item">
                <dt>Windows</dt>
                <dd>{{ $document->windows ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Office</dt>
                <dd>{{ $document->office ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Antivirus</dt>
                <dd>{{ $document->antivirus ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Compress Tools</dt>
                <dd>{{ $document->compress_tools ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Reader Tool</dt>
                <dd>{{ $document->reader_tool ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Browser</dt>
                <dd>{{ $document->browser ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Other Application 1</dt>
                <dd>{{ $document->other_application_1 ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Other Application 2</dt>
                <dd>{{ $document->other_application_2 ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Other Application 3</dt>
                <dd>{{ $document->other_application_3 ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Other Application 4</dt>
                <dd>{{ $document->other_application_4 ?: '' }}</dd>
            </div>
        </div>
    </div>
    <div class="detail-section">
        <h5><i class="fa fa-file-text"></i> Document &amp; Notes</h5>
        <div class="doc-detail-grid">
            <div class="doc-detail-item">
                <dt>Dokumen Pengembalian Asset</dt>
                <dd>{{ $document->dokumen_pengembalian_asset ?: '' }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Dokumen Surat Pernyataan</dt>
                <dd>{{ $document->dokumen_surat_pernyataan ?: '' }}</dd>
            </div>
            <div class="doc-detail-item" style="width:100%">
                <dt>Catatan</dt>
                <dd>{{ $document->catatan ?: '' }}</dd>
            </div>
        </div>
    </div>
    <div class="detail-section">
        <h5><i class="fa fa-info-circle"></i> Metadata</h5>
        @php
            $s = \App\Models\Setting::getSettings();
            $df = is_array($s->document_defaults_asset_form ?? null) ? $s->document_defaults_asset_form : [];
            $sigCreator = $document->signatures->where('role', 'creator')->first();
        @endphp
        <div class="doc-detail-grid">
            <div class="doc-detail-item">
                <dt>Jenis Dokumen</dt>
                <dd>{{ $df['jenis_dokumen'] ?? ($s->document_default_jenis_dokumen ?? 'Formulir') }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Halaman</dt>
                <dd>{{ $df['sp_hal'] ?? ($s->document_default_sp_hal ?? '1 dari 1') }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Pemilik Proses</dt>
                <dd>{{ $df['pemilik_proses'] ?? ($s->document_default_pemilik_proses ?? 'IT Business Support') }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>No. Dokumen</dt>
                <dd>{{ $df['doc_control_no'] ?? ($document->document_no ?: '') }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Tanggal Efektif</dt>
                <dd>
                    @if (isset($df['effective_doc']) && $df['effective_doc'])
                        @php
                            $date = \Carbon\Carbon::parse($df['effective_doc']);
                            $months = [
                                1 => 'januari',
                                2 => 'februari',
                                3 => 'maret',
                                4 => 'april',
                                5 => 'mei',
                                6 => 'juni',
                                7 => 'juli',
                                8 => 'agustus',
                                9 => 'september',
                                10 => 'oktober',
                                11 => 'november',
                                12 => 'desember',
                            ];
                            echo $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
                        @endphp
                    @endif
                </dd>
            </div>
            <div class="doc-detail-item">
                <dt>Tgl. Peninjauan</dt>
                <dd>
                    @if (isset($df['revision_date']) && $df['revision_date'])
                        @php
                            $date = \Carbon\Carbon::parse($df['revision_date']);
                            $months = [
                                1 => 'januari',
                                2 => 'februari',
                                3 => 'maret',
                                4 => 'april',
                                5 => 'mei',
                                6 => 'juni',
                                7 => 'juli',
                                8 => 'agustus',
                                9 => 'september',
                                10 => 'oktober',
                                11 => 'november',
                                12 => 'desember',
                            ];
                            echo $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
                        @endphp
                    @endif
                </dd>
            </div>
            <div class="doc-detail-item">
                <dt>Proses Bisnis</dt>
                <dd>{{ $df['proses_bisnis'] ?? ($s->document_default_proses_bisnis ?? 'Authorization Request') }}</dd>
            </div>
            <div class="doc-detail-item">
                <dt>Petahana</dt>
                <dd>{{ $df['author_doc'] ?? ($sigCreator?->user_name ?? '') }}</dd>
            </div>
        </div>
    </div>
    <div class="detail-section">
        <h5><i class="fa fa-check-square"></i> Approvals</h5>
        @php
            $signs = $document->signatures->keyBy('role');
        @endphp
        <div class="doc-detail-grid">
            <div class="doc-detail-item">
                <dt>Creator</dt>
                <dd>
                    {{ $signs->get('creator')?->user_name ?: '-' }}
                    @if ($signs->get('creator')?->status)
                        <small class="text-muted">{{ $signs->get('creator')->status }}</small>
                    @endif
                </dd>
            </div>
            <div class="doc-detail-item">
                <dt>IT Manager</dt>
                <dd>
                    {{ $signs->get('creator_manager')?->user_name ?: '-' }}
                    @if ($signs->get('creator_manager')?->status)
                        <small class="text-muted">{{ $signs->get('creator_manager')->status }}</small>
                    @endif
                </dd>
            </div>
            <div class="doc-detail-item">
                <dt>User</dt>
                <dd>
                    {{ $signs->get('user')?->user_name ?: '-' }}
                    @if ($signs->get('user')?->status)
                        <small class="text-muted">{{ $signs->get('user')->status }}</small>
                    @endif
                </dd>
            </div>
            <div class="doc-detail-item">
                <dt>Atasan Penerima</dt>
                <dd>
                    {{ $document->atasan_penerima_name ?: ($signs->get('user_manager')?->user_name ?: '-') }}
                    @if ($signs->get('user_manager')?->status)
                        <small class="text-muted">{{ $signs->get('user_manager')->status }}</small>
                    @endif
                </dd>
            </div>
            <div class="doc-detail-item">
                <dt>HR</dt>
                <dd>
                    {{ $signs->get('hr')?->user_name ?: '-' }}
                    @if ($signs->get('hr')?->status)
                        <small class="text-muted">{{ $signs->get('hr')->status }}</small>
                    @endif
                </dd>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 15px 20px;">
    <button type="button" class="btn btn-default" data-dismiss="modal" style="padding: 8px 20px; font-weight: 500;">
        <i class="fa fa-times"></i> Close
    </button>
</div>
<style>
    .doc-detail-modal {
        max-height: 70vh;
        overflow-y: auto;
        padding: 20px;
        background: #ffffff;
    }

    .doc-detail-modal .detail-section {
        margin-bottom: 25px;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #d2d6de;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.3s ease;
    }

    .doc-detail-modal .detail-section:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    }

    .doc-detail-modal .detail-section h5 {
        margin: 0 0 15px 0;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.8px;
        color: #2c3e50;
        border-bottom: 2px solid #5dade2;
        padding-bottom: 8px;
        display: flex;
        align-items: center;
    }

    .doc-detail-modal .detail-section h5 i {
        margin-right: 8px;
        color: #5dade2;
        font-size: 16px;
    }

    .doc-detail-grid {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -8px;
    }

    .doc-detail-item {
        width: 50%;
        padding: 10px 8px;
        display: flex;
        border-bottom: 1px solid #f0f0f0;
        align-items: flex-start;
    }

    .doc-detail-item dt {
        margin: 0;
        font-weight: 600;
        min-width: 140px;
        max-width: 140px;
        color: #555555;
        font-size: 13px;
        line-height: 1.6;
        padding-right: 10px;
    }

    .doc-detail-item dd {
        margin: 0;
        flex: 1;
        color: #333333;
        font-size: 13px;
        line-height: 1.6;
        word-wrap: break-word;
    }

    .doc-detail-item dd:empty:before {
        content: '-';
        color: #999;
    }

    .doc-detail-item:last-child {
        border-bottom: none;
    }

    .doc-detail-item small.text-muted {
        display: inline-block;
        margin-left: 5px;
        padding: 2px 8px;
        background: #f8f9fa;
        border-radius: 3px;
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .doc-detail-item {
            width: 100%;
        }

        .doc-detail-item dt {
            min-width: 120px;
            max-width: 120px;
        }
    }

    /* Custom scrollbar */
    .doc-detail-modal::-webkit-scrollbar {
        width: 8px;
    }

    .doc-detail-modal::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .doc-detail-modal::-webkit-scrollbar-thumb {
        background: #5dade2;
        border-radius: 10px;
    }

    .doc-detail-modal::-webkit-scrollbar-thumb:hover {
        background: #4a9cd0;
    }
</style>

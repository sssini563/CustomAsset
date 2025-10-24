<div class="box box-default" style="border: 1px solid #d2d6de; box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
    <div class="box-header with-border" style="border-bottom: 1px solid #d2d6de; padding: 15px;">
        <h3 class="box-title" style="font-size: 18px; font-weight: 600;">{{ ucfirst($type) }} Documents</h3>
    </div>
    <div class="box-body" style="padding: 20px;">
        <form method="get" class="form-inline mb-2" style="margin-bottom: 20px;">
            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                placeholder="Search..." style="margin-right: 10px;" />
            <button class="btn btn-primary"
                style="background-color:#5dade2 !important; border-color:#5dade2 !important;">Search</button>
        </form>
        <table class="table table-striped table-bordered" style="border: 1px solid #ddd;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No Tanda Terima</th>
                    <th>Nama Penerima</th>
                    @foreach ($columns as $col)
                        <th>{{ $col['label'] }}</th>
                    @endforeach
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                    <tr>
                        <td>{{ $doc->id }}</td>
                        <td>{{ $doc->document_number }}</td>
                        <td>{{ $doc->nama_penerima ?: '' }}</td>
                        @foreach ($columns as $col)
                            <td>{{ data_get($doc, $col['field']) }}</td>
                        @endforeach
                        <td>
                            @php($status = strtolower(trim($doc->overall_status ?? '')))
                            @php($isLocked = !empty($doc->completed_at) || !empty($doc->pdf_path))
                            @php($isComplete = $isLocked || $status === 'complete')
                            @php($isCompleteSign = !$isLocked && $status === 'complete_sign')
                            @php($displayStatus = $isComplete ? 'complete' : ($isCompleteSign ? 'complete sign' : 'pending'))
                            @php($statusClass = $isComplete ? 'label-primary' : ($isCompleteSign ? 'label-success' : 'label-warning'))
                            <span class="label {{ $statusClass }}">{{ $displayStatus }}</span>
                        </td>
                        <td style="white-space:nowrap;">
                            @php($isSigned = false)
                            @php($canComplete = false)
                            @php($sig = $doc->relationLoaded('signatures') ? $doc->signatures : collect())
                            @php($nonLegacy = $sig->reject(fn($s) => in_array($s->role, ['it_manager', 'atasan_penerima'])))
                            @php($assigned = $nonLegacy->filter(fn($s) => !is_null($s->user_id)))
                            @php($canComplete = !$isComplete && $assigned->count() > 0 && $assigned->where('status', 'signed')->count() === $assigned->count())
                            @if (!($isSigned || $isComplete))
                                <button class="btn btn-xs btn-info doc-action"
                                    style="background-color:#5dade2 !important; border-color:#5dade2 !important;"
                                    data-toggle="tooltip" title="Detail" data-modal="detail"
                                    data-id="{{ $doc->id }}">
                                    <i class="fa fa-eye"></i>
                                </button>
                            @endif
                            @if (!($isSigned || $isComplete))
                                <button class="btn btn-xs btn-primary"
                                    style="background-color:#27ae60 !important; border-color:#27ae60 !important;"
                                    data-toggle="tooltip" title="Approval" data-modal="approval"
                                    data-id="{{ $doc->id }}">
                                    <i class="fa fa-check-square"></i>
                                </button>
                            @endif
                            @can('update', $doc)
                                @if (!($isSigned || $isComplete))
                                    <a class="btn btn-xs btn-warning"
                                        style="background-color:#f39c12 !important; border-color:#f39c12 !important;"
                                        data-toggle="tooltip" title="Edit" href="{{ route('documents.edit', $doc->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                @endif
                            @endcan
                            @php($printUrl = $isComplete && !empty($doc->pdf_path) ? route('documents.pdf', $doc->id) : route('documents.print', $doc->id))
                            <a class="btn btn-xs btn-default"
                                style="background:#9b59b6 !important; border-color:#8e44ad !important; color:#fff;"
                                data-toggle="tooltip" title="Cetak" href="{{ $printUrl }}" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>
                            @if ($isCompleteSign || $canComplete)
                                <button class="btn btn-xs btn-success"
                                    style="background-color:#2ecc71 !important; border-color:#27ae60 !important;"
                                    data-toggle="tooltip" title="Kunci &amp; Buat PDF" data-lock="{{ $doc->id }}">
                                    <i class="fa fa-lock"></i>
                                </button>
                            @endif
                            @if ($status === 'pending')
                                @php($hasApproved = ($nonLegacy ?? collect())->where('status', 'signed')->count() > 0)
                                <button class="btn btn-xs btn-danger {{ $hasApproved ? 'disabled' : '' }}"
                                    style="background-color:#EF5350 !important; border-color:#EF5350 !important;"
                                    data-toggle="tooltip" title="Hapus" data-delete="{{ $doc->id }}"
                                    {{ $hasApproved ? 'disabled' : '' }}>
                                    <i class="fa fa-trash"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 6 + count($columns) }}" class="text-center">Tidak ada dokumen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $documents->links() }}
    </div>
</div>
@include('documents.asset.index_scripts')

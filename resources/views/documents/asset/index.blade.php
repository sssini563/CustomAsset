@extends('layouts/default')
@section('title') Documents - {{ ucfirst($type) }} @stop
@section('content')
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
                        @if ($type === 'asset')
                            <th>Device Name</th>
                            <th>Nomor Seri</th>
                            <th>Asset Number</th>
                        @elseif($type === 'license')
                            <th>License Key</th>
                            <th>Seats</th>
                            <th>Vendor</th>
                        @elseif($type === 'accessory')
                            <th>Part Number</th>
                            <th>Serial Number</th>
                            <th>Condition</th>
                        @elseif($type === 'component')
                            <th>Model</th>
                            <th>Part Number</th>
                            <th>Serial Number</th>
                        @elseif($type === 'consumable')
                            <th>Batch</th>
                            <th>Qty</th>
                            <th>Unit</th>
                        @else
                            <th>Device Name</th>
                            <th>Nomor Seri</th>
                            <th>Asset Number</th>
                        @endif
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
                            @if ($type === 'asset')
                                <td>{{ $doc->device_name ?: '' }}</td>
                                <td>{{ $doc->serial_number ?: '' }}</td>
                                <td>{{ $doc->asset_number ?: '' }}</td>
                            @elseif($type === 'license')
                                <td>{{ $doc->license_key ?: '' }}</td>
                                <td>{{ $doc->license_seats ?: '' }}</td>
                                <td>{{ $doc->license_vendor ?: '' }}</td>
                            @elseif($type === 'accessory')
                                <td>{{ $doc->accessory_part_number ?: '' }}</td>
                                <td>{{ $doc->accessory_serial_number ?: '' }}</td>
                                <td>{{ $doc->accessory_condition ?: '' }}</td>
                            @elseif($type === 'component')
                                <td>{{ $doc->component_model ?: '' }}</td>
                                <td>{{ $doc->component_part_number ?: '' }}</td>
                                <td>{{ $doc->component_serial_number ?: '' }}</td>
                            @elseif($type === 'consumable')
                                <td>{{ $doc->consumable_batch ?: '' }}</td>
                                <td>{{ $doc->consumable_qty ?: '' }}</td>
                                <td>{{ $doc->consumable_unit ?: '' }}</td>
                            @else
                                <td>{{ $doc->device_name ?: '' }}</td>
                                <td>{{ $doc->serial_number ?: '' }}</td>
                                <td>{{ $doc->asset_number ?: '' }}</td>
                            @endif
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
                                @php($isSigned = false) {{-- "signed" status removed from UI semantics --}}
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
                                {{-- Complete action is not shown on the list when status is pending; use the detail page to complete. --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada dokumen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $documents->links() }}
        </div>
    </div>
    <div class="modal fade" id="globalDocumentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="width: 95vw; max-width: 1400px;">
            <div class="modal-content"></div>
        </div>
    </div>
@endsection
@section('moar_scripts')
    <style>
        /* Ensure action buttons icons are fully visible and consistent */
        td [class*='btn'].btn-xs.doc-action i {
            line-height: 1;
        }

        td [class*='btn'].btn-xs {
            padding: 4px 6px;
        }

        td [class*='btn'].btn-xs i {
            font-size: 13px;
        }
    </style>
    <script>
        (function() {
            // Base URL for building AJAX endpoints (handles subdirectory installs)
            var BASE_URL = "{{ url('') }}";

            function hasJQuery() {
                return typeof window.jQuery !== 'undefined';
            }

            function initTooltips() {
                // Initialize Bootstrap tooltips only if jQuery + tooltip plugin are present
                try {
                    if (hasJQuery() && typeof jQuery.fn.tooltip === 'function') {
                        jQuery('[data-toggle="tooltip"]').tooltip();
                    }
                } catch (e) {
                    /* no-op */ }
            }

            // Minimal modal fallback to work without jQuery/Bootstrap JS
            function showModal() {
                var modal = document.getElementById('globalDocumentModal');
                if (!modal) return;
                if (hasJQuery() && typeof jQuery(modal).modal === 'function') {
                    jQuery(modal).modal('show');
                    return;
                }
                // Fallback show
                modal.style.display = 'block';
                modal.classList.add('in');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
                // Backdrop
                var backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade in';
                backdrop.id = 'globalDocumentBackdrop';
                document.body.appendChild(backdrop);
            }

            function hideModal() {
                var modal = document.getElementById('globalDocumentModal');
                if (!modal) return;
                if (hasJQuery() && typeof jQuery(modal).modal === 'function') {
                    jQuery(modal).modal('hide');
                    return;
                }
                // Fallback hide
                modal.classList.remove('in');
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
                var backdrop = document.getElementById('globalDocumentBackdrop');
                if (backdrop && backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
            }

            function loadModal(id, type) {
                var modal = document.getElementById('globalDocumentModal');
                if (modal) {
                    var content = modal.querySelector('.modal-content');
                    if (content) content.innerHTML = '<div class="modal-body"><p>Loading...</p></div>';
                }
                showModal();
                fetch('/documents/' + id + '/modal-' + type, {
                        headers: {
                            'Accept': 'text/html'
                        }
                    })
                    .then(r => {
                        if (!r.ok) throw new Error('' + r.status);
                        return r.text();
                    })
                    .then(html => {
                        var modal = document.getElementById('globalDocumentModal');
                        var content = modal ? modal.querySelector('.modal-content') : null;
                        if (content) content.innerHTML = html;
                        initTooltips();
                    })
                    .catch(function(err) {
                        hideModal();
                        if (err && err.name === 'TypeError') {
                            alert('Gagal memuat data approval (network error). Pastikan Anda masih login.');
                        } else {
                            alert('Gagal memuat data approval (HTTP ' + (err.message || 'error') + ').');
                        }
                    });
            }
            document.addEventListener('click', function(e) {
                // Handle close for Bootstrap-less environments
                if (e.target.matches('[data-dismiss="modal"], [data-dismiss="modal"] *')) {
                    hideModal();
                    return;
                }
                // Handle modal action buttons (works even if scripts inside injected HTML do not run)
                if (e.target.closest('[data-action]')) {
                    (async function() {
                        var btn = e.target.closest('[data-action]');
                        var role = btn.getAttribute('data-role');
                        var id = btn.getAttribute('data-id');
                        var action = btn.getAttribute('data-action');
                        try {
                            if (action === 'copy-link') {
                                const link = btn.getAttribute('data-link');
                                try {
                                    if (navigator.clipboard && window.isSecureContext) {
                                        await navigator.clipboard.writeText(link);
                                    } else {
                                        const ta = document.createElement('textarea');
                                        ta.value = link;
                                        ta.style.position = 'fixed';
                                        ta.style.opacity = '0';
                                        document.body.appendChild(ta);
                                        ta.focus();
                                        ta.select();
                                        document.execCommand('copy');
                                        document.body.removeChild(ta);
                                    }
                                    // log copied (fire-and-forget)
                                    fetch('/documents/' + id + '/signature/' + role + '/copied-link', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    });
                                    const origClass = btn.className;
                                    const origHtml = btn.innerHTML;
                                    btn.className = origClass.replace('btn-default', 'btn-success');
                                    btn.innerHTML = '<i class="fa fa-check"></i>';
                                    setTimeout(() => {
                                        btn.className = origClass;
                                        btn.innerHTML = origHtml;
                                    }, 900);
                                } catch (_e) {
                                    alert('Gagal menyalin tautan');
                                }
                                return;
                            }
                            if (action === 'send-link') {
                                let r = await fetch('/documents/' + id + '/signature/' + role +
                                    '/send-link', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    });
                                if (!r.ok) throw new Error('Failed to send');
                                alert('Link sent to signer email.');
                                return;
                            }
                            if (action === 'cancel-signature') {
                                if (!confirm('Cancel this signature (reset to pending)?')) return;
                                let r = await fetch('/documents/' + id + '/signature/' + role +
                                    '/cancel', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    });
                                if (!r.ok) throw new Error('Failed to cancel');
                                reloadApproval();
                                return;
                            }
                            if (action === 'regen-token') {
                                if (!confirm('Regenerate public token for this signer?')) return;
                                let r = await fetch('/documents/' + id + '/signature/' + role +
                                    '/regenerate-token', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    });
                                if (!r.ok) throw new Error('Failed to regenerate');
                                let data = await r.json();
                                const tr = btn.closest('tr');
                                const copyBtn = tr ? tr.querySelector('[data-action="copy-link"]') :
                                    null;
                                if (copyBtn && data.token) {
                                    copyBtn.setAttribute('data-link',
                                        '{{ route('public.documents.approval.show', '__TOKEN__') }}'
                                        .replace('__TOKEN__', data.token));
                                }
                                alert('Token regenerated.');
                                return;
                            }
                            if (action === 'disable-token') {
                                if (!confirm('Disable this public token now?')) return;
                                let r = await fetch('/documents/' + id + '/signature/' + role +
                                    '/disable-token', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    });
                                if (!r.ok) throw new Error('Failed to disable');
                                alert('Token disabled.');
                                reloadApproval();
                                return;
                            }
                        } catch (err) {
                            alert(err.message || 'Error');
                        }
                    })();
                    return;
                }
                if (e.target.closest('[data-modal]')) {
                    var btn = e.target.closest('[data-modal]');
                    loadModal(btn.getAttribute('data-id'), btn.getAttribute('data-modal'));
                }
                if (e.target.closest('[data-delete]')) {
                    var del = e.target.closest('[data-delete]');
                    if (del.disabled || del.classList.contains('disabled')) return;
                    if (!confirm('Delete this document?')) return;
                    var id = del.getAttribute('data-delete');
                    fetch('/documents/' + id, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(r => {
                            if (!r.ok) throw new Error();
                            return r.json();
                        })
                        .then(() => location.reload())
                        .catch(() => alert('Gagal menghapus dokumen.'));
                }
                if (e.target.closest('[data-lock]')) {
                    var lockBtn = e.target.closest('[data-lock]');
                    var id = lockBtn.getAttribute('data-lock');
                    var orig = lockBtn.innerHTML;
                    lockBtn.disabled = true;
                    lockBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                    fetch('/documents/' + id + '/complete', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(async r => {
                            if (!r.ok) {
                                let m = 'Lock failed';
                                try {
                                    const j = await r.json();
                                    if (j.message) m = j.message;
                                } catch (_) {}
                                throw new Error(m);
                            }
                            return r.json();
                        })
                        .then(() => {
                            window.location.href = BASE_URL + '/documents/' + id + '/pdf';
                        })
                        .catch(err => {
                            alert(err.message || 'Error');
                            lockBtn.disabled = false;
                            lockBtn.innerHTML = orig;
                        });
                    return;
                }
                if (e.target.closest('[data-complete]')) {
                    var btn = e.target.closest('[data-complete]');
                    if (btn.disabled) return;
                    if (!confirm('Mark this document as COMPLETE and lock it from further edits?')) return;
                    var id = btn.getAttribute('data-complete');
                    var origHtml = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                    fetch('/documents/' + id + '/complete', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(async r => {
                            if (!r.ok) {
                                let msg = 'Failed to complete';
                                try {
                                    const j = await r.json();
                                    if (j && j.message) msg = j.message;
                                } catch (_e) {}
                                throw new Error(msg);
                            }
                            return r.json();
                        })
                        .then(() => location.reload())
                        .catch(err => {
                            alert(err.message || 'Error');
                            btn.disabled = false;
                            btn.innerHTML = origHtml;
                        })
                }
            });
            window.reloadApproval = function() {
                var modal = document.getElementById('globalDocumentModal');
                if (!modal) return;
                var el = modal.querySelector('[data-role]') || modal.querySelector('[data-modal]') || modal;
                var id = el ? el.getAttribute('data-id') : null;
                if (id) loadModal(id, 'approval');
            }
            document.addEventListener('DOMContentLoaded', initTooltips);
        })();
    </script>
@endsection

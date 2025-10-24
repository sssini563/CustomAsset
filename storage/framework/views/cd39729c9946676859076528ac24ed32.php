<div class="modal-header"
    style="background: linear-gradient(to right, #f8f9fa, #ffffff); border-bottom: 2px solid #5dade2; padding: 20px;">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" style="font-size: 20px; font-weight: 600; color: #2c3e50;">
        <i class="fa fa-check-square" style="color: #5dade2;"></i> Approval Document
        <strong style="color: #5dade2;"><?php echo e($document->document_number); ?></strong>
    </h4>
</div>
<div class="modal-body doc-approval-modal">
    <div class="table-responsive">
        <table class="table table-bordered table-striped approval-table">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Employee ID</th>
                    <th>Status</th>
                    <th>Note</th>
                    <th>Signed At</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $document->signatures->sortBy('ordering'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        if (in_array($sig->role, ['it_manager', 'atasan_penerima'])) {
                            continue;
                        }
                        $displayRole = $sig->role;
                        if ($sig->role === 'creator_manager') {
                            $displayRole = 'IT Manager';
                        }
                        if ($sig->role === 'user_manager') {
                            $displayRole = 'Atasan Penerima';
                        }
                        if ($sig->role === 'hr') {
                            $displayRole = 'HR';
                        }
                    ?>
                    <tr>
                        <td><?php echo e($displayRole); ?></td>
                        <td><strong><?php echo e($sig->user_name); ?></strong></td>
                        <td><small class="text-muted"><?php echo e(optional($sig->user)->email); ?></small></td>
                        <td><?php echo e(optional($sig->user)->employee_num); ?></td>
                        <td>
                            <?php
                                $statusBadgeClass = match ($sig->status) {
                                    'signed' => 'label-success',
                                    'rejected' => 'label-danger',
                                    default => 'label-warning',
                                };
                            ?>
                            <span class="label <?php echo e($statusBadgeClass); ?>"
                                style="font-size: 11px; padding: 4px 10px; border-radius: 3px;">
                                <?php echo e(strtoupper($sig->status)); ?>

                            </span>
                            <?php if($sig->status === 'pending'): ?>
                                <?php
                                    $expired =
                                        $sig->public_token_expires_at &&
                                        now()->greaterThan($sig->public_token_expires_at);
                                ?>
                                <?php if($sig->public_token_expires_at): ?>
                                    <br>
                                    <small class="<?php echo e($expired ? 'text-danger' : 'text-muted'); ?>">
                                        token <?php echo e($expired ? 'expired' : 'exp'); ?>:
                                        <?php echo e($sig->public_token_expires_at->format('Y-m-d H:i')); ?>

                                    </small>
                                <?php endif; ?>
                                <?php if($sig->last_used_at): ?>
                                    <br><small class="text-muted">last used:
                                        <?php echo e($sig->last_used_at->format('Y-m-d H:i')); ?></small>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($sig->note)): ?>
                                <span
                                    class="label <?php echo e($sig->status === 'rejected' ? 'label-danger' : 'label-default'); ?>"
                                    style="display:inline-block;margin-bottom:4px;"><?php echo e($sig->status === 'rejected' ? 'Reject Note' : 'Note'); ?></span>
                                <div style="max-width:280px;white-space:normal;word-break:break-word;">
                                    <?php echo e($sig->note); ?></div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($sig->signed_at); ?></td>
                        <td>
                            <?php ($link = route('public.documents.approval.show', [$sig->public_token])); ?>
                            <div class="btn-group" role="group">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $document)): ?>
                                    <?php if($sig->status === 'pending'): ?>
                                        <!-- Pending: show copy, send, regenerate/enable, disable. Hide cancel. -->
                                        <button class="btn btn-xs btn-default" data-action="copy-link"
                                            data-role="<?php echo e($sig->role); ?>" data-id="<?php echo e($document->id); ?>"
                                            data-link="<?php echo e($link); ?>" title="Copy link"><i
                                                class="fa fa-link"></i></button>
                                        <button class="btn btn-xs btn-primary" data-action="send-link"
                                            data-role="<?php echo e($sig->role); ?>" data-id="<?php echo e($document->id); ?>"
                                            title="Send link to email"><i class="fa fa-envelope"></i></button>
                                        <button class="btn btn-xs btn-info" data-action="regen-token"
                                            data-role="<?php echo e($sig->role); ?>" data-id="<?php echo e($document->id); ?>"
                                            title="<?php echo e($expired ? 'Enable token' : 'Regenerate token'); ?>">
                                            <i class="fa <?php echo e($expired ? 'fa-play' : 'fa-refresh'); ?>"></i>
                                        </button>
                                        <button class="btn btn-xs btn-default" data-action="disable-token"
                                            data-role="<?php echo e($sig->role); ?>" data-id="<?php echo e($document->id); ?>"
                                            title="Disable token"><i class="fa fa-ban"></i></button>
                                    <?php elseif(in_array($sig->status, ['signed', 'rejected'])): ?>
                                        <!-- Signed/Rejected: hide copy/send/regen/disable; show Cancel Approval to reset -->
                                        <button class="btn btn-xs btn-warning" data-action="cancel-signature"
                                            data-role="<?php echo e($sig->role); ?>" data-id="<?php echo e($document->id); ?>"
                                            title="Cancel approval"><i class="fa fa-undo"></i></button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 15px 20px;">
    <button type="button" class="btn btn-default" data-dismiss="modal" style="padding: 8px 20px; font-weight: 500;">
        <i class="fa fa-times"></i> Close
    </button>
</div>
<style>
    /* Modal Body */
    .doc-approval-modal {
        max-height: 70vh;
        overflow-y: auto;
        padding: 15px;
    }

    /* Table Styling - Simple & Clean */
    .approval-table {
        margin-bottom: 0;
    }

    .approval-table thead th {
        background-color: #f5f5f5;
        font-weight: 600;
        font-size: 13px;
        border-bottom: 2px solid #ddd;
        padding: 10px 8px;
        white-space: nowrap;
    }

    .approval-table tbody td {
        padding: 10px 8px;
        vertical-align: middle;
        font-size: 13px;
    }

    .approval-table tbody tr:hover {
        background-color: #f9f9f9;
    }

    /* Action Column */
    .approval-table th:last-child,
    .approval-table td:last-child {
        width: 180px;
        text-align: center;
    }

    /* Button Group */
    .approval-table .btn-group .btn.btn-xs {
        min-width: 30px;
        height: 28px;
        padding: 4px 8px;
        margin: 0 2px;
    }

    .approval-table .btn-group .btn.btn-xs i {
        font-size: 13px;
    }

    /* Small text */
    .approval-table td small {
        display: block;
        margin-top: 3px;
        font-size: 11px;
    }

    /* Custom scrollbar */
    .doc-approval-modal::-webkit-scrollbar {
        width: 8px;
    }

    .doc-approval-modal::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .doc-approval-modal::-webkit-scrollbar-thumb {
        background: #999;
        border-radius: 4px;
    }

    .doc-approval-modal::-webkit-scrollbar-thumb:hover {
        background: #777;
    }
</style>
<script>
    (function() {
        var BASE_URL = ""; // use relative URLs to avoid mixed-content or host mismatch
        var modal = document.getElementById('globalDocumentModal');
        if (!modal) return;
        var content = modal.querySelector('.modal-content');
        if (!content) return;
        // Remove previous handler if re-opened
        if (modal._docActionsHandler) {
            content.removeEventListener('click', modal._docActionsHandler);
        }
        modal._docActionsHandler = async function(ev) {
            var btn = ev.target.closest('[data-action]');
            if (!btn) return;
            var role = btn.getAttribute('data-role');
            var id = btn.getAttribute('data-id');
            var action = btn.getAttribute('data-action');
            try {
                if (action === 'copy-link') {
                    const link = btn.getAttribute('data-link');
                    // copy via Clipboard API with fallback
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
                        // log copied
                        fetch('/documents/' + id + '/signature/' + role + '/copied-link', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json'
                            }
                        });
                        // visual feedback without jQuery
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
                    let r = await fetch('/documents/' + id + '/signature/' + role + '/send-link', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Accept': 'application/json'
                        }
                    });
                    if (!r.ok) throw new Error('Failed to send');
                    alert('Link sent to signer email.');
                    return;
                }
                if (action === 'cancel-signature') {
                    if (!confirm('Cancel this signature (reset to pending)?')) return;
                    let r = await fetch('/documents/' + id + '/signature/' + role + '/cancel', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Accept': 'application/json'
                        }
                    });
                    if (!r.ok) throw new Error('Failed to cancel');
                    reloadApproval();
                    return;
                }
                if (action === 'regen-token') {
                    if (!confirm('Regenerate public token for this signer?')) return;
                    let r = await fetch('/documents/' + id + '/signature/' + role + '/regenerate-token', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Accept': 'application/json'
                        }
                    });
                    if (!r.ok) throw new Error('Failed to regenerate');
                    let data = await r.json();
                    // update link on the copy button in the same row
                    const tr = btn.closest('tr');
                    const copyBtn = tr.querySelector('[data-action="copy-link"]');
                    if (copyBtn && data.token) {
                        copyBtn.setAttribute('data-link',
                            '<?php echo e(route('public.documents.approval.show', '__TOKEN__')); ?>'.replace(
                                '__TOKEN__', data.token));
                    }
                    alert('Token regenerated.');
                    return;
                }
                if (action === 'disable-token') {
                    if (!confirm('Disable this public token now?')) return;
                    let r = await fetch('/documents/' + id + '/signature/' + role + '/disable-token', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Accept': 'application/json'
                        }
                    });
                    if (!r.ok) throw new Error('Failed to disable');
                    alert('Token disabled.');
                    reloadApproval();
                    return;
                }
            } catch (e) {
                if (e.name === 'TypeError') {
                    alert(
                        'Gagal memanggil server (network error). Pastikan Anda masih login dan URL sesuai.'
                        );
                } else {
                    alert(e.message || 'Error');
                }
            }
        };
        content.addEventListener('click', modal._docActionsHandler);
    })();
</script>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/documents/asset/partials/modal-approval.blade.php ENDPATH**/ ?>
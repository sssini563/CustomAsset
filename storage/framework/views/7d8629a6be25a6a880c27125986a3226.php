
<?php $__env->startSection('title'); ?> Edit Document <?php echo e($document->document_number); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <style>
        /* Fix select box visibility */
        .sig-select,
        select.sig-select,
        .input-group select.sig-select {
            color: #333 !important;
            background-color: #fff !important;
            -webkit-appearance: menulist !important;
            -moz-appearance: menulist !important;
            appearance: menulist !important;
        }

        .sig-select option,
        select.sig-select option {
            color: #333 !important;
            background-color: #fff !important;
            padding: 5px;
        }

        .sig-select:focus,
        select.sig-select:focus {
            color: #333 !important;
            background-color: #fff !important;
            border-color: #5dade2 !important;
        }

        /* Fix for Firefox and other browsers */
        select.form-control.sig-select {
            color: #333 !important;
            background-color: #fff !important;
        }

        /* Ensure text is visible in dropdown */
        .sig-select option:checked,
        .sig-select option:hover {
            background-color: #5dade2 !important;
            color: #fff !important;
        }

        /* Signature Table Styling */
        .signature-table {
            margin-bottom: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .signature-table thead th {
            font-weight: 600;
            text-align: left;
            padding: 12px 10px;
            border: none;
            font-size: 14px;
        }

        .signature-table tbody td {
            padding: 12px 10px;
            vertical-align: middle;
            font-size: 13px;
        }

        .signature-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .signature-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .signature-table .fa {
            margin-right: 5px;
        }

        .signature-table .label {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: 600;
        }

        .signature-table .btn-assign-user {
            background-color: #5dade2;
            border-color: #5dade2;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .signature-table .btn-assign-user:hover {
            background-color: #3498db;
            border-color: #3498db;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .table-responsive {
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Modal Assign User Styling */
        #assignUserModal .modal-dialog {
            width: 700px;
            max-width: 90%;
        }

        #assignUserModal .help-block {
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            margin-top: 5px;
            margin-bottom: 0;
        }

        #assignUserModal select.form-control {
            width: 100%;
        }
    </style>

    <div class="box box-default" style="border: 1px solid #d2d6de; box-shadow: 0 1px 3px rgba(0,0,0,0.12);">
        <div class="box-header with-border" style="border-bottom: 1px solid #d2d6de; padding: 15px;">
            <h3 class="box-title" style="font-size: 18px; font-weight: 600;">Edit Document <?php echo e($document->document_number); ?>

            </h3>
        </div>
        <form method="POST" action="<?php echo e(route('documents.update', $document)); ?>" class="form-horizontal">
            <?php echo csrf_field(); ?>
            <div class="box-body" style="padding: 20px;">
                <!-- Nav tabs -->
                <?php
                    $softLabel = 'Software';
                    switch (strtolower($document->type)) {
                        case 'component':
                            $softLabel = 'Component Details';
                            break;
                        case 'accessory':
                            $softLabel = 'Accessories Details';
                            break;
                        case 'license':
                            $softLabel = 'License Details';
                            break;
                        case 'consumable':
                            $softLabel = 'Consumable Details';
                            break;
                    }
                ?>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#header" role="tab" data-toggle="tab">Header</a></li>
                    <li><a href="#recipient" role="tab" data-toggle="tab">Penerima</a></li>
                    <?php if(strtolower($document->type) === 'asset'): ?>
                        <li><a href="#hardware" role="tab" data-toggle="tab">Hardware</a></li>
                    <?php endif; ?>
                    <li><a href="#software" role="tab" data-toggle="tab"><?php echo e($softLabel); ?></a></li>
                    <?php if(strtolower($document->type) === 'asset'): ?>
                        <li><a href="#documents" role="tab" data-toggle="tab">Documents & Notes</a></li>
                    <?php endif; ?>
                    <li><a href="#signatures" role="tab" data-toggle="tab">Signatures</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" style="margin-top:20px;">
                    <div class="tab-pane active" id="header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label class="col-sm-4 control-label">No Tanda Terima</label>
                                    <div class="col-sm-8">
                                        <div class="input-group"><input value="<?php echo e($document->document_number); ?>"
                                                class="form-control" disabled /><span class="input-group-btn"><button
                                                    type="button" id="btn-regen-number" class="btn btn-default"
                                                    title="Generate ulang"><i class="fa fa-refresh"></i></button></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Document Number</label>
                                    <div class="col-sm-8"><input name="document_no"
                                            value="<?php echo e(old('document_no', $document->document_no)); ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Document Date</label>
                                    <div class="col-sm-8"><input value="<?php echo e($document->document_date?->format('d F Y')); ?>"
                                            class="form-control" disabled /></div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Requestor &amp; ID</label>
                                    <div class="col-sm-8">
                                        <?php $userSig = $document->signatures->firstWhere('role','user'); ?>
                                        <?php if(strtolower($document->type) !== 'asset'): ?>
                                            <?php $reqName = optional($userSig?->user)->present()->fullName ?? ($userSig?->user_name ?? $document->nama_penerima ?? ''); ?>
                                            <input value="<?php echo e($reqName); ?>" class="form-control" disabled />
                                            <input type="hidden" name="requestor" value="<?php echo e($reqName); ?>" />
                                            <p class="help-block">Untuk dokumen non-asset, Requestor otomatis diisi dengan
                                                User (Penerima).</p>
                                        <?php else: ?>
                                            <input name="requestor" value="<?php echo e(old('requestor', $document->requestor)); ?>"
                                                class="form-control" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Organization Structure</label>
                                    <div class="col-sm-8"><input name="organization_structure"
                                            value="<?php echo e(old('organization_structure', $document->organization_structure)); ?>"
                                            class="form-control" /></div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Position</label>
                                    <div class="col-sm-8"><input name="position"
                                            value="<?php echo e(old('position', $document->position)); ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-4 control-label">Location</label>
                                    <div class="col-sm-8"><input name="location"
                                            value="<?php echo e(old('location', $document->location)); ?>" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="recipient">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label class="col-sm-4 control-label">Nama Penerima</label>
                                    <div class="col-sm-8">
                                        <input
                                            value="<?php echo e(optional($userSig?->user)->present()->fullName ?? ($userSig?->user_name ?? '')); ?>"
                                            class="form-control" disabled>
                                        <p class="help-block">Ubah melalui bagian Signatures di bawah.</p>
                                    </div>
                                </div>
                                <?php if(strtolower($document->type) === 'asset'): ?>
                                    <?php $userManagerSig = $document->signatures->firstWhere('role','user_manager'); ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">Atasan Penerima</label>
                                        <div class="col-sm-8">
                                            <input
                                                value="<?php echo e(optional($userManagerSig?->user)->present()->fullName ?? ($userManagerSig?->user_name ?? '')); ?>"
                                                class="form-control" disabled>
                                            <p class="help-block">Ubah melalui bagian Signatures di bawah.</p>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Type Asset</label>
                                        <div class="col-sm-8"><input name="type_device"
                                                value="<?php echo e(old('type_device', $document->type_device)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Asset Number</label>
                                        <div class="col-sm-8"><input name="asset_number"
                                                value="<?php echo e(old('asset_number', $document->asset_number)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">GR Number</label>
                                        <div class="col-sm-8"><input name="gr_number"
                                                value="<?php echo e(old('gr_number', $document->gr_number)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="signatures">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="margin-bottom: 20px; padding: 10px 15px; border-left: 4px solid #5dade2;">
                                    <i class="fa fa-info-circle" style="color: #5dade2;"></i>
                                    <strong style="color: #333;">Petunjuk:</strong>
                                    <span style="color: #666;">Klik tombol <strong>Edit</strong> untuk mengubah user atau
                                        memperbarui informasi user (nama, email, employee ID).</span>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered signature-table">
                                        <thead
                                            style="background: linear-gradient(135deg, #5dade2 0%, #3498db 100%); color: white;">
                                            <tr>
                                                <th style="width: 15%;">Role</th>
                                                <th style="width: 20%;">Name</th>
                                                <th style="width: 20%;">Email</th>
                                                <th style="width: 15%;">Employee ID</th>
                                                <th style="width: 15%;">Status</th>
                                                <th style="width: 15%; text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $document->signatures->sortBy('ordering'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(strtolower($document->type) !== 'asset' && !in_array($sig->role, ['creator', 'user'])): ?>
                                                    <?php continue; ?>
                                                <?php endif; ?>
                                                
                                                <?php if(in_array($sig->role, ['it_manager', 'atasan_penerima'])): ?>
                                                    <?php continue; ?>
                                                <?php endif; ?>
                                                <?php $displayRole = $sig->role; ?>
                                                <?php if($sig->role === 'creator_manager'): ?>
                                                    <?php $displayRole = 'IT Manager'; ?>
                                                <?php endif; ?>
                                                <?php if($sig->role === 'user_manager'): ?>
                                                    <?php $displayRole = 'Atasan Penerima'; ?>
                                                <?php endif; ?>
                                                <?php if($sig->role === 'hr'): ?>
                                                    <?php $displayRole = 'HR'; ?>
                                                <?php endif; ?>
                                                <?php
                                                    $statusBadge = match ($sig->status) {
                                                        'signed'
                                                            => '<span class="label label-success"><i class="fa fa-check-circle"></i> Signed</span>',
                                                        'rejected'
                                                            => '<span class="label label-danger"><i class="fa fa-times-circle"></i> Rejected</span>',
                                                        default
                                                            => '<span class="label label-warning"><i class="fa fa-clock-o"></i> Pending</span>',
                                                    };
                                                ?>
                                                <tr>
                                                    <td><strong><?php echo e($displayRole); ?></strong></td>
                                                    <td>
                                                        <i class="fa fa-user text-muted"></i>
                                                        <span class="sig-cell sig-name"
                                                            data-sig-id="<?php echo e($sig->id); ?>">
                                                            <?php echo e(optional($sig->user)->present()->fullName ?? ($sig->user_name ?? '-')); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-envelope text-muted"></i>
                                                        <span class="sig-cell sig-email"
                                                            data-sig-id="<?php echo e($sig->id); ?>">
                                                            <?php echo e(optional($sig->user)->email ?? '-'); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-id-card text-muted"></i>
                                                        <span class="sig-cell sig-employee"
                                                            data-sig-id="<?php echo e($sig->id); ?>">
                                                            <?php echo e(optional($sig->user)->employee_num ?? '-'); ?>

                                                        </span>
                                                    </td>
                                                    <td><?php echo $statusBadge; ?></td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                            // Only allow editing if status is pending (not signed or rejected)
                                                            // For 'user' role: only allow edit info, not change user
                                                            // For other roles: allow both change user and edit info
                                                            $allowEdit =
                                                                $sig->status === 'pending' &&
                                                                ($sig->role === 'creator' ||
                                                                    $sig->role === 'creator_manager' ||
                                                                    $sig->role === 'user' ||
                                                                    $sig->role === 'user_manager' ||
                                                                    $sig->role === 'hr');
                                                            $allowChangeUser = $allowEdit && $sig->role !== 'user'; // user role can't change user
                                                            $p = optional($sig->user);
                                                        ?>
                                                        <?php if($allowEdit): ?>
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary btn-assign-user"
                                                                data-sig-id="<?php echo e($sig->id); ?>"
                                                                data-role="<?php echo e($sig->role); ?>"
                                                                data-display-role="<?php echo e($displayRole); ?>"
                                                                data-user-id="<?php echo e($p->id); ?>"
                                                                data-user-name="<?php echo e($p->present()->fullName ?? ($p->name ?? $p->username)); ?>"
                                                                data-email="<?php echo e($p->email); ?>"
                                                                data-employee-num="<?php echo e($p->employee_num); ?>"
                                                                data-allow-change-user="<?php echo e($allowChangeUser ? '1' : '0'); ?>"
                                                                title="Edit <?php echo e($allowChangeUser ? 'User & Info' : 'User Info'); ?>">
                                                                <i class="fa fa-pencil"></i> Edit
                                                            </button>
                                                        <?php else: ?>
                                                            <em>Locked</em>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(strtolower($document->type) === 'asset'): ?>
                        <div class="tab-pane" id="hardware">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"><label class="col-sm-4 control-label">Device Name</label>
                                        <div class="col-sm-8"><input name="device_name"
                                                value="<?php echo e(old('device_name', $document->device_name)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Merk</label>
                                        <div class="col-sm-8"><input name="merk"
                                                value="<?php echo e(old('merk', $document->merk)); ?>" class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Processor</label>
                                        <div class="col-sm-8"><input name="processor"
                                                value="<?php echo e(old('processor', $document->processor)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Memory</label>
                                        <div class="col-sm-8"><input name="memory"
                                                value="<?php echo e(old('memory', $document->memory)); ?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Harddisk</label>
                                        <div class="col-sm-8"><input name="hardisk"
                                                value="<?php echo e(old('hardisk', $document->hardisk)); ?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Serial Number</label>
                                        <div class="col-sm-8"><input name="serial_number"
                                                value="<?php echo e(old('serial_number', $document->serial_number)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Battery</label>
                                        <div class="col-sm-8"><input name="battery"
                                                value="<?php echo e(old('battery', $document->battery)); ?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Serial Number
                                            Battery</label>
                                        <div class="col-sm-8"><input name="serial_number_battery"
                                                value="<?php echo e(old('serial_number_battery', $document->serial_number_battery)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Tas</label>
                                        <div class="col-sm-8"><input name="tas"
                                                value="<?php echo e(old('tas', $document->tas)); ?>" class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Adaptor</label>
                                        <div class="col-sm-8"><input name="adaptor"
                                                value="<?php echo e(old('adaptor', $document->adaptor)); ?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Serial Number
                                            Adaptor</label>
                                        <div class="col-sm-8"><input name="serial_number_adaptor"
                                                value="<?php echo e(old('serial_number_adaptor', $document->serial_number_adaptor)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Foto Device</label>
                                        <div class="col-sm-8"><input name="foto_device"
                                                value="<?php echo e(old('foto_device', $document->foto_device)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="tab-pane" id="software">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if(strtolower($document->type) === 'license'): ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">License Key</label>
                                        <div class="col-sm-8"><input name="license_key"
                                                value="<?php echo e(old('license_key', $document->license_key)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Seats</label>
                                        <div class="col-sm-8"><input type="number" name="license_seats"
                                                value="<?php echo e(old('license_seats', $document->license_seats)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Vendor</label>
                                        <div class="col-sm-8"><input name="license_vendor"
                                                value="<?php echo e(old('license_vendor', $document->license_vendor)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Expiry Date</label>
                                        <div class="col-sm-8"><input type="date" name="license_expires_at"
                                                value="<?php echo e(old('license_expires_at', optional($document->license_expires_at)->format('Y-m-d'))); ?>"
                                                class="form-control" /></div>
                                    </div>
                                <?php elseif(strtolower($document->type) === 'accessory'): ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">Part Number</label>
                                        <div class="col-sm-8"><input name="accessory_part_number"
                                                value="<?php echo e(old('accessory_part_number', $document->accessory_part_number)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Serial Number</label>
                                        <div class="col-sm-8"><input name="accessory_serial_number"
                                                value="<?php echo e(old('accessory_serial_number', $document->accessory_serial_number)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Condition</label>
                                        <div class="col-sm-8"><input name="accessory_condition"
                                                value="<?php echo e(old('accessory_condition', $document->accessory_condition)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Notes</label>
                                        <div class="col-sm-8">
                                            <textarea name="accessory_notes" class="form-control" rows="3"><?php echo e(old('accessory_notes', $document->accessory_notes)); ?></textarea>
                                        </div>
                                    </div>
                                <?php elseif(strtolower($document->type) === 'component'): ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">Model</label>
                                        <div class="col-sm-8"><input name="component_model"
                                                value="<?php echo e(old('component_model', $document->component_model)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Part No</label>
                                        <div class="col-sm-8"><input name="component_part_number"
                                                value="<?php echo e(old('component_part_number', $document->component_part_number)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Serial Number</label>
                                        <div class="col-sm-8"><input name="component_serial_number"
                                                value="<?php echo e(old('component_serial_number', $document->component_serial_number)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Spec</label>
                                        <div class="col-sm-8">
                                            <textarea name="component_spec" class="form-control" rows="3"><?php echo e(old('component_spec', $document->component_spec)); ?></textarea>
                                        </div>
                                    </div>
                                <?php elseif(strtolower($document->type) === 'consumable'): ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">Batch</label>
                                        <div class="col-sm-8"><input name="consumable_batch"
                                                value="<?php echo e(old('consumable_batch', $document->consumable_batch)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Qty</label>
                                        <div class="col-sm-8"><input type="number" name="consumable_qty"
                                                value="<?php echo e(old('consumable_qty', $document->consumable_qty)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Unit</label>
                                        <div class="col-sm-8"><input name="consumable_unit"
                                                value="<?php echo e(old('consumable_unit', $document->consumable_unit)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Notes</label>
                                        <div class="col-sm-8">
                                            <textarea name="consumable_notes" class="form-control" rows="3"><?php echo e(old('consumable_notes', $document->consumable_notes)); ?></textarea>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">
                                            <?php if(strtolower($document->type) === 'asset'): ?>
                                                Windows
                                            <?php else: ?>
                                                Detail 1
                                            <?php endif; ?>
                                        </label>
                                        <div class="col-sm-8"><input name="windows"
                                                value="<?php echo e(old('windows', $document->windows)); ?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">
                                            <?php if(strtolower($document->type) === 'asset'): ?>
                                                Office
                                            <?php else: ?>
                                                Detail 2
                                            <?php endif; ?>
                                        </label>
                                        <div class="col-sm-8"><input name="office"
                                                value="<?php echo e(old('office', $document->office)); ?>" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">
                                            <?php if(strtolower($document->type) === 'asset'): ?>
                                                Antivirus
                                            <?php else: ?>
                                                Detail 3
                                            <?php endif; ?>
                                        </label>
                                        <div class="col-sm-8"><input name="antivirus"
                                                value="<?php echo e(old('antivirus', $document->antivirus)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">
                                            <?php if(strtolower($document->type) === 'asset'): ?>
                                                Compress Tools
                                            <?php else: ?>
                                                Detail 4
                                            <?php endif; ?>
                                        </label>
                                        <div class="col-sm-8"><input name="compress_tools"
                                                value="<?php echo e(old('compress_tools', $document->compress_tools)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                <?php endif; ?>
                                <?php if(strtolower($document->type) === 'asset'): ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">Reader Tools</label>
                                        <div class="col-sm-8"><input name="reader_tool"
                                                value="<?php echo e(old('reader_tool', $document->reader_tool)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Browser</label>
                                        <div class="col-sm-8"><input name="browser"
                                                value="<?php echo e(old('browser', $document->browser)); ?>" class="form-control" />
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if(strtolower($document->type) !== 'asset'): ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">Catatan</label>
                                        <div class="col-sm-8">
                                            <textarea name="catatan" class="form-control" rows="3"><?php echo e(old('catatan', $document->catatan)); ?></textarea>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <?php if(strtolower($document->type) === 'asset'): ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">Other App 1</label>
                                        <div class="col-sm-8"><input name="other_application_1"
                                                value="<?php echo e(old('other_application_1', $document->other_application_1)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Other App 2</label>
                                        <div class="col-sm-8"><input name="other_application_2"
                                                value="<?php echo e(old('other_application_2', $document->other_application_2)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Other App 3</label>
                                        <div class="col-sm-8"><input name="other_application_3"
                                                value="<?php echo e(old('other_application_3', $document->other_application_3)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-4 control-label">Other App 4</label>
                                        <div class="col-sm-8"><input name="other_application_4"
                                                value="<?php echo e(old('other_application_4', $document->other_application_4)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if(strtolower($document->type) === 'asset'): ?>
                        <div class="tab-pane" id="documents">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"><label class="col-sm-2 control-label">Dokumen Pengembalian
                                            Asset</label>
                                        <div class="col-sm-10"><input name="dokumen_pengembalian_asset"
                                                value="<?php echo e(old('dokumen_pengembalian_asset', $document->dokumen_pengembalian_asset)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">Dokumen Surat
                                            Pernyataan</label>
                                        <div class="col-sm-10"><input name="dokumen_surat_pernyataan"
                                                value="<?php echo e(old('dokumen_surat_pernyataan', $document->dokumen_surat_pernyataan)); ?>"
                                                class="form-control" /></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">Catatan</label>
                                        <div class="col-sm-10">
                                            <textarea name="catatan" class="form-control" rows="3"><?php echo e(old('catatan', $document->catatan)); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <div class="box-footer"
                style="padding: 15px; border-top: 1px solid #d2d6de; overflow: hidden; display: flex; justify-content: space-between; align-items: center;">
                <a href="<?php echo e(route('documents.index', ['type' => $document->type])); ?>" class="btn btn-default"
                    style="float: left;">Cancel</a>
                <button class="btn btn-primary"
                    style="background-color:#5dade2 !important; border-color:#5dade2 !important; float: right;">Save</button>
            </div>
        </form>
    </div>
    <script type="application/json" id="users-data"><?php echo json_encode(
  $users->mapWithKeys(function($u){
    return [$u->id => [
      'name' => $u->present()->fullName ?? ($u->name ?? $u->username),
      'email' => $u->email,
      'employee_num' => $u->employee_num,
      'manager_id' => $u->manager_id,
      'manager_name' => $u->manager?->present()->fullName ?? ($u->manager?->name ?? $u->manager?->username),
    ]];
  })
); ?></script>
    <!-- Assign User Modal -->
    <div class="modal fade" id="assignUserModal" tabindex="-1" role="dialog" aria-labelledby="assignUserModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="assignUserModalLabel">Edit User & Info</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="assign-sig-id" value="">
                    <input type="hidden" id="assign-role" value="">
                    <input type="hidden" id="assign-user-id-original" value="">

                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" class="form-control" id="assign-display-role" value="" disabled>
                    </div>

                    <div class="form-group">
                        <label>Select User <span class="text-danger">*</span></label>
                        <select class="form-control" id="assign-user-select"
                            style="color: #333 !important; background-color: #fff !important;">
                            <option value="">-- pilih user --</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($u->id); ?>" data-firstname="<?php echo e($u->first_name); ?>"
                                    data-lastname="<?php echo e($u->last_name); ?>" data-email="<?php echo e($u->email); ?>"
                                    data-employee="<?php echo e($u->employee_num); ?>">
                                    <?php echo e($u->present()->fullName ?? ($u->name ?? $u->username)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <p class="help-block">Pilih user dari daftar atau edit info di bawah</p>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" id="assign-firstname" placeholder="First Name">
                    </div>

                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" id="assign-lastname" placeholder="Last Name">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="assign-email" placeholder="email@example.com">
                    </div>

                    <div class="form-group">
                        <label>Employee ID</label>
                        <input type="text" class="form-control" id="assign-employee" placeholder="Employee ID">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="assign-user-save">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Per-row People Edit Modal -->
    <div class="modal fade" id="personEditModal" tabindex="-1" role="dialog" aria-labelledby="personEditModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="personEditModalLabel">Edit Email & Employee ID</h4>
                </div>
                <div class="modal-body">
                    <form id="person-edit-form">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <input type="hidden" name="people_updates[_id][id]" id="person-id" value="">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="person-name" value="" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="people_updates[_id][email]"
                                id="person-email" value="">
                        </div>
                        <div class="form-group">
                            <label>Employee ID</label>
                            <input type="text" class="form-control" name="people_updates[_id][employee_num]"
                                id="person-employee" value="">
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('moar_scripts'); ?>
    <script>
        (function() {
            // Expose Users map for fallback (when signature has no user yet)
            var USERS_MAP = (function() {
                try {
                    return JSON.parse(document.getElementById('users-data').textContent);
                } catch (e) {
                    return {};
                }
            })();
            // Update a row's display cells (name/email/employee) based on selected user
            function updateRowDisplayBySigId(sigId, userId) {
                var nameEl = document.querySelector('.sig-name[data-sig-id="' + sigId + '"]');
                var emailEl = document.querySelector('.sig-email[data-sig-id="' + sigId + '"]');
                var empEl = document.querySelector('.sig-employee[data-sig-id="' + sigId + '"]');
                var user = USERS_MAP[userId] || {};
                if (nameEl) nameEl.textContent = user.name || '';
                if (emailEl) emailEl.textContent = user.email || '';
                if (empEl) empEl.textContent = user.employee_num || '';
                // Keep the row's pencil button in sync
                var btn = document.querySelector('.btn-edit-person[data-sig-id="' + sigId + '"]');
                if (btn) {
                    btn.setAttribute('data-user-id', userId || '');
                    btn.setAttribute('data-user-name', user.name || '');
                    btn.setAttribute('data-email', user.email || '');
                    btn.setAttribute('data-employee-num', user.employee_num || '');
                }
            }
            // Quick map of manager->name for selects display (optional)
            function getManagerIdOf(userId) {
                var u = USERS_MAP[userId];
                return u && u.manager_id ? String(u.manager_id) : '';
            }

            function getUserName(userId) {
                var u = USERS_MAP[userId];
                return u && u.name ? u.name : '';
            }
            // Signature roles selects
            var sigSelects = Array.prototype.slice.call(document.querySelectorAll('select.sig-select'));
            var selectsByRole = sigSelects.reduce(function(acc, el) {
                acc[el.getAttribute('data-role')] = el;
                return acc;
            }, {});
            // Any selection change should update its own display cells
            sigSelects.forEach(function(sel) {
                sel.addEventListener('change', function() {
                    var sigId = this.getAttribute('data-sig-id');
                    updateRowDisplayBySigId(sigId, this.value || '');
                });
            });
            // Helper: set select to value if option exists, and trigger change event
            function setSelectValue(sel, val) {
                if (!sel) return;
                var strVal = (val == null ? '' : String(val));
                if (!strVal) return;
                var found = false;
                for (var i = 0; i < sel.options.length; i++) {
                    if (String(sel.options[i].value) === strVal) {
                        found = true;
                        break;
                    }
                }
                if (found) {
                    sel.value = strVal;
                    var evt = document.createEvent('HTMLEvents');
                    evt.initEvent('change', true, false);
                    sel.dispatchEvent(evt);
                }
            }
            // When creator changes, auto-fill creator_manager from People (manager_id).
            if (selectsByRole['creator'] && selectsByRole['creator_manager']) {
                selectsByRole['creator'].addEventListener('change', function() {
                    var creatorId = this.value;
                    var mgrId = getManagerIdOf(creatorId);
                    if (mgrId) {
                        setSelectValue(selectsByRole['creator_manager'], mgrId);
                    }
                });
            }
            // When user (penerima) changes, auto-fill user_manager from People, and mirror Atasan Penerima text input.
            var atasanInput = document.querySelector('input[name="atasan_penerima_name"]');
            if (selectsByRole['user'] && selectsByRole['user_manager']) {
                selectsByRole['user'].addEventListener('change', function() {
                    var userId = this.value;
                    var mgrId = getManagerIdOf(userId);
                    if (mgrId) {
                        setSelectValue(selectsByRole['user_manager'], mgrId);
                    }
                    if (atasanInput) {
                        atasanInput.value = getUserName(mgrId) || atasanInput.value;
                    }
                });
            }
            // Also when user_manager explicitly changed by operator, keep Atasan Penerima in sync.
            if (selectsByRole['user_manager']) {
                selectsByRole['user_manager'].addEventListener('change', function() {
                    if (atasanInput) {
                        atasanInput.value = getUserName(this.value) || atasanInput.value;
                    }
                });
            }
            var activePersonId = null;
            var activeSigId = null;
            var activeRole = null;

            // Handle Assign User select change - auto fill user info fields
            var assignUserSelect = document.getElementById('assign-user-select');
            if (assignUserSelect) {
                assignUserSelect.addEventListener('change', function() {
                    var userId = this.value;
                    if (userId) {
                        var user = USERS_MAP[userId] || {};
                        var selectedOption = this.options[this.selectedIndex];

                        document.getElementById('assign-firstname').value = selectedOption.getAttribute(
                            'data-firstname') || '';
                        document.getElementById('assign-lastname').value = selectedOption.getAttribute(
                            'data-lastname') || '';
                        document.getElementById('assign-email').value = selectedOption.getAttribute(
                            'data-email') || '';
                        document.getElementById('assign-employee').value = selectedOption.getAttribute(
                            'data-employee') || '';
                    } else {
                        document.getElementById('assign-firstname').value = '';
                        document.getElementById('assign-lastname').value = '';
                        document.getElementById('assign-email').value = '';
                        document.getElementById('assign-employee').value = '';
                    }
                });
            }

            // Handle Assign User button click
            document.addEventListener('click', function(e) {
                var btnAssign = e.target.closest && e.target.closest('.btn-assign-user');
                if (btnAssign) {
                    activeSigId = btnAssign.getAttribute('data-sig-id');
                    activeRole = btnAssign.getAttribute('data-role');
                    var displayRole = btnAssign.getAttribute('data-display-role');
                    var userId = btnAssign.getAttribute('data-user-id');
                    var userName = btnAssign.getAttribute('data-user-name') || '';
                    var email = btnAssign.getAttribute('data-email') || '';
                    var employeeNum = btnAssign.getAttribute('data-employee-num') || '';
                    var allowChangeUser = btnAssign.getAttribute('data-allow-change-user') === '1';

                    // Fill modal
                    document.getElementById('assign-sig-id').value = activeSigId;
                    document.getElementById('assign-role').value = activeRole;
                    document.getElementById('assign-display-role').value = displayRole;
                    document.getElementById('assign-user-select').value = userId || '';
                    document.getElementById('assign-user-id-original').value = userId || '';

                    // Disable user select for role 'user' (penerima)
                    var userSelect = document.getElementById('assign-user-select');
                    if (!allowChangeUser) {
                        userSelect.disabled = true;
                        userSelect.style.backgroundColor = '#f5f5f5';
                        userSelect.style.cursor = 'not-allowed';
                        // Update modal title
                        document.getElementById('assignUserModalLabel').textContent = 'Edit User Info';
                        // Update help text
                        var helpText = userSelect.nextElementSibling;
                        if (helpText && helpText.classList.contains('help-block')) {
                            helpText.textContent =
                                'User tidak dapat diganti untuk role Penerima. Anda hanya bisa edit informasi user.';
                            helpText.style.color = '#d9534f';
                        }
                    } else {
                        userSelect.disabled = false;
                        userSelect.style.backgroundColor = '#fff';
                        userSelect.style.cursor = 'pointer';
                        // Reset modal title
                        document.getElementById('assignUserModalLabel').textContent = 'Edit User & Info';
                        // Reset help text
                        var helpText = userSelect.nextElementSibling;
                        if (helpText && helpText.classList.contains('help-block')) {
                            helpText.textContent = 'Pilih user dari daftar atau edit info di bawah';
                            helpText.style.color = '#737373';
                        }
                    }

                    // Split name to first and last
                    var nameParts = userName.split(' ');
                    var firstName = nameParts[0] || '';
                    var lastName = nameParts.slice(1).join(' ') || '';

                    document.getElementById('assign-firstname').value = firstName;
                    document.getElementById('assign-lastname').value = lastName;
                    document.getElementById('assign-email').value = email;
                    document.getElementById('assign-employee').value = employeeNum;

                    $('#assignUserModal').modal('show');
                }
            });

            // Handle Assign User save
            var assignSaveBtn = document.getElementById('assign-user-save');
            if (assignSaveBtn) {
                assignSaveBtn.addEventListener('click', function() {
                    var sigId = activeSigId;
                    var userId = document.getElementById('assign-user-select').value;
                    var firstName = document.getElementById('assign-firstname').value.trim();
                    var lastName = document.getElementById('assign-lastname').value.trim();
                    var email = document.getElementById('assign-email').value.trim();
                    var employeeNum = document.getElementById('assign-employee').value.trim();

                    if (!userId) {
                        alert('Pilih user terlebih dahulu.');
                        return;
                    }

                    // Prepare data for server update
                    var fd = new FormData();
                    fd.append('_token', '<?php echo e(csrf_token()); ?>');
                    fd.append('signature_users[' + sigId + ']', userId);

                    // Add people updates if fields are filled
                    if (firstName || lastName || email || employeeNum) {
                        fd.append('people_updates[' + userId + '][id]', userId);
                        if (firstName) fd.append('people_updates[' + userId + '][first_name]', firstName);
                        if (lastName) fd.append('people_updates[' + userId + '][last_name]', lastName);
                        if (email) fd.append('people_updates[' + userId + '][email]', email);
                        if (employeeNum) fd.append('people_updates[' + userId + '][employee_num]', employeeNum);
                    }

                    // Show loading
                    assignSaveBtn.disabled = true;
                    assignSaveBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';

                    // Send to server
                    fetch("<?php echo e(route('documents.updateSignaturePeople', $document)); ?>", {
                            method: 'POST',
                            body: fd
                        })
                        .then(async r => {
                            if (!r.ok) {
                                let m = 'Gagal simpan';
                                try {
                                    const j = await r.json();
                                    if (j.message) m = j.message;
                                } catch (_) {}
                                throw new Error(m);
                            }
                            return r.text();
                        })
                        .then(function() {
                            // Create hidden input for form submission (backup)
                            var inputName = 'signature_users[' + sigId + ']';
                            var existingInput = document.querySelector('input[name="' + inputName + '"]');
                            if (!existingInput) {
                                var input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = inputName;
                                input.value = userId;
                                document.querySelector('form').appendChild(input);
                            } else {
                                existingInput.value = userId;
                            }

                            // Update USERS_MAP with new info
                            if (USERS_MAP[userId]) {
                                var fullName = (firstName + ' ' + lastName).trim();
                                if (fullName) USERS_MAP[userId].name = fullName;
                                if (email) USERS_MAP[userId].email = email;
                                if (employeeNum) USERS_MAP[userId].employee_num = employeeNum;
                            }

                            // Update display with new info
                            var nameEl = document.querySelector('.sig-name[data-sig-id="' + sigId + '"]');
                            var emailEl = document.querySelector('.sig-email[data-sig-id="' + sigId + '"]');
                            var empEl = document.querySelector('.sig-employee[data-sig-id="' + sigId +
                                '"]');

                            if (nameEl && (firstName || lastName)) {
                                nameEl.textContent = (firstName + ' ' + lastName).trim();
                            }
                            if (emailEl && email) emailEl.textContent = email;
                            if (empEl && employeeNum) empEl.textContent = employeeNum;

                            // Update button data attributes
                            var btn = document.querySelector('.btn-assign-user[data-sig-id="' + sigId +
                                '"]');
                            if (btn) {
                                if (firstName || lastName) btn.setAttribute('data-user-name', (firstName +
                                    ' ' + lastName).trim());
                                if (email) btn.setAttribute('data-email', email);
                                if (employeeNum) btn.setAttribute('data-employee-num', employeeNum);
                            }

                            // Auto-fill manager if needed
                            if (activeRole === 'creator') {
                                var mgrId = getManagerIdOf(userId);
                                if (mgrId && selectsByRole['creator_manager']) {
                                    setSelectValue(selectsByRole['creator_manager'], mgrId);
                                }
                            } else if (activeRole === 'user') {
                                var mgrId = getManagerIdOf(userId);
                                if (mgrId && selectsByRole['user_manager']) {
                                    setSelectValue(selectsByRole['user_manager'], mgrId);
                                }
                                if (atasanInput) {
                                    atasanInput.value = getUserName(mgrId) || atasanInput.value;
                                }
                            }

                            $('#assignUserModal').modal('hide');

                            // Show success message
                            alert('User info berhasil disimpan!');

                            // Reload page to refresh data
                            location.reload();
                        })
                        .catch(function(err) {
                            alert(err.message || 'Error');
                        })
                        .finally(function() {
                            assignSaveBtn.disabled = false;
                            assignSaveBtn.innerHTML = 'Save';
                        });
                });
            }

            var btn = document.getElementById('btn-regen-number');
            if (btn) {
                btn.addEventListener('click', function() {
                    var orig = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                    fetch("<?php echo e(route('documents.regenNumber', $document)); ?>", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json'
                            }
                        })
                        .then(async r => {
                            if (!r.ok) {
                                let m = 'Gagal generate';
                                try {
                                    const j = await r.json();
                                    if (j.message) m = j.message;
                                } catch (_) {}
                                throw new Error(m);
                            }
                            return r.json();
                        })
                        .then(function(data) {
                            var input = btn.closest('.input-group').querySelector('input.form-control');
                            if (input && data.document_number) {
                                input.value = data.document_number;
                            }
                            var docNo = document.querySelector('input[name=\"document_no\"]');
                            if (docNo && data.document_no) {
                                docNo.value = data.document_no;
                            }
                        })
                        .catch(function(err) {
                            alert(err.message || 'Error');
                        })
                        .finally(function() {
                            btn.disabled = false;
                            btn.innerHTML = orig;
                        });
                });
            }
            // Open per-row modal to edit People
            document.addEventListener('click', function(e) {
                var btnEdit = e.target.closest && e.target.closest('.btn-edit-person');
                if (btnEdit) {
                    var id = btnEdit.getAttribute('data-user-id');
                    var name = btnEdit.getAttribute('data-user-name') || '';
                    var email = btnEdit.getAttribute('data-email') || '';
                    var emp = btnEdit.getAttribute('data-employee-num') || '';

                    // If no user on signature, use the selected value from the sibling select
                    if (!id) {
                        var group = btnEdit.closest('.input-group');
                        var sel = group ? group.querySelector('select') : null;
                        var selId = sel && sel.value ? sel.value : '';
                        if (selId) {
                            id = selId;
                            var u = USERS_MAP[selId] || {};
                            name = u.name || (sel ? (sel.options[sel.selectedIndex] ? sel.options[sel
                                .selectedIndex].text : '') : '');
                            email = u.email || '';
                            emp = u.employee_num || '';
                        }
                    }

                    if (!id) {
                        return alert('Pilih user dulu pada kolom Assign User.');
                    }

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
            if (personSave) {
                personSave.addEventListener('click', function() {
                    var id = activePersonId;
                    if (!id) {
                        return alert('User belum dipilih.');
                    }
                    var fd = new FormData();
                    fd.append('_token', '<?php echo e(csrf_token()); ?>');
                    fd.append('people_updates[' + id + '][id]', id);
                    fd.append('people_updates[' + id + '][email]', document.getElementById('person-email')
                        .value || '');
                    fd.append('people_updates[' + id + '][employee_num]', document.getElementById(
                        'person-employee').value || '');
                    fetch("<?php echo e(route('documents.updateSignaturePeople', $document)); ?>", {
                            method: 'POST',
                            body: fd
                        })
                        .then(async r => {
                            if (!r.ok) {
                                let m = 'Gagal simpan';
                                try {
                                    const j = await r.json();
                                    if (j.message) m = j.message;
                                } catch (_) {}
                                throw new Error(m);
                            }
                            return r.text();
                        })
                        .then(function() {
                            location.reload();
                        })
                        .catch(function(err) {
                            alert(err.message || 'Error');
                        });
                });
            }
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/documents/asset/edit.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(trans('general.import')); ?>

    <?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>

<div>
    
    <div class="row">

        
        <!--[if BLOCK]><![endif]--><?php if($message != ''): ?>
            <div class="col-md-12" class="<?php echo e($message_type); ?>">
                <div class="alert alert-<?php echo e($this->message_type); ?>">
                    <button type="button" class="close" wire:click="$set('message','')">&times;</button>
                    <!--[if BLOCK]><![endif]--><?php if($message_type == 'success'): ?>
                        <i class="fas fa-check faa-pulse animated" aria-hidden="true"></i>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <strong> </strong>
                    <?php echo e($message); ?>

                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if($import_errors): ?>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="alert alert-warning">

                            <i class="fa fa-warning info" aria-hidden="true"></i>
                            <strong><?php echo e(trans('general.warning', ['warning' => trans('general.errors_importing')])); ?></strong>
                        </div>

                        <div class="errors-table">
                            <table class="table table-striped table-bordered" id="errors-table">
                                <thead>
                                    <th><?php echo e(trans('general.item')); ?></th>
                                    <th><?php echo e(trans('admin/custom_fields/general.field')); ?></th>
                                    <th><?php echo e(trans('general.error')); ?></th>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $import_errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $actual_import_errors): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $actual_import_errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table => $error_bag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $error_bag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $error_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><b><?php echo e($key); ?></b></td>
                                                    <td><b><?php echo e($field); ?></b></td>
                                                    <td>
                                                        <span><?php echo e(implode(', ', $error_list)); ?></span>
                                                        <br />
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <div class="col-md-9">
            <div class="box">
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-12">

                            <!--[if BLOCK]><![endif]--><?php if($progress != -1): ?>
                                <div class="col-md-10 col-sm-5 col-xs-12" style="height: 35px;" id='progress-container'>
                                    <div class="progress progress-striped-active" style="height: 100%;">
                                        <div id='progress-bar' class="progress-bar <?php echo e($progress_bar_class); ?>"
                                            role="progressbar" style="width: <?php echo e($progress); ?>%">
                                            <h4 id="progress-text"><?php echo $progress_message; ?></h4>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <div class="col-md-4 col-sm-5 col-xs-12 text-right pull-right">

                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <!--[if BLOCK]><![endif]--><?php if(!config('app.lock_passwords')): ?>
                                    <label for="fileupload" class="btn btn-primary"
                                        style="margin-bottom: 0; cursor: pointer;">
                                        <i class="fa fa-upload"></i> <span><?php echo e(trans('button.select_file')); ?></span>
                                    </label>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input id="fileupload" type="file" name="files[]"
                                        data-url="<?php echo e(route('api.imports.index')); ?>" accept="text/csv"
                                        aria-label="files[]" style="display: none;">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive" style="padding-top: 30px;">
                            <table data-id-table="upload-table" data-side-pagination="client" id="upload-table"
                                class="col-md-12 table table-striped snipe-table">

                                <tr>
                                    <th>
                                        <?php echo e(trans('general.file_name')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('general.created_at')); ?>

                                    </th>
                                    <th>
                                        <?php echo e(trans('general.created_by')); ?>

                                    </th>

                                    <th>
                                        <?php echo e(trans('general.filesize')); ?>

                                    </th>
                                    <th class="col-md-1 text-right">
                                        <span class="sr-only"><?php echo e(trans('general.actions')); ?></span>
                                    </th>
                                </tr>

                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currentFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr style="<?php echo e($this->activeFile && $currentFile->id == $this->activeFile->id ? 'font-weight: bold' : ''); ?>"
                                        class="<?php echo e($this->activeFile && $currentFile->id == $this->activeFile->id ? 'warning' : ''); ?>">
                                        <td><?php echo e($currentFile->file_path); ?></td>
                                        <td><?php echo e(Helper::getFormattedDateObject($currentFile->created_at, 'datetime', false)); ?>

                                        </td>
                                        <td><?php echo e($currentFile->adminuser ? $currentFile->adminuser->present()->fullName : '--'); ?>

                                        </td>
                                        <td><?php echo e(Helper::formatFilesizeUnits($currentFile->filesize)); ?></td>
                                        <td class="col-md-1 text-right" style="white-space: nowrap;">
                                            <button class="btn btn-sm btn-info"
                                                wire:click="selectFile(<?php echo e($currentFile->id); ?>)" data-tooltip="true"
                                                title="<?php echo e(trans('general.import_this_file')); ?>">
                                                <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                                <span class="sr-only"><?php echo e(trans('general.import')); ?></span>
                                            </button>
                                            <a href="#" wire:click.prevent="$set('activeFileId',null)">
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="destroy(<?php echo e($currentFile->id); ?>)">
                                                    <i class="fas fa-trash icon-white" aria-hidden="true"></i>
                                                    <span class="sr-only"><?php echo e(trans('general.delete')); ?></span>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>

                                    <!--[if BLOCK]><![endif]--><?php if($currentFile && $this->activeFile && $currentFile->id == $this->activeFile->id): ?>
                                        <tr class="warning">
                                            <td colspan="5">

                                                <div class="form-group">

                                                    <label for="typeOfImport" class="col-md-3 col-xs-12">
                                                        <?php echo e(trans('general.import_type')); ?>

                                                    </label>

                                                    <div class="col-md-9 col-xs-12">
                                                        <?php if (isset($component)) { $__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::input.select','data' => ['name' => 'typeOfImport','id' => 'import_type','options' => $importTypes,'selected' => $typeOfImport,'forLivewire' => true,'includeEmpty' => true,'dataPlaceholder' => trans('general.select_var', [
                                                                'thing' => trans('general.import_type'),
                                                            ]),'placeholder' => '','dataMinimumResultsForSearch' => '-1','style' => 'min-width: 350px;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'typeOfImport','id' => 'import_type','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($importTypes),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($typeOfImport),'for-livewire' => true,'include-empty' => true,'data-placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('general.select_var', [
                                                                'thing' => trans('general.import_type'),
                                                            ])),'placeholder' => '','data-minimum-results-for-search' => '-1','style' => 'min-width: 350px;']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d)): ?>
<?php $attributes = $__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d; ?>
<?php unset($__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d)): ?>
<?php $component = $__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d; ?>
<?php unset($__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d); ?>
<?php endif; ?>
                                                        <!--[if BLOCK]><![endif]--><?php if($typeOfImport === 'asset' && $snipeSettings->auto_increment_assets == 0): ?>
                                                            <p class="help-block">
                                                                <?php echo e(trans('general.auto_incrementing_asset_tags_disabled_so_tags_required')); ?>

                                                            </p>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-9 col-md-offset-3">
                                                    <label class="form-control">
                                                        <input type="checkbox" name="update"
                                                            data-livewire-component="<?php echo e($this->getId()); ?>"
                                                            wire:model.live="update">
                                                        <?php echo e(trans('general.update_existing_values')); ?>

                                                    </label>

                                                    <!--[if BLOCK]><![endif]--><?php if($typeOfImport === 'asset' && $snipeSettings->auto_increment_assets == 1 && $update): ?>
                                                        <p class="help-block">
                                                            <?php echo e(trans('general.auto_incrementing_asset_tags_enabled_so_now_assets_will_be_created')); ?>

                                                        </p>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                                                    <!--[if BLOCK]><![endif]--><?php if($typeOfImport === 'user'): ?>
                                                        <label class="form-control">
                                                            <input type="checkbox" name="send_welcome"
                                                                data-livewire-component="<?php echo e($this->getId()); ?>"
                                                                wire:model.live="send_welcome">
                                                            <?php echo e(trans('general.send_welcome_email_to_users')); ?>

                                                        </label>
                                                        <p class="help-block">
                                                            <?php echo e(trans('general.send_welcome_email_import_help')); ?></p>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                    <label class="form-control">
                                                        <input type="checkbox" name="run_backup"
                                                            data-livewire-component="<?php echo e($this->getId()); ?>"
                                                            wire:model.live="run_backup">
                                                        <?php echo e(trans('general.back_before_importing')); ?>

                                                    </label>

                                                </div>


                                                <!--[if BLOCK]><![endif]--><?php if($statusText): ?>
                                                    <div class="alert col-md-8 col-md-offset-3<?php echo e($statusType == 'success' ? ' alert-success' : ($statusType == 'error' ? ' alert-danger' : ' alert-info')); ?>"
                                                        style="padding-top: 20px;">
                                                        <?php echo $statusText; ?>

                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                                                <!--[if BLOCK]><![endif]--><?php if($typeOfImport): ?>
                                                    <div class="form-group col-md-12">
                                                        <hr style="border-top: 1px solid lightgray">
                                                        <h3>
                                                            <i class="<?php echo e(Helper::iconTypeByItem($typeOfImport)); ?>">
                                                            </i>
                                                            <?php echo e(trans('general.map_fields', ['item_type' => ucwords($typeOfImport)])); ?>

                                                        </h3>
                                                        <hr style="border-top: 1px solid lightgray">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <div class="col-md-3 text-right">
                                                            <strong><?php echo e(trans('general.csv_header_field')); ?></strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <strong><?php echo e(trans('general.import_field')); ?></strong>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <strong><?php echo e(trans('general.sample_value')); ?></strong>
                                                        </div>
                                                    </div><!-- /div row -->

                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($headerRow)): ?>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $headerRow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="form-group col-md-12"
                                                                wire:key="header-row-<?php echo e($index); ?>">

                                                                <label for="field_map.<?php echo e($index); ?>"
                                                                    class="col-md-3 control-label text-right"><?php echo e($header); ?></label>
                                                                <div class="col-md-4">
                                                                    <?php if (isset($component)) { $__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::input.select','data' => ['name' => 'field_map.' . $index,'forLivewire' => true,'placeholder' => trans(
                                                                            'general.importer.do_not_import',
                                                                        ),'class' => 'mappings','style' => 'min-width: 100%;']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('field_map.' . $index),'for-livewire' => true,'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans(
                                                                            'general.importer.do_not_import',
                                                                        )),'class' => 'mappings','style' => 'min-width: 100%;']); ?>
                                                                        <option selected="selected" value="">Do
                                                                            Not Import</option>
                                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $columnOptions[$typeOfImport]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($key); ?>"
                                                                                <?php if(@$field_map[$index] === $key): echo 'selected'; endif; ?>
                                                                                <?php if($key === '-'): echo 'disabled'; endif; ?>>
                                                                                <?php echo e($value); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d)): ?>
<?php $attributes = $__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d; ?>
<?php unset($__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d)): ?>
<?php $component = $__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d; ?>
<?php unset($__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d); ?>
<?php endif; ?>
                                                                </div>
                                                                <!--[if BLOCK]><![endif]--><?php if($this->activeFile->first_row && array_key_exists($index, $this->activeFile->first_row)): ?>
                                                                    <div class="col-md-5">
                                                                        <p class="form-control-static">
                                                                            <?php echo e(str_limit($this->activeFile->first_row[$index], 50, '...')); ?>

                                                                        </p>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <?php
                                                                        $statusText = trans('help.empty_file');
                                                                        $statusType = 'info';
                                                                    ?>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </div><!-- /div row -->
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php else: ?>
                                                        <?php echo e(trans('general.no_headers')); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                    <div class="form-group col-md-12">
                                                        <div class="col-md-3 text-left">
                                                            <a href="#"
                                                                wire:click.prevent="$set('activeFileId',null)"><?php echo e(trans('general.cancel')); ?></a>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <button type="submit" class="btn btn-primary col-md-5"
                                                                id="import"><?php echo e(trans('admin/hardware/message.import.import_button')); ?></button>
                                                            <br><br>
                                                        </div>
                                                    </div>

                                                    <!--[if BLOCK]><![endif]--><?php if($statusText): ?>
                                                        <div class="alert col-md-8 col-md-offset-3<?php echo e($statusType == 'success' ? ' alert-success' : ($statusType == 'error' ? ' alert-danger' : ' alert-info')); ?>"
                                                            style="padding-top: 20px;">
                                                            <?php echo $statusText; ?>

                                                        </div>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php else: ?>
                                                    <div class="form-group col-md-10">
                                                        <div class="col-md-3 text-left">
                                                            <a href="#"
                                                                wire:click.prevent="$set('activeFileId',null)"><?php echo e(trans('general.cancel')); ?></a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]--> 

                        </div><!-- /div v-show --> </td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <h2><?php echo e(trans('general.importing')); ?></h2>
        <p><?php echo trans('general.importing_help'); ?></p>
    </div>

</div>
</div>
    <?php
        $__scriptKey = '1269372270-0';
        ob_start();
    ?>
    <script>
        

            // Inisialisasi sederhana untuk file upload
            (function() {
                if (typeof $.fn.fileupload !== 'undefined') {
                    $('#fileupload').fileupload({
                        dataType: 'json',
                        done: function(e, data) {
                            $wire.$set('progress_bar_class', 'progress-bar-success');
                            $wire.$set('progress_message',
                                '<i class="fas fa-check faa-pulse animated"></i> <?php echo e(trans('general.notification_success')); ?>'
                            );
                            $wire.$set('progress', 100);
                        },
                        add: function(e, data) {
                            data.headers = {
                                "X-Requested-With": 'XMLHttpRequest',
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                            };
                            data.process().done(function() {
                                data.submit();
                            });
                            $wire.$set('progress', 0);
                            $wire.clearMessage();
                        },
                        progress: function(e, data) {
                            $wire.$set('progress', parseInt((data.loaded / data.total * 100, 10)));
                            $wire.$set('progress_message', '<?php echo e(trans('general.uploading')); ?>');
                        },
                        fail: function() {
                            $wire.$set('progress_bar_class', "progress-bar-danger");
                            $wire.$set('progress', 100);
                            $wire.$set('progress_message',
                                '<i class="fas fa-exclamation-triangle faa-pulse animated"></i> <?php echo e(trans('general.upload_error')); ?>'
                            );
                        }
                    });
                }
            })();

        // For the importFile part:
        $(function() {


            // we have to hook up to the `<tr id='importer-file'>` at the root of this display,
            // because the #import button isn't visible until you click an import_type
            $('#upload-table').on('click', '#import', function() {
                if (!$wire.$get('typeOfImport')) {
                    $wire.$set('statusType', 'error');
                    $wire.$set('statusText', "An import type is required... "); //TODO: translate?
                    return;
                }
                $wire.$set('statusType', 'pending');
                $wire.$set('statusText',
                    '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> <?php echo e(trans('admin/hardware/form.processing_spinner')); ?>'
                );
                $wire.generate_field_map().then(function(mappings_raw) {
                    var mappings = JSON.parse(mappings_raw)
                    // console.warn("Here is the mappings:")
                    // console.dir(mappings)
                    // console.warn("Uh, active file id is, I guess: "+$wire.$get('activeFile.id'))
                    var file_id = $wire.$get('activeFileId');
                    $.post({
                        
                        url: "api/v1/imports/process/" +
                            file_id, // maybe? Good a guess as any..FIXME. HARDCODED DUMB FILE
                        contentType: 'application/json',
                        data: JSON.stringify({
                            'import-update': !!$wire.$get('update'),
                            'send-welcome': !!$wire.$get('send_welcome'),
                            'import-type': $wire.$get('typeOfImport'),
                            'run-backup': !!$wire.$get('run_backup'),
                            'column-mappings': mappings
                        }),
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        }
                    }).done(function(body) {
                        // Success
                        $wire.$set('statusType', "success");
                        $wire.$set('statusText',
                            "<?php echo e(trans('general.success_redirecting')); ?>");
                        // console.dir(body)
                        window.location.href = body.messages.redirect_url;
                    }).fail(function(jqXHR, textStatus, error) {
                        // Failure
                        var body = jqXHR.responseJSON
                        if ((body) && (body.status) && body.status == 'import-errors') {
                            $wire.$dispatch('importError', body.messages);
                            $wire.$set('import_errors', body.messages);

                            $wire.$set('statusType', 'error');
                            $wire.$set('statusText', "Error");

                            //  If Slack/notifications hits API thresholds, we *do* 500, but we never
                            //  actually surface that info.
                            //
                            // A 500 on notifications doesn't mean your import failed, so this is a confusing state.
                            //
                            //  Ideally we'd have a message like "Your import worked, but not all
                            // notifications could be sent".
                        } else {
                            console.warn(
                                "Not import-errors, just regular errors - maybe API limits"
                            )
                            $wire.$set('message_type', "warning");
                            if ((body) && (error in body)) {
                                $wire.$set('message', body.error ? body.error :
                                    "Unknown error - might just be throttling by notifications."
                                );
                            } else {
                                $wire.$set('message',
                                    "<?php echo e(trans('general.importer_generic_error')); ?>");
                            }

                        }
                        $wire.$set('activeFileId', null); //$wire.$set('hideDetails')
                    });
                })
                return false;
            });
        })
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/livewire/importer.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(trans('general.audit')); ?>

    <?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <style>

        .input-group {
            padding-left: 0px !important;
        }
    </style>

    <div class="row">
        <!-- left column -->
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-default">

                <form method="POST" action="<?php echo e(route('asset.audit.store', $asset)); ?>" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">

                    <div class="box-header with-border">
                        <h2 class="box-title"> <?php echo e(trans('admin/hardware/form.tag')); ?> <?php echo e($asset->asset_tag); ?></h2>
                    </div>
                    <div class="box-body">
                    <?php echo e(csrf_field()); ?>


                        <!-- Asset model -->
                            <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                                <label class="col-sm-3 control-label">
                                    <?php echo e(trans('admin/hardware/form.model')); ?>

                                </label>
                                <div class="col-md-8">
                                    <p class="form-control-static">
                                        <?php if(($asset->model) && ($asset->model->name)): ?>
                                            <?php echo e($asset->model->name); ?>

                                        <?php else: ?>
                                            <span class="text-danger text-bold">
                                              <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                                              <?php echo e(trans('admin/hardware/general.model_invalid')); ?>

                                            </span>
                                            <?php echo e(trans('admin/hardware/general.model_invalid_fix')); ?>

                                            <a href="<?php echo e(route('hardware.edit', $asset->id)); ?>">
                                                <strong><?php echo e(trans('admin/hardware/general.edit')); ?></strong>
                                            </a>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>


                    <!-- Asset Name -->

                        <?php if($asset->name): ?>
                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-sm-3 control-label">
                                <?php echo e(trans('general.name')); ?>

                            </label>
                            <div class="col-md-8">
                                <p class="form-control-static"><?php echo e($asset->name); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Locations -->
                    <?php echo $__env->make('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                    <!-- Update location -->
                        <div class="form-group">

                            <div class="col-md-8 col-md-offset-3">
                                <label class="form-control">
                                    <input type="checkbox" value="1" name="update_location" <?php echo e(old('update_location') == '1' ? ' checked="checked"' : ''); ?>> <?php echo e(trans('admin/hardware/form.asset_location')); ?>

                                </label>
                                <p class="help-block"><?php echo trans('help.audit_help'); ?></p>
                            </div>

                        </div>


                        <!-- Show last audit date -->
                        <div class="form-group">
                            <label class="control-label col-md-3">
                                <?php echo e(trans('general.last_audit')); ?>

                            </label>
                            <div class="col-md-8">

                                <p class="form-control-static">
                                    <?php if($asset->last_audit_date): ?>
                                        <?php echo e(Helper::getFormattedDateObject($asset->last_audit_date, 'datetime', false)); ?>

                                    <?php else: ?>
                                        <?php echo e(trans('admin/settings/general.none')); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>


                        <!-- Next Audit -->
                        <div class="form-group<?php echo e($errors->has('next_audit_date') ? ' has-error' : ''); ?>">
                            <label for="next_audit_date" class="col-sm-3 control-label">
                                <?php echo e(trans('general.next_audit_date')); ?>

                            </label>
                            <div class="col-md-8">
                                <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-clear-btn="true">
                                    <input type="text" class="form-control" placeholder="<?php echo e(trans('general.next_audit_date')); ?>" name="next_audit_date" id="next_audit_date" value="<?php echo e(old('next_audit_date', $next_audit_date)); ?>">
                                    <span class="input-group-addon"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'calendar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'calendar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></span>
                                </div>
                                <?php echo $errors->first('next_audit_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

                                 <p class="help-block"><?php echo trans('general.next_audit_date_help'); ?></p>
                            </div>
                        </div>


                        <!-- Note -->
                        <div class="form-group<?php echo e($errors->has('note') ? ' has-error' : ''); ?>">
                            <label for="note" class="col-sm-3 control-label">
                                <?php echo e(trans('general.notes')); ?>

                            </label>
                            <div class="col-md-8">
                                <textarea class="col-md-6 form-control" id="note" name="note"><?php echo e(old('note', $asset->note)); ?></textarea>
                                <?php echo $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

                            </div>
                        </div>

                        <!-- Audit Image -->
                        <?php echo $__env->make('partials.forms.edit.image-upload', ['help_text' => trans('general.audit_images_help')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <!-- Custom fields -->
                        <?php echo $__env->make("models/custom_fields_form", [
                                'model' => $asset->model,
                                'show_custom_fields_type' => 'audit'
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


                    </div> <!--/.box-body-->

                    <?php if (isset($component)) { $__componentOriginal897bfaf5cfb025541cae5f511fed1c5f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal897bfaf5cfb025541cae5f511fed1c5f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::redirect_submit_options','data' => ['indexRoute' => 'hardware.index','buttonLabel' => trans('general.audit'),'disabledSelect' => !$asset->model,'options' => [
                                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => trans('general.assets')]),
                                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.asset')]),
                                'other_redirect' => trans('general.audit_due')
                               ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('redirect_submit_options'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['index_route' => 'hardware.index','button_label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('general.audit')),'disabled_select' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(!$asset->model),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => trans('general.assets')]),
                                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.asset')]),
                                'other_redirect' => trans('general.audit_due')
                               ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal897bfaf5cfb025541cae5f511fed1c5f)): ?>
<?php $attributes = $__attributesOriginal897bfaf5cfb025541cae5f511fed1c5f; ?>
<?php unset($__attributesOriginal897bfaf5cfb025541cae5f511fed1c5f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal897bfaf5cfb025541cae5f511fed1c5f)): ?>
<?php $component = $__componentOriginal897bfaf5cfb025541cae5f511fed1c5f; ?>
<?php unset($__componentOriginal897bfaf5cfb025541cae5f511fed1c5f); ?>
<?php endif; ?>

                </form>
            </div>
        </div> <!--/.col-md-7-->
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/hardware/audit.blade.php ENDPATH**/ ?>
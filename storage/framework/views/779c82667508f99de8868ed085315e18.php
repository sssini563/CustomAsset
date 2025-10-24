<!-- Image stuff - kept in /resources/views/partials/forms/edit/image-upload.blade.php -->
<?php if(isset($image_path)): ?>
    <?php if(isset($item) && ($item->{($fieldname ?? 'image')})): ?>
        <div class="form-group<?php echo e($errors->has('image_delete') ? ' has-error' : ''); ?>">
            <div class="col-md-9 col-md-offset-3">

                <?php if((isset($cloned_model)) && ($cloned_model->image!='')): ?>
                    <!-- We are cloning a model. Use the cloned image if the user has checked that box -->
                    <input type="hidden" name="clone_image_from_id" value="<?php echo e($cloned_model->id); ?>" />
                    <label class="form-control">
                        <input type="checkbox" name="use_cloned_image" value="1" <?php if(old('use_cloned_image')): echo 'checked'; endif; ?> aria-label="use_cloned_image" id="use_cloned_image">
                        <?php echo e(trans('general.use_cloned_image')); ?>

                    </label>
                    <p class="help-block">
                        <?php echo e(trans('general.use_cloned_image_help')); ?>

                    </p>

                    <?php echo $errors->first('use_cloned_image', '<span class="alert-msg">:message</span>'); ?>

                <?php else: ?>
                    <!-- Image Delete -->
                    <label class="form-control">
                        <input type="checkbox" name="image_delete" value="1" <?php if(old('image_delete')): echo 'checked'; endif; ?> aria-label="image_delete" id="image_delete">
                        <?php echo e(trans('general.image_delete')); ?>

                        <?php echo $errors->first('image_delete', '<span class="alert-msg">:message</span>'); ?>

                    </label>
                <?php endif; ?>

            </div>
    </div>

    <!-- existing image -->
    <div class="form-group" id="existing-image">
        <div class="col-md-8 col-md-offset-3">
            <img src="<?php echo e(Storage::disk('public')->url($image_path.e($item->{($fieldname ?? 'image')}))); ?>" class="img-responsive">
            <?php echo $errors->first('image_delete', '<span class="alert-msg">:message</span>'); ?>

        </div>
    </div>
   <?php elseif(isset($item) && (isset($item->model)) && ($item->model->image != '')): ?>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-3">
                <p class="help-block">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'info-circle','class' => 'text-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info-circle','class' => 'text-primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?> <?php echo e(trans('general.use_cloned_no_image_help')); ?>

                </p>
            </div>
        </div>
   <?php endif; ?>
<?php endif; ?>
<!-- Image Upload and preview -->

<div class="form-group <?php echo e($errors->has((isset($fieldname) ? $fieldname : 'image')) ? 'has-error' : ''); ?>" id="image-upload">
    <label class="col-md-3 control-label" for="<?php echo e((isset($fieldname) ? $fieldname : 'image')); ?>"><?php echo e(trans('general.image_upload')); ?></label>
    <div class="col-md-8">

        <input type="file" id="<?php echo e((isset($fieldname) ? $fieldname : 'image')); ?>" name="<?php echo e((isset($fieldname) ? $fieldname : 'image')); ?>" aria-label="<?php echo e((isset($fieldname) ? $fieldname : 'image')); ?>" class="sr-only">

        <label class="btn btn-default" aria-hidden="true">
            <?php echo e(trans('button.select_file')); ?>

            <input type="file" name="<?php echo e((isset($fieldname) ? $fieldname : 'image')); ?>" class="js-uploadFile" id="uploadFile" data-maxsize="<?php echo e(Helper::file_upload_max_size()); ?>" accept="image/gif,image/jpeg,image/webp,image/png,image/svg,image/svg+xml,image/avif" style="display:none; max-width: 90%" aria-label="<?php echo e((isset($fieldname) ? $fieldname : 'image')); ?>" aria-hidden="true">
        </label>

        <span class='label label-default' id="uploadFile-info"></span>

        <p class="help-block" id="uploadFile-status"><?php echo e(trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()])); ?> <?php echo e($help_text ?? ''); ?></p>

        <?php echo $errors->first('image', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

    </div>
<div class="col-md-4 col-md-offset-3" aria-hidden="true">
    <img id="uploadFile-imagePreview" style="max-width: 300px; display: none;" alt="<?php echo e(trans('general.alt_uploaded_image_thumbnail')); ?>">
</div>
</div>

<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/image-upload.blade.php ENDPATH**/ ?>
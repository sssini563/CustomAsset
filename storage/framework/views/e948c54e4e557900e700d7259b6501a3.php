<!-- Serial -->
<div class="form-group <?php echo e($errors->has('serial') ? ' has-error' : ''); ?>">
    <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e(trans('admin/hardware/form.serial')); ?> </label>
    <div class="col-md-7 col-sm-12">
        <input class="form-control" type="text" name="<?php echo e($fieldname); ?>" id="<?php echo e($fieldname); ?>" value="<?php echo e(old((isset($old_val_name) ? $old_val_name : $fieldname), $item->serial)); ?>" <?php echo e((Helper::checkIfRequired($item, 'serial') || ($item->model && $item->model->require_serial)) ? ' required' : ''); ?> maxlength="191" />
        <?php $__errorArgs = [$old_val_name ?? $fieldname];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="alert-msg" aria-hidden="true">
                <i class="fas fa-times" aria-hidden="true"></i> <?php echo e($message); ?>

            </span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/serial.blade.php ENDPATH**/ ?>
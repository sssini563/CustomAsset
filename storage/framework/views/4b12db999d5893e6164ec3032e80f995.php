<!-- partials/forms/edit/name-first.blade.php -->
<?php
    $class = $class ?? 'col-md-6';
    $style = $style ?? '';
    $required = $required ?? '';
    $value = $value ?? $user->first_name;
?>
<div class="form-group <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
    <label class="col-md-3 control-label" for="first_name"><?php echo e(trans('general.first_name')); ?></label>
    <div class="<?php echo e($class ? $class : 'col-md-6'); ?>" style= "<?php echo e($style); ?>">
        <input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo e(old('first_name', ($value ?? $user->first_name))); ?>" <?php echo e($required ? 'required' : ''); ?> maxlength="191" <?php echo e((Helper::checkIfRequired($user, 'first_name')) ? ' required' : ''); ?>/>
        <?php echo $errors->first('first_name', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

    </div>
</div>
<!-- partials/forms/edit/name-first.blade.php --><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/name-first.blade.php ENDPATH**/ ?>
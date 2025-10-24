<!-- partials/forms/edit/name-last.blade.php -->
<?php
    $class = $class ?? 'col-md-6';
    $style = $style ?? '';
    $required = $required ?? '';
    $value = $value ?? $user->last_name;
?>
<div class="form-group <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
    <label class="col-md-3 control-label" for="last_name"><?php echo e(trans('general.last_name')); ?> </label>
    <div class="<?php echo e($class); ?>" style= "<?php echo e($style ? $style : ''); ?>">
        <input class="form-control" type="text" name="last_name" id="last_name"  value="<?php echo e(old('last_name', ($value ?? $user->last_name))); ?>" maxlength="191"<?php echo e((Helper::checkIfRequired($user, 'last_name')) ? ' required' : ''); ?> />
        <?php echo $errors->first('last_name', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

    </div>
</div>
<!-- partials/forms/edit/name-last.blade.php --><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/name-last.blade.php ENDPATH**/ ?>
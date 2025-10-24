<!-- Name -->
<div class="form-group <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
    <label for="name" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>
    <div class="col-md-8 col-sm-12">
        <input class="form-control" style="width:100%;" type="text" name="name" aria-label="name" id="name" value="<?php echo e(old('name', $item->name)); ?>"<?php echo (Helper::checkIfRequired($item, 'name')) ? ' required' : ''; ?> maxlength="191" />
        <?php echo $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/name.blade.php ENDPATH**/ ?>
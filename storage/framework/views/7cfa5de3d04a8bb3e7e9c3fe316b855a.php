<!-- modals/partials/name.blade.php -->
<?php
    $required = $required ?? '';
?>
<div class="dynamic-form-row">
    <div class="col-md-4 col-xs-12"><label for="modal-name"><?php echo e(trans('general.name')); ?>:
        </label></div>
    <div class="col-md-8 col-xs-12"><input type='text' name="name" id='modal-name' class="form-control" <?php echo e($required ? 'required' : ''); ?>></div>
</div>
<!-- modals/partials/name.blade.php --><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/modals/partials/name.blade.php ENDPATH**/ ?>
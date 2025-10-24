<!-- Requestable -->
<div class="form-group">
    <div class="col-sm-offset-3 col-md-9">
        <label class="form-control" for="requestable">
        <input type="checkbox" value="1" name="requestable" id="requestable" <?php echo e(old('requestable', $item->requestable) == '1' ? ' checked="checked"' : ''); ?>> <?php echo e($requestable_text); ?>

        </label>

    </div>
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/requestable.blade.php ENDPATH**/ ?>
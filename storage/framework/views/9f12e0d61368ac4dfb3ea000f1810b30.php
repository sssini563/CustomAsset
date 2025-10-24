<div id="<?php echo e((isset($id_divname)) ? $id_divname : 'assetsBulkEditToolbar'); ?>" style="min-width:400px">
    <form
    method="POST"
    action="<?php echo e(route('hardware/bulkedit')); ?>"
    accept-charset="UTF-8"
    class="form-inline"
    id="<?php echo e((isset($id_formname)) ? $id_formname : 'assetsBulkForm'); ?>"
>
    <?php echo csrf_field(); ?>

    
    <input name="sort" type="hidden" value="assets.id">
    <input name="order" type="hidden" value="asc">
    <label for="bulk_actions">
        <span class="sr-only">
            <?php echo e(trans('button.bulk_actions')); ?>

        </span>
    </label>
    <select name="bulk_actions" class="form-control select2" aria-label="bulk_actions" style="min-width: 350px !important;">
        <?php if((isset($status)) && ($status == 'Deleted')): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', \App\Models\Asset::class)): ?>
                <option value="restore"><?php echo e(trans('button.restore')); ?></option>
            <?php endif; ?>
        <?php else: ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', \App\Models\Asset::class)): ?>
                <option value="edit"><?php echo e(trans('button.edit')); ?></option>
                <option value="maintenance"><?php echo e(trans('button.add_maintenance')); ?></option>
            <?php endif; ?>

            <?php if((!isset($status)) || (($status != 'Deployed') && ($status != 'Archived'))): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('checkout', \App\Models\Asset::class)): ?>
                    <option value="checkout"><?php echo e(trans('general.bulk_checkout')); ?></option>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', \App\Models\Asset::class)): ?>
                <option value="delete"><?php echo e(trans('button.delete')); ?></option>
            <?php endif; ?>

            <option value="labels" <?php echo e($snipeSettings->shortcuts_enabled == 1 ? "accesskey=l" : ''); ?>><?php echo e(trans_choice('button.generate_labels', 2)); ?></option>
        <?php endif; ?>
    </select>

    <button class="btn btn-primary" id="<?php echo e((isset($id_button)) ? $id_button : 'bulkAssetEditButton'); ?>" disabled><?php echo e(trans('button.go')); ?></button>
    </form>
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/asset-bulk-actions.blade.php ENDPATH**/ ?>
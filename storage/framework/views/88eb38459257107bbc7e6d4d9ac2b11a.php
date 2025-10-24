<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', \App\Models\Location::class)): ?>
    <div id="locationsBulkEditToolbar">
    <form
        method="POST"
        action="<?php echo e(route('locations.bulkdelete.show')); ?>"
        accept-charset="UTF-8"
        class="form-inline"
        id="locationsBulkForm"
    >
            <?php echo csrf_field(); ?>
            <div id="locations-toolbar">
                <label for="bulk_actions" class="sr-only"><?php echo e(trans('general.bulk_actions')); ?></label>
                <select name="bulk_actions" class="form-control select2" style="width: 200px;" aria-label="bulk_actions">
                    <option value="delete"><?php echo e(trans('general.bulk_delete')); ?></option>
                </select>
                <button class="btn btn-primary" id="bulkLocationsEditButton" disabled><?php echo e(trans('button.go')); ?></button>
            </div>

    </form>
    </div>
<?php endif; ?>

<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/locations-bulk-actions.blade.php ENDPATH**/ ?>
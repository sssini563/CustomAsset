<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', \App\Models\User::class)): ?>
    <div id="userBulkEditToolbar" class="pull-left" style="min-width:500px !important; padding-top: 10px;">

        <?php if(request('status')!='deleted'): ?>

            <form
                method="POST"
                action="<?php echo e(route('users/bulkedit')); ?>"
                accept-charset="UTF-8"
                class="form-inline"
                id="usersBulkForm"
            >
            <?php echo csrf_field(); ?>

            <div id="users-toolbar" style="width:100% !important;">
                <label for="bulk_actions" class="sr-only"><?php echo e(trans('general.bulk_actions')); ?></label>
                <select name="bulk_actions" class="form-control select2" style="width: 50% !important;" aria-label="bulk_actions">

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', \App\Models\User::class)): ?>
                        <option value="edit"><?php echo e(trans('general.bulk_edit')); ?></option>
                        <option value="send_assigned"><?php echo e(trans('admin/users/general.email_assigned')); ?></option>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', \App\Models\User::class)): ?>
                        <option value="delete"><?php echo trans('general.bulk_checkin_delete'); ?></option>
                        <option value="merge"><?php echo trans('general.merge_users'); ?></option>
                    <?php endif; ?>

                    <option value="bulkpasswordreset"><?php echo e(trans('button.send_password_link')); ?></option>
                    <option value="print"><?php echo e(trans('admin/users/general.print_assigned')); ?></option>
                </select>
                <button class="btn btn-primary" id="bulkUserEditButton" disabled><?php echo e(trans('button.go')); ?></button>
            </div>
            </form>
        <?php endif; ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/users-bulk-actions.blade.php ENDPATH**/ ?>
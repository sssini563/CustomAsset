<?php $__env->startSection('title'); ?>

    <?php if(request('status')=='deleted'): ?>
        <?php echo e(trans('general.deleted')); ?>

    <?php elseif(request('admins')=='true'): ?>
        <?php echo e(trans('general.show_admins')); ?>

    <?php elseif(request('superadmins')=='true'): ?>
        <?php echo e(trans('general.show_superadmins')); ?>

    <?php else: ?>
        <?php echo e(trans('general.current')); ?>

    <?php endif; ?>
    <?php echo e(trans('general.users')); ?>

    <?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('header_right'); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\User::class)): ?>
        <?php if($snipeSettings->ldap_enabled == 1): ?>
            <a href="<?php echo e(route('ldap/user')); ?>" class="btn btn-default pull-right"><i class="fas fa-sitemap"></i> <?php echo e(trans('general.ldap_sync')); ?></a>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
        <div class="box-body">

            <?php echo $__env->make('partials.users-bulk-actions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <table
                    data-columns="<?php echo e(\App\Presenters\UserPresenter::dataTableLayout()); ?>"
                    data-cookie-id-table="usersTable"
                    data-id-table="usersTable"
                    data-side-pagination="server"
                    data-toolbar="#userBulkEditToolbar"
                    data-bulk-button-id="#bulkUserEditButton"
                    data-bulk-form-id="#usersBulkForm"
                    data-show-columns-search="true"
                    id="usersTable"
                    data-buttons="userButtons"
                    class="table table-striped snipe-table"
                    data-url="<?php echo e(route('api.users.index',
                        [
                            'status' => e(request('status')),
                            'deleted'=> (request('status')=='deleted') ? 'true' : 'false',
                            'company_id' => e(request('company_id')),
                            'manager_id' => e(request('manager_id')),
                            'admins' => e(request('admins')),
                            'superadmins' => e(request('superadmins')),
                            'activated' => e(request('activated')),
                       ])); ?>"
                    data-export-options='{
                "fileName": "export-users-<?php echo e(date('Y-m-d')); ?>",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>


<?php echo $__env->make('partials.bootstrap-table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/users/index.blade.php ENDPATH**/ ?>
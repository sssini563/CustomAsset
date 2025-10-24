<?php $__env->startSection('title0'); ?>

  <?php if((Request::get('company_id')) && ($company)): ?>
    <?php echo e($company->name); ?>

  <?php endif; ?>



<?php if(Request::get('status')): ?>
  <?php if(Request::get('status')=='Pending'): ?>
    <?php echo e(trans('general.pending')); ?>

  <?php elseif(Request::get('status')=='RTD'): ?>
    <?php echo e(trans('general.ready_to_deploy')); ?>

  <?php elseif(Request::get('status')=='Deployed'): ?>
    <?php echo e(trans('general.deployed')); ?>

  <?php elseif(Request::get('status')=='Undeployable'): ?>
    <?php echo e(trans('general.undeployable')); ?>

  <?php elseif(Request::get('status')=='Deployable'): ?>
    <?php echo e(trans('general.deployed')); ?>

  <?php elseif(Request::get('status')=='Requestable'): ?>
    <?php echo e(trans('admin/hardware/general.requestable')); ?>

  <?php elseif(Request::get('status')=='Archived'): ?>
    <?php echo e(trans('general.archived')); ?>

  <?php elseif(Request::get('status')=='Deleted'): ?>
    <?php echo e(ucfirst(trans('general.deleted'))); ?>

  <?php elseif(Request::get('status')=='byod'): ?>
    <?php echo e(strtoupper(trans('general.byod'))); ?>

  <?php endif; ?>
<?php else: ?>
<?php echo e(trans('general.all')); ?>

<?php endif; ?>
<?php echo e(trans('general.assets')); ?>


  <?php if(Request::has('order_number')): ?>
    : Order #<?php echo e(strval(Request::get('order_number'))); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('title'); ?>
<?php echo $__env->yieldContent('title0'); ?>  <?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
       
          <div class="row">
            <div class="col-md-12">

                <?php echo $__env->make('partials.asset-bulk-actions', ['status' => Request::get('status')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                   
              <table
                data-columns="<?php echo e(\App\Presenters\AssetPresenter::dataTableLayout()); ?>"
                data-cookie-id-table="<?php echo e(request()->has('status') ? e(request()->input('status')) : ''); ?>assetsListingTable"
                data-id-table="<?php echo e(request()->has('status') ? e(request()->input('status')) : ''); ?>assetsListingTable"
                data-side-pagination="server"
                data-show-footer="true"
                data-sort-order="asc"
                data-sort-name="name"
                data-show-columns-search="true"
                data-toolbar="#assetsBulkEditToolbar"
                data-bulk-button-id="#bulkAssetEditButton"
                data-bulk-form-id="#assetsBulkForm"
                data-buttons="assetButtons"
                id="<?php echo e(request()->has('status') ? e(request()->input('status')) : ''); ?>assetsListingTable"
                class="table table-striped snipe-table"
                data-url="<?php echo e(route('api.assets.index',
                    array('status' => e(Request::get('status')),
                    'order_number'=>e(strval(Request::get('order_number'))),
                    'company_id'=>e(Request::get('company_id')),
                    'status_id'=>e(Request::get('status_id'))))); ?>"
                data-export-options='{
                "fileName": "export<?php echo e((Request::has('status')) ? '-'.str_slug(Request::get('status')) : ''); ?>-assets-<?php echo e(date('Y-m-d')); ?>",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
              </table>

            </div><!-- /.col -->
          </div><!-- /.row -->
        
      </div><!-- ./box-body -->
    </div><!-- /.box -->
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>
<?php echo $__env->make('partials.bootstrap-table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/hardware/index.blade.php ENDPATH**/ ?>
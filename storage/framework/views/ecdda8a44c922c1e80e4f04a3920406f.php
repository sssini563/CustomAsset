<?php $__env->startSection('title'); ?>
<?php echo e(trans('general.accessories')); ?>

<?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">

            <table
                data-columns="<?php echo e(\App\Presenters\AccessoryPresenter::dataTableLayout()); ?>"
                data-cookie-id-table="accessoriesTable"
                data-id-table="accessoriesTable"
                data-side-pagination="server"
                data-show-footer="true"
                data-sort-order="asc"
                data-footer-style="footerStyle"
                id="accessoriesTable"
                data-buttons="accessoryButtons"
                class="table table-striped snipe-table"
                data-url="<?php echo e(route('api.accessories.index')); ?>"
                data-export-options='{
                    "fileName": "export-accessories-<?php echo e(date('Y-m-d')); ?>",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
          </table>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>
<?php echo $__env->make('partials.bootstrap-table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/accessories/index.blade.php ENDPATH**/ ?>
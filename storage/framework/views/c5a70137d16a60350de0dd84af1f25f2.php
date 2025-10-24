<?php $__env->startSection('title'); ?>
<?php echo e(trans('admin/licenses/general.software_licenses')); ?>

<?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>


<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">

          <table
              data-columns="<?php echo e(\App\Presenters\LicensePresenter::dataTableLayout()); ?>"
              data-cookie-id-table="licensesTable"
              data-side-pagination="server"
              data-footer-style="footerStyle"
              data-show-footer="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="licensesTable"
              data-buttons="licenseButtons"
              class="table table-striped snipe-table"
              data-url="<?php echo e(route('api.licenses.index', ['status' => e(request('status'))])); ?>"
              data-export-options='{
            "fileName": "export-licenses-<?php echo e(date('Y-m-d')); ?>",
            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
            }'>
          </table>

      </div><!-- /.box-body -->

      <div class="box-footer clearfix">
      </div>
    </div><!-- /.box -->
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>
<?php echo $__env->make('partials.bootstrap-table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/licenses/index.blade.php ENDPATH**/ ?>
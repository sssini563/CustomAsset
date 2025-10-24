<?php $__env->startSection('title'); ?>
<?php echo e(trans('general.locations')); ?>

<?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
          <?php echo $__env->make('partials.locations-bulk-actions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

          <table
                  data-columns="<?php echo e(\App\Presenters\LocationPresenter::dataTableLayout()); ?>"
                  data-cookie-id-table="locationTable"
                  data-id-table="locationTable"
                  data-toolbar="#locationsBulkEditToolbar"
                  data-bulk-button-id="#bulkLocationsEditButton"
                  data-bulk-form-id="#locationsBulkForm"
                  data-side-pagination="server"
                  data-sort-order="asc"
                  data-buttons="locationButtons"
                  id="locationTable"
                  class="table table-striped snipe-table"
                  data-url="<?php echo e(route('api.locations.index', ['company_id'=>e(request('company_id')), 'status' => e(request('status'))])); ?>"
                  data-export-options='{
              "fileName": "export-locations-<?php echo e(date('Y-m-d')); ?>",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>
<?php echo $__env->make('partials.bootstrap-table', ['exportFile' => 'locations-export', 'search' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/locations/index.blade.php ENDPATH**/ ?>
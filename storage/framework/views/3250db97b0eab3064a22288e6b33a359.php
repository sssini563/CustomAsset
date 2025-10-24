<?php $__env->startSection('title'); ?>
<?php echo e(trans('general.components')); ?>

<?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <table
                data-columns="<?php echo e(\App\Presenters\ComponentPresenter::dataTableLayout()); ?>"
                data-cookie-id-table="componentsTable"
                data-id-table="componentsTable"
                data-side-pagination="server"
                data-footer-style="footerStyle"
                data-show-footer="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="componentsTable"
                data-buttons="componentButtons"
                class="table table-striped snipe-table"
                data-url="<?php echo e(route('api.components.index')); ?>"
                data-export-options='{
                "fileName": "export-components-<?php echo e(date('Y-m-d')); ?>",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>
<?php echo $__env->make('partials.bootstrap-table', ['exportFile' => 'components-export', 'search' => true, 'showFooter' => true, 'columns' => \App\Presenters\ComponentPresenter::dataTableLayout()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/components/index.blade.php ENDPATH**/ ?>
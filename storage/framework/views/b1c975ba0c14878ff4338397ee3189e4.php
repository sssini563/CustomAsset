
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title"><?php echo e(trans('admin/categories/general.create')); ?></h2>
        </div>
        <div class="modal-body">
            <form action="<?php echo e(route('api.categories.store')); ?>" onsubmit="return false">
                <?php echo e(csrf_field()); ?>

                <div class="alert alert-danger" id="modal_error_msg" style="display:none">
                </div>
                <?php echo $__env->make('modals.partials.name', ['required' => 'true'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <input type="hidden" name='category_type' id="modal-category_type" value="<?php echo e(request('category_type')); ?>" />
            </form>
        </div>
       <?php echo $__env->make('modals.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/modals/category.blade.php ENDPATH**/ ?>
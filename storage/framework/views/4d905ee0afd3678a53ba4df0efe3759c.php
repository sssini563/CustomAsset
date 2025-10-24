<div id="assigned_user" class="form-group<?php echo e($errors->has($fieldname) ? ' has-error' : ''); ?>">

    <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>

    <div class="col-md-6">
        <select class="js-data-ajax" data-endpoint="departments" data-placeholder="<?php echo e(trans('general.select_department')); ?>" name="<?php echo e($fieldname); ?>" style="width: 100%" id="department_select" aria-label="<?php echo e($fieldname); ?>"<?php echo e((isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : ''); ?>>
            <?php if(isset($selected)): ?>
                <?php if(!is_iterable($selected)): ?>
                    <?php
                        $selected = [$selected];
                    ?>
                <?php endif; ?>
                <?php $__currentLoopData = $selected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($department_id); ?>" selected="selected" role="option" aria-selected="true">
                        <?php echo e(\App\Models\Department::find($department_id)->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($department_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : '')): ?>
                <option value="<?php echo e($department_id); ?>" selected="selected" role="option" aria-selected="true"  role="option">
                    <?php echo e((\App\Models\Department::find($department_id)) ? \App\Models\Department::find($department_id)->name : ''); ?>

                </option>
            <?php endif; ?>
        </select>
    </div>


    <?php echo $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span></div>'); ?>


</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/department-select.blade.php ENDPATH**/ ?>
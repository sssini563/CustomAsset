<!-- Asset Model -->
<div id="<?php echo e($fieldname); ?>" class="form-group<?php echo e($errors->has($fieldname) ? ' has-error' : ''); ?>">

    <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>

    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="manufacturers" data-placeholder="<?php echo e(trans('general.select_manufacturer')); ?>" name="<?php echo e($fieldname); ?>" style="width: 100%" id="manufacturer_select_id" aria-label="<?php echo e($fieldname); ?>" <?php echo ((isset($item)) && (Helper::checkIfRequired($item, $fieldname))) ? ' required ' : ''; ?><?php echo e((isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : ''); ?>>
            <?php if(isset($selected)): ?>
                <?php if(!is_iterable($selected)): ?>
                    <?php
                        $selected = [$selected];
                    ?>
                <?php endif; ?>
                <?php $__currentLoopData = $selected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturer_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($manufacturer_id); ?>" selected="selected" role="option" aria-selected="true"  role="option">
                        <?php echo e(\App\Models\Manufacturer::find($manufacturer_id)->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($manufacturer_id = old($fieldname,  (isset($item)) ? $item->{$fieldname} : '')): ?>
                <option value="<?php echo e($manufacturer_id); ?>" selected="selected" role="option" aria-selected="true"  role="option">
                    <?php echo e((\App\Models\Manufacturer::find($manufacturer_id)) ? \App\Models\Manufacturer::find($manufacturer_id)->name : ''); ?>

                </option>
            <?php else: ?>
                <?php echo (!isset($multiple) || ($multiple=='false')) ? '<option value="" role="option">'.trans('general.select_manufacturer').'</option>' : ''; ?>

            <?php endif; ?>

        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Manufacturer::class)): ?>
            <?php if((!isset($hide_new)) || ($hide_new!='true')): ?>
                <a href='<?php echo e(route('modal.show', 'manufacturer')); ?>' data-toggle="modal"  data-target="#createModal" data-select='manufacturer_select_id' class="btn btn-sm btn-primary"><?php echo e(trans('button.new')); ?></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>


    <?php echo $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span></div>'); ?>

</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/manufacturer-select.blade.php ENDPATH**/ ?>
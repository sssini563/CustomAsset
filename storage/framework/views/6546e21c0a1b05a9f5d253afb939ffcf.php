<!-- Location -->
<div id="<?php echo e($fieldname); ?>" class="form-group<?php echo e($errors->has($fieldname) ? ' has-error' : ''); ?>"<?php echo (isset($style)) ? ' style="'.e($style).'"' : ''; ?>>

    <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>
    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="locations" data-placeholder="<?php echo e(trans('general.select_location')); ?>" name="<?php echo e($fieldname); ?>" style="width: 100%" id="<?php echo e($fieldname); ?>_location_select" aria-label="<?php echo e($fieldname); ?>"<?php echo e((isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : ''); ?><?php echo ((isset($item)) && (Helper::checkIfRequired($item, $fieldname))) ? ' required ' : ''; ?>>
            <?php if(isset($selected)): ?>
                <?php $__currentLoopData = $selected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($location_id); ?>" selected="selected" role="option" aria-selected="true"  role="option">
                        <?php echo e((\App\Models\Location::find($location_id))->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($location_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : '')): ?>
                <option value="<?php echo e($location_id); ?>" selected="selected" role="option" aria-selected="true"  role="option">
                    <?php echo e((\App\Models\Location::find($location_id)) ? \App\Models\Location::find($location_id)->name : ''); ?>

                </option>
            <?php endif; ?>
        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Location::class)): ?>
            <?php if((!isset($hide_new)) || ($hide_new!='true')): ?>
            <a href='<?php echo e(route('modal.show', 'location')); ?>' data-toggle="modal"  data-target="#createModal" data-select='<?php echo e($fieldname); ?>_location_select' class="btn btn-sm btn-primary"><?php echo e(trans('button.new')); ?></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php echo $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span></div>'); ?>


    <?php if(isset($help_text)): ?>
    <div class="col-md-7 col-sm-11 col-md-offset-3">
        <p class="help-block"><?php echo e($help_text); ?></p>
    </div>
    <?php endif; ?>

    <?php if(isset($hide_location_radio)): ?>
    <!-- Update actual location  -->
    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <label class="form-control">
                <input name="update_default_location" type="radio" value="1" checked="checked" aria-label="update_default_location" />
                <?php echo e(trans('admin/hardware/form.asset_location')); ?>

            </label>
            <label class="form-control">
                <input name="update_default_location" type="radio" value="0" aria-label="update_default_location" />
                <?php echo e(trans('admin/hardware/form.asset_location_update_default_current')); ?>

            </label>
        </div>
    </div> <!--/form-group-->
    <?php endif; ?>

</div>



<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/location-select.blade.php ENDPATH**/ ?>
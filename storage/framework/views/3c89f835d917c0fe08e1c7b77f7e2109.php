<!-- Asset Model -->
<div id="<?php echo e($fieldname); ?>" class="form-group<?php echo e($errors->has($fieldname) ? ' has-error' : ''); ?>">

    <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>

    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="models" data-placeholder="<?php echo e(trans('general.select_model')); ?>" name="<?php echo e($fieldname); ?>" style="width: 100%" id="model_select_id" aria-label="<?php echo e($fieldname); ?>"<?php echo e(((isset($field_req)) || ((isset($required) && ($required =='true')))) ?  ' required' : ''); ?><?php echo e((isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : ''); ?>>
            <?php if(isset($selected)): ?>
                <?php if(!is_iterable($selected)): ?>
                    <?php
                        $selected = [$selected];
                    ?>
                <?php endif; ?>
                <?php $__currentLoopData = $selected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($model_id); ?>" selected="selected" role="option" aria-selected="true">
                        <?php echo e(\App\Models\AssetModel::find($model_id)->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($model_id = old($fieldname, ($item->{$fieldname} ?? request($fieldname) ?? ''))): ?>
                <option value="<?php echo e($model_id); ?>" selected="selected">
                    <?php echo e((\App\Models\AssetModel::find($model_id)) ? \App\Models\AssetModel::find($model_id)->name : ''); ?>

                </option>
            <?php endif; ?>

        </select>
    </div>
    <div class="col-md-1 col-sm-1 text-left">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\AssetModel::class)): ?>
            <?php if((!isset($hide_new)) || ($hide_new!='true')): ?>
                <a href='<?php echo e(route('modal.show', 'model')); ?>' data-toggle="modal"  data-target="#createModal" data-select='model_select_id' class="btn btn-sm btn-primary"><?php echo e(trans('button.new')); ?></a>
                <span class="mac_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;">
                    <i class="fas fa-spinner fa-spin" aria-hidden="true"></i>
                </span>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php echo $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span></div>'); ?>

</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/model-select.blade.php ENDPATH**/ ?>
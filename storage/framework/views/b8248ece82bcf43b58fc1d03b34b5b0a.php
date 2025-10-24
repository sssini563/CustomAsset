<div id="assigned_user" class="form-group<?php echo e($errors->has($fieldname) ? ' has-error' : ''); ?>"<?php echo (isset($style)) ? ' style="'.e($style).'"' : ''; ?>>

    <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>

    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="users" data-placeholder="<?php echo e(trans('general.select_user')); ?>" name="<?php echo e($fieldname); ?>" style="width: 100%" id="assigned_user_select" aria-label="<?php echo e($fieldname); ?>"<?php echo e(((isset($required)) && ($required=='true')) ? ' required' : ''); ?>>
            <?php if($user_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : '')): ?>
                <option value="<?php echo e($user_id); ?>" selected="selected" role="option" aria-selected="true"  role="option">
                    <?php echo e((\App\Models\User::find($user_id)) ? \App\Models\User::find($user_id)->present()->fullName : ''); ?>

                </option>
            <?php else: ?>
                <option value=""  role="option"><?php echo e(trans('general.select_user')); ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\User::class)): ?>
            <?php if((!isset($hide_new)) || ($hide_new!='true')): ?>
                <a href='<?php echo e(route('modal.show', 'user')); ?>' data-toggle="modal"  data-target="#createModal" data-select='assigned_user_select' class="btn btn-sm btn-primary"><?php echo e(trans('button.new')); ?></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php echo $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span></div>'); ?>


</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/user-select.blade.php ENDPATH**/ ?>
<?php $__env->startSection('inputFields'); ?>
<?php echo $__env->make('partials.forms.edit.name', ['translated_name' => trans('admin/licenses/form.name')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.forms.edit.category-select', ['translated_name' => trans('admin/categories/general.category_name'), 'fieldname' => 'category_id', 'required' => 'true', 'category_type' => 'license'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



<!-- Seats -->
<div class="form-group <?php echo e($errors->has('seats') ? ' has-error' : ''); ?>">
    <label for="seats" class="col-md-3 control-label"><?php echo e(trans('admin/licenses/form.seats')); ?></label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-12" style="padding-left:0px">
            <input class="form-control" type="text" name="seats" id="seats" value="<?php echo e(old('seats', $item->seats)); ?>" minlength="1" required style="width: 97px;">
        </div>
    </div>
    <?php echo $errors->first('seats', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span></div>'); ?>

</div>
<?php echo $__env->make('partials.forms.edit.minimum_quantity', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Serial-->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewKeys', $item)): ?>
    <div class="form-group <?php echo e($errors->has('serial') ? ' has-error' : ''); ?>">
        <label for="serial" class="col-md-3 control-label"><?php echo e(trans('admin/licenses/form.license_key')); ?></label>
        <div class="col-md-7">
            <textarea class="form-control" type="text" name="serial" id="serial" rows="5"<?php echo e((Helper::checkIfRequired($item, 'serial')) ? ' required' : ''); ?>><?php echo e(old('serial', $item->serial)); ?></textarea>
            <?php echo $errors->first('serial', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

        </div>
    </div>
<?php endif; ?>

<?php echo $__env->make('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id',], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Licensed to name -->
<div class="form-group <?php echo e($errors->has('license_name') ? ' has-error' : ''); ?>">
    <label for="license_name" class="col-md-3 control-label"><?php echo e(trans('admin/licenses/form.to_name')); ?></label>
    <div class="col-md-7">
        <input class="form-control" type="text" name="license_name" id="license_name" value="<?php echo e(old('license_name', $item->license_name)); ?>" />
        <?php echo $errors->first('license_name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>
</div>

<!-- Licensed to email -->
<div class="form-group <?php echo e($errors->has('license_email') ? ' has-error' : ''); ?>">
    <label for="license_email" class="col-md-3 control-label"><?php echo e(trans('admin/licenses/form.to_email')); ?></label>
    <div class="col-md-7">
        <input class="form-control" type="email" name="license_email" id="license_email" value="<?php echo e(old('license_email', $item->license_email)); ?>" />
        <?php echo $errors->first('license_email', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>
</div>

<!-- Reassignable -->
<div class="form-group <?php echo e($errors->has('reassignable') ? ' has-error' : ''); ?>">
    <div class="col-md-3 control-label">
        <strong><?php echo e(trans('admin/licenses/form.reassignable')); ?></strong>
    </div>
    <div class="col-md-7">
        <label class="form-control">
            <input type="checkbox" name="reassignable" value="1" aria-label="reassignable" <?php if(old('reassignable', $item->id ? $item->reassignable : '1')): echo 'checked'; endif; ?>>
        <?php echo e(trans('general.yes')); ?>

        </label>
    </div>
</div>


<?php echo $__env->make('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.forms.edit.order_number', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.forms.edit.purchase_cost', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.forms.edit.datepicker', ['translated_name' => trans('general.purchase_date'),'fieldname' => 'purchase_date'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Expiration Date -->
<div class="form-group <?php echo e($errors->has('expiration_date') ? ' has-error' : ''); ?>">
    <label for="expiration_date" class="col-md-3 control-label"><?php echo e(trans('admin/licenses/form.expiration')); ?></label>

    <div class="input-group col-md-4">
        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true" data-date-clear-btn="true">
            <input type="text" class="form-control" placeholder="<?php echo e(trans('general.select_date')); ?>" name="expiration_date" id="expiration_date" value="<?php echo e(old('expiration_date', ($item->expiration_date) ? $item->expiration_date->format('Y-m-d') : '')); ?>" maxlength="10">
            <span class="input-group-addon"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'calendar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'calendar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></span>
        </div>
        <?php echo $errors->first('expiration_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>

</div>

<!-- Termination Date -->
<div class="form-group <?php echo e($errors->has('termination_date') ? ' has-error' : ''); ?>">
    <label for="termination_date" class="col-md-3 control-label"><?php echo e(trans('admin/licenses/form.termination_date')); ?></label>

    <div class="input-group col-md-4">
        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-autoclose="true" data-date-clear-btn="true">
            <input type="text" class="form-control" placeholder="<?php echo e(trans('general.select_date')); ?>" name="termination_date" id="termination_date" value="<?php echo e(old('termination_date', ($item->termination_date) ? $item->termination_date->format('Y-m-d') : '')); ?>" maxlength="10">
            <span class="input-group-addon"><?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'calendar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'calendar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?></span>
        </div>
        <?php echo $errors->first('termination_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>
</div>


<!-- Purchase Order -->
<div class="form-group <?php echo e($errors->has('purchase_order') ? ' has-error' : ''); ?>">
    <label for="purchase_order" class="col-md-3 control-label"><?php echo e(trans('admin/licenses/form.purchase_order')); ?></label>
    <div class="col-md-3">
        <input class="form-control" type="text" name="purchase_order" id="purchase_order" value="<?php echo e(old('purchase_order', $item->purchase_order)); ?>" maxlength="191" />
        <?php echo $errors->first('purchase_order', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>
</div>

<?php echo $__env->make('partials.forms.edit.depreciation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Maintained -->
<div class="form-group <?php echo e($errors->has('maintained') ? ' has-error' : ''); ?>">
    <div class="col-md-3 control-label"><strong><?php echo e(trans('admin/licenses/form.maintained')); ?></strong></div>
    <div class="col-md-7">
        <label class="form-control">
            <input type="checkbox" name="maintained" value="1" aria-label="maintained" <?php if(old('maintained', $item->maintained)): echo 'checked'; endif; ?>>
        <?php echo e(trans('general.yes')); ?>

        </label>
    </div>
</div>

<?php echo $__env->make('partials.forms.edit.notes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/edit-form', [
    'createText' => trans('admin/licenses/form.create'),
    'updateText' => trans('admin/licenses/form.update'),
    'topSubmit' => true,
    'formAction' => ($item->id) ? route('licenses.update', ['license' => $item->id]) : route('licenses.store'),
     'index_route' => 'licenses.index',
    'options' => [
                'back' => trans('admin/hardware/form.redirect_to_type',['type' => trans('general.previous_page')]),
                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'licenses']),
                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.license')]),
               ]
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/licenses/edit.blade.php ENDPATH**/ ?>
<!-- Depreciation -->
<div class="form-group <?php echo e($errors->has('depreciation_id') ? ' has-error' : ''); ?>">
    <label for="depreciation_id" class="col-md-3 control-label"><?php echo e(trans('general.depreciation')); ?></label>
    <div class="col-md-7">
        <?php if (isset($component)) { $__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::input.select','data' => ['name' => 'depreciation_id','id' => 'depreciation_id','options' => $depreciation_list,'selected' => old('depreciation_id', $item->depreciation_id),'style' => 'width:350px;','ariaLabel' => 'depreciation_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'depreciation_id','id' => 'depreciation_id','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($depreciation_list),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('depreciation_id', $item->depreciation_id)),'style' => 'width:350px;','aria-label' => 'depreciation_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d)): ?>
<?php $attributes = $__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d; ?>
<?php unset($__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d)): ?>
<?php $component = $__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d; ?>
<?php unset($__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d); ?>
<?php endif; ?>
        <?php echo $errors->first('depreciation_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/depreciation.blade.php ENDPATH**/ ?>
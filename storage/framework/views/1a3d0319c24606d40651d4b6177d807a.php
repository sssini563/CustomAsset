<!-- Datepicker -->
<div class="form-group<?php echo e($errors->has($fieldname) ? ' has-error' : ''); ?>">
    <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>
    <div class="input-group col-md-4">
        <?php if (isset($component)) { $__componentOriginale530cbcce38b00a976507c1c20eec6cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale530cbcce38b00a976507c1c20eec6cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::input.datepicker','data' => ['name' => ''.e($fieldname).'','value' => ''.e(old($fieldname, ($item->{$fieldname}) ? date('Y-m-d', strtotime($item->{$fieldname})) : '')).'','placeholder' => ''.e(trans('general.select_date')).'','required' => ''.e(Helper::checkIfRequired($item, 'start_date')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.datepicker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e($fieldname).'','value' => ''.e(old($fieldname, ($item->{$fieldname}) ? date('Y-m-d', strtotime($item->{$fieldname})) : '')).'','placeholder' => ''.e(trans('general.select_date')).'','required' => ''.e(Helper::checkIfRequired($item, 'start_date')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale530cbcce38b00a976507c1c20eec6cf)): ?>
<?php $attributes = $__attributesOriginale530cbcce38b00a976507c1c20eec6cf; ?>
<?php unset($__attributesOriginale530cbcce38b00a976507c1c20eec6cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale530cbcce38b00a976507c1c20eec6cf)): ?>
<?php $component = $__componentOriginale530cbcce38b00a976507c1c20eec6cf; ?>
<?php unset($__componentOriginale530cbcce38b00a976507c1c20eec6cf); ?>
<?php endif; ?>
        <?php echo $errors->first($fieldname, '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>
    <?php if(isset($help_text)): ?>
        <div class="col-md-8 col-md-offset-3">
            <p class="help-block">
                <?php echo $help_text; ?>

            </p>
        </div>
    <?php endif; ?>
</div>

<!-- /Datepicker --><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/datepicker.blade.php ENDPATH**/ ?>
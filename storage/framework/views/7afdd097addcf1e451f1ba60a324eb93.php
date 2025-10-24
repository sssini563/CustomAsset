<div class="form-group" id="assignto_selector"<?php echo (isset($style)) ? ' style="'.e($style).'"' : ''; ?>>
    <label for="checkout_to_type" class="col-md-3 control-label"><?php echo e(trans('admin/hardware/form.checkout_to')); ?></label>
    <div class="col-md-8">

        <div class="btn-group" data-toggle="buttons">
            <?php if((isset($user_select)) && ($user_select!='false')): ?>
                <label class="btn btn-default<?php echo e((session('checkout_to_type') ?: 'user') == 'user' ? ' active' : ''); ?>">
                    <input name="checkout_to_type" value="user" aria-label="checkout_to_type"
                           type="radio" <?php echo e((session('checkout_to_type') ?: 'user') == 'user' ? 'checked' : ''); ?>>
                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'user']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'user']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $attributes = $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__attributesOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc)): ?>
<?php $component = $__componentOriginalce262628e3a8d44dc38fd1f3965181bc; ?>
<?php unset($__componentOriginalce262628e3a8d44dc38fd1f3965181bc); ?>
<?php endif; ?>
                <?php echo e(trans('general.user')); ?>

            </label>
            <?php endif; ?>
            <?php if((isset($asset_select)) && ($asset_select!='false')): ?>
                <label class="btn btn-default<?php echo e(session('checkout_to_type') == 'asset' ? ' active' : ''); ?>">
                    <input name="checkout_to_type" value="asset" aria-label="checkout_to_type"
                           type="radio" <?php echo e(session('checkout_to_type') == 'asset' ? 'checked': ''); ?>>
                <i class="fas fa-barcode" aria-hidden="true"></i>
                <?php echo e(trans('general.asset')); ?>

            </label>
            <?php endif; ?>
            <?php if((isset($location_select)) && ($location_select!='false')): ?>
                <label class="btn btn-default<?php echo e(session('checkout_to_type') == 'location' ? ' active' : ''); ?>">
                    <input name="checkout_to_type" value="location" aria-label="checkout_to_type"
                           type="radio" <?php echo e(session('checkout_to_type') == 'location' ? 'checked' : ''); ?>>
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                <?php echo e(trans('general.location')); ?>

            </label>
            <?php endif; ?>

            <?php echo $errors->first('checkout_to_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

        </div>
    </div>
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/checkout-selector.blade.php ENDPATH**/ ?>
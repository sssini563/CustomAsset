<!-- Min QTY -->
<div class="form-group<?php echo e($errors->has('min_amt') ? ' has-error' : ''); ?>">
    <label for="min_amt" class="col-md-3 control-label"><?php echo e(trans('general.min_amt')); ?></label>
    <div class="col-md-9">
       <div class="col-md-2" style="padding-left:0px">
           <input class="form-control col-md-3" maxlength="5" type="text" name="min_amt" id="min_amt"
                  aria-label="min_amt"
                  value="<?php echo e(old('min_amt', ($item->min_amt ?? ''))); ?>"
                   <?php echo e((isset($item) && (Helper::checkIfRequired($item, 'min_amt')) ? ' required' : '')); ?>/>
        </div>
            <div class="col-md-7" style="margin-left: -15px;">

                <a href="#" data-tooltip="true" title="<?php echo e(trans('general.min_amt_help')); ?>">
                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'info-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info-circle']); ?>
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
                <span class="sr-only"><?php echo e(trans('general.min_amt_help')); ?></span>
            </a>
        </div>
        <div class="col-md-12">
           <?php echo $errors->first('min_amt', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

        </div>
    </div>
</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/minimum_quantity.blade.php ENDPATH**/ ?>
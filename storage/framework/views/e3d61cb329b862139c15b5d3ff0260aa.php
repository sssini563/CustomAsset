<!-- Status -->
<div class="form-group <?php echo e($errors->has('status_id') ? ' has-error' : ''); ?>">
    <label for="status_id" class="col-md-3 control-label"><?php echo e(trans('admin/hardware/form.status')); ?></label>
    <div class="col-md-7 col-sm-11">
        <?php if (isset($component)) { $__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::input.select','data' => ['name' => 'status_id','id' => 'status_select_id','options' => $statuslabel_list,'selected' => old('status_id', $item->status_id),'required' => $required,'class' => 'status_id','style' => 'width:100%;','ariaLabel' => 'status_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'status_id','id' => 'status_select_id','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statuslabel_list),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('status_id', $item->status_id)),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required),'class' => 'status_id','style' => 'width:100%;','aria-label' => 'status_id']); ?>
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
        <?php echo $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

    </div>
    <div class="col-md-2 col-sm-2 text-left">

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Statuslabel::class)): ?>
            <a href='<?php echo e(route('modal.show', 'statuslabel')); ?>' data-toggle="modal"  data-target="#createModal" data-select='status_select_id' class="btn btn-sm btn-primary"><?php echo e(trans('button.new')); ?></a>
        <?php endif; ?>

        <span class="status_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fas fa-spinner fa-spin" aria-hidden="true"></i> </span>

    </div>

    <div class="col-md-7 col-sm-11 col-md-offset-3" id="status_helptext">
        <p id="selected_status_status" style="display:none;"></p>
    </div>

</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/status.blade.php ENDPATH**/ ?>
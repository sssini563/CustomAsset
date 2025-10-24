<?php if(($model) && ($model->fieldset) && $model->fieldset->displayAnyFieldsInForm($show_custom_fields_type ?? '')): ?>
    <div class="col-md-12 col-sm-12">

    <fieldset name="custom-fields" class="bottom-padded">
        <legend class="highlight">
            <?php echo e(trans('admin/custom_fields/general.custom_fields')); ?>

        </legend>

  <?php $__currentLoopData = $model->fieldset->fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(!isset($show_custom_fields_type) || ($field->displayFieldInCurrentForm($show_custom_fields_type))): ?>


    <div class="form-group<?php echo e($errors->has($field->db_column_name()) ? ' has-error' : ''); ?>">


      <label for="<?php echo e($field->db_column_name()); ?>" class="col-md-3 control-label">
          <?php echo e($field->name); ?>


      </label>

      <div class="col-md-7 col-sm-12">

          <?php if($field->element!='text'): ?>

              <?php if($field->element=='listbox'): ?>
                  <!-- Listbox -->
                  <?php if (isset($component)) { $__componentOriginalec0f377b60f1e2ad7b17ff3295f4376d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec0f377b60f1e2ad7b17ff3295f4376d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::input.select','data' => ['name' => $field->db_column_name(),'options' => $field->formatFieldValuesAsArray(),'selected' => old($field->db_column_name(), (isset($item) ? Helper::gracefulDecrypt($field, $item->{$field->db_column_name()}) : $field->defaultValue($model->id))),'required' => $field->pivot->required == '1','class' => 'format form-control']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($field->db_column_name()),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($field->formatFieldValuesAsArray()),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old($field->db_column_name(), (isset($item) ? Helper::gracefulDecrypt($field, $item->{$field->db_column_name()}) : $field->defaultValue($model->id)))),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($field->pivot->required == '1'),'class' => 'format form-control']); ?>
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

              <?php elseif($field->element=='textarea'): ?>
                  <!-- Textarea -->
                  <textarea class="col-md-6 form-control" id="<?php echo e($field->db_column_name()); ?>" name="<?php echo e($field->db_column_name()); ?>"<?php echo e(($field->pivot->required=='1') ? ' required' : ''); ?>><?php echo e(old($field->db_column_name(),(isset($item) ? Helper::gracefulDecrypt($field, $item->{$field->db_column_name()}) : $field->defaultValue($model->id)))); ?></textarea>

              <?php elseif($field->element=='checkbox'): ?>
                  <!-- Checkbox -->
                  <?php $__currentLoopData = $field->formatFieldValuesAsArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div>
                          <label class="form-control">
                              <input type="checkbox" value="<?php echo e($value); ?>" name="<?php echo e($field->db_column_name()); ?>[]" <?php echo e(isset($item) ? (in_array($value, array_map('trim', explode(',', $item->{$field->db_column_name()}))) ? ' checked="checked"' : '') : (old($field->db_column_name()) != '' ? ' checked="checked"' : (in_array($key, array_map('trim', explode(',', $field->defaultValue($model->id)))) ? ' checked="checked"' : ''))); ?>>
                              <?php echo e($value); ?>

                          </label>
                      </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              <?php elseif($field->element=='radio'): ?>
                  <!-- Radio -->
                  <?php $__currentLoopData = $field->formatFieldValuesAsArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div>
                          <label class="form-control">
                              <input type="radio" value="<?php echo e($value); ?>" name="<?php echo e($field->db_column_name()); ?>" <?php echo e(isset($item) ? ($item->{$field->db_column_name()} == $value ? ' checked="checked"' : '') : (old($field->db_column_name()) != '' ? ' checked="checked"' : (in_array($value, explode(', ', $field->defaultValue($model->id))) ? ' checked="checked"' : ''))); ?>>
                              <?php echo e($value); ?>

                          </label>
                      </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>


          <?php else: ?>
            <!-- Date field -->
                <?php if($field->format=='DATE'): ?>

                        <div class="input-group col-md-5" style="padding-left: 0px;">
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-autoclose="true" data-date-clear-btn="true">
                                <input type="text" class="form-control" placeholder="<?php echo e(trans('general.select_date')); ?>" name="<?php echo e($field->db_column_name()); ?>" id="<?php echo e($field->db_column_name()); ?>" readonly value="<?php echo e(old($field->db_column_name(),(isset($item) ? Helper::gracefulDecrypt($field, $item->{$field->db_column_name()}) : $field->defaultValue($model->id)))); ?>"  style="background-color:inherit"<?php echo e(($field->pivot->required=='1') ? ' required' : ''); ?>>
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
                        </div>


                <?php else: ?>
                    <?php if(($field->field_encrypted=='0') || (Gate::allows('assets.view.encrypted_custom_fields'))): ?>
                    <input type="text" value="<?php echo e(old($field->db_column_name(),(isset($item) ? Helper::gracefulDecrypt($field, $item->{$field->db_column_name()}) : $field->defaultValue($model->id)))); ?>" id="<?php echo e($field->db_column_name()); ?>" class="form-control" name="<?php echo e($field->db_column_name()); ?>" placeholder="Enter <?php echo e(strtolower($field->format)); ?> text"<?php echo e(($field->pivot->required=='1') ? ' required' : ''); ?>>
                        <?php else: ?>
                            <input type="text" value="<?php echo e(strtoupper(trans('admin/custom_fields/general.encrypted'))); ?>" class="form-control disabled" disabled>
                    <?php endif; ?>
                <?php endif; ?>

          <?php endif; ?>

              <?php if($field->help_text!=''): ?>
              <p class="help-block"><?php echo e($field->help_text); ?></p>
              <?php endif; ?>

                  <?php
                  $errormessage = $errors->first($field->db_column_name());
                  if ($errormessage) {
                      $errormessage = preg_replace('/ snipeit /', '', $errormessage);
                      print('<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> '.$errormessage.'</span>');
                  }
                  ?>
      </div>

        <?php if($field->field_encrypted): ?>
        <div class="col-md-1 col-sm-1 text-left">
            <i class="fas fa-lock" data-tooltip="true" data-placement="top" title="<?php echo e(trans('admin/custom_fields/general.value_encrypted')); ?>"></i>
        </div>
        <?php endif; ?>

    </div>
            <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </fieldset>
    </div>
<?php endif; ?>



<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/models/custom_fields_form.blade.php ENDPATH**/ ?>
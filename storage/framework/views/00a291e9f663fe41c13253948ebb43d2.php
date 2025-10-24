<!-- Company -->
<?php if(($snipeSettings->full_multiple_companies_support=='1') && (!Auth::user()->isSuperUser())): ?>
    <!-- full company support is enabled and this user isn't a superadmin -->
    <div class="form-group">
        <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>
        <div class="col-md-6">
            <select class="js-data-ajax" disabled="true" data-endpoint="companies" data-placeholder="<?php echo e(trans('general.select_company')); ?>" name="<?php echo e($fieldname); ?>" style="width: 100%" id="company_select" aria-label="<?php echo e($fieldname); ?>"<?php echo e((isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : ''); ?>>
                <?php if($company_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : '')): ?>
                    <option value="<?php echo e($company_id); ?>" selected="selected" role="option" aria-selected="true"  role="option">
                        <?php echo e((\App\Models\Company::find($company_id)) ? \App\Models\Company::find($company_id)->name : ''); ?>

                    </option>
                <?php else: ?>
                    <?php echo (!isset($multiple) || ($multiple=='false')) ? '<option value="" role="option">'.trans('general.select_company').'</option>' : ''; ?>

                <?php endif; ?>
            </select>
        </div>
    </div>

<?php else: ?>
    <!-- full company support is enabled or this user is a superadmin -->
    <div id="<?php echo e($fieldname); ?>" class="form-group<?php echo e($errors->has($fieldname) ? ' has-error' : ''); ?>">
        <label for="<?php echo e($fieldname); ?>" class="col-md-3 control-label"><?php echo e($translated_name); ?></label>
        <div class="col-md-8">
            <select class="js-data-ajax" data-endpoint="companies" data-placeholder="<?php echo e(trans('general.select_company')); ?>" name="<?php echo e($fieldname); ?>" style="width: 100%" id="company_select"<?php echo e((isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : ''); ?>>
                <?php if(isset($selected)): ?>
                    <?php $__currentLoopData = $selected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($company_id); ?>" selected="selected" role="option" aria-selected="true">
                            <?php echo e(\App\Models\Company::find($company_id)->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <?php if($company_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : '')): ?>
                    <option value="<?php echo e($company_id); ?>" selected="selected">
                        <?php echo e((\App\Models\Company::find($company_id)) ? \App\Models\Company::find($company_id)->name : ''); ?>

                    </option>
                <?php else: ?>
                    <?php echo (!isset($multiple) || ($multiple=='false')) ? '<option value="" role="option">'.trans('general.select_company').'</option>' : ''; ?>

                <?php endif; ?>
            </select>
        </div>
        <?php echo $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fas fa-times" aria-hidden="true"></i> :message</span></div>'); ?>


    </div>

<?php endif; ?>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/company-select.blade.php ENDPATH**/ ?>
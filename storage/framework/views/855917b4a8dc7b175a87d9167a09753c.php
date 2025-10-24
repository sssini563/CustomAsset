<!-- Purchase Cost -->
<div class="form-group <?php echo e($errors->has('purchase_cost') ? ' has-error' : ''); ?>">
    <label for="purchase_cost" class="col-md-3 control-label"><?php echo e($unit_cost ?? trans('general.purchase_cost')); ?></label>
    <div class="col-md-9">
        <div class="input-group col-md-5" style="padding-left: 0px;">
            <input class="form-control" type="number" name="purchase_cost" min="0.00" max="99999999999999999.000" step="0.001" aria-label="purchase_cost" id="purchase_cost" value="<?php echo e(old('purchase_cost', $item->purchase_cost)); ?>" maxlength="25" />
            <span class="input-group-addon">
                <?php if(isset($currency_type)): ?>
                    <?php echo e($currency_type); ?>

                <?php else: ?>
                    <?php echo e($snipeSettings->default_currency); ?>

                <?php endif; ?>
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            <?php echo $errors->first('purchase_cost', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

        </div>
    </div>

</div>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/purchase_cost.blade.php ENDPATH**/ ?>
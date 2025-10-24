<?php if($errors->any()): ?>
<div class="col-md-12" id="error-notification">
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong><?php echo e(trans('general.notification_error')); ?>:</strong>
         <?php echo e(trans('general.notification_error_hint')); ?>

    </div>
</div>

<?php endif; ?>


<?php if($message = session()->get('status')): ?>
    <div class="col-md-12" id="success-notification">
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check faa-pulse animated"></i>
            <strong><?php echo e(trans('general.notification_success')); ?>: </strong>
            <?php echo e($message); ?>

        </div>
    </div>
<?php endif; ?>


<?php if($message = session()->get('success')): ?>
<div class="col-md-12" id="success-notification">
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-check faa-pulse animated"></i>
        <strong><?php echo e(trans('general.notification_success')); ?>: </strong>
        <?php echo e($message); ?>

    </div>
</div>
<?php echo $__env->make('partials.confetti-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if($message = session()->get('success-unescaped')): ?>
    <div class="col-md-12" id="success-notification">
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check faa-pulse animated"></i>
            <strong><?php echo e(trans('general.notification_success')); ?>: </strong>
            <?php echo $message; ?>

        </div>
    </div>
    <?php echo $__env->make('partials.confetti-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php if($assets = session()->get('assets')): ?>
    <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-12" id="multi-error-notification">
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-info-circle faa-pulse animated"></i>
                <strong><?php echo e(trans('general.asset_information')); ?>:</strong>
                <ul>
                    <?php if(isset($asset->model->name)): ?>
                        <li><b><?php echo e(trans('general.model_name')); ?> </b> <?php echo e($asset->model->name); ?></li>
                    <?php endif; ?>
                    <?php if(isset($asset->name)): ?>
                        <li><b><?php echo e(trans('general.asset_name')); ?> </b> <?php echo e($asset->model->name); ?></li>
                    <?php endif; ?>
                    <li><b><?php echo e(trans('general.asset_tag')); ?></b> <?php echo e($asset->asset_tag); ?></li>
                    <?php if(isset($asset->notes)): ?>
                        <li><b><?php echo e(trans('general.notes')); ?></b> <?php echo e($asset->notes); ?></li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if($consumables = session()->get('consumables')): ?>
    <?php $__currentLoopData = $consumables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consumable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-12" id="success-notification">
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-info-circle faa-pulse animated"></i>
                <strong><?php echo e(trans('general.consumable_information')); ?>: </strong>
                <ul><li><b><?php echo e(trans('general.consumable_name')); ?></b> <?php echo e($consumable->name); ?></li></ul>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if($accessories = session()->get('accessories')): ?>
    <?php $__currentLoopData = $accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-12">
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-info-circle faa-pulse animated"></i>
                <strong><?php echo e(trans('general.accessory_information')); ?>:</strong>
                <ul><li><b><?php echo e(trans('general.accessory_name')); ?></b> <?php echo e($accessory->name); ?></li></ul>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if($message = session()->get('error')): ?>
<div class="col-md-12">
    <div class="alert alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong><?php echo e(trans('general.error')); ?>: </strong>
        <?php echo e($message); ?>

    </div>
</div>
<?php endif; ?>


<?php if($messages = session()->get('error_messages')): ?>
<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>        
<div class="col-md-12">
    <div class="alert alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong><?php echo e(trans('general.notification_error')); ?>: </strong>
        <?php echo e($message); ?>

    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if($messages = session()->get('bulk_asset_errors')): ?>
<div class="col-md-12">
    <div class="alert alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong><?php echo e(trans('general.notification_error')); ?>: </strong>
       <?php echo e(trans('general.notification_bulk_error_hint')); ?>

            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php for($x = 0; $x < count($message); $x++): ?>
                <ul>
                    <li><?php echo e($message[$x]); ?></li>
                </ul>
            <?php endfor; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>


<?php if($message = session()->get('warning')): ?>
<div class="col-md-12">
    <div class="alert alert-warning fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong><?php echo e(trans('general.notification_warning')); ?>: </strong>
        <?php echo e($message); ?>

    </div>
</div>
<?php endif; ?>


<?php if($message = session()->get('info')): ?>
<div class="col-md-12">
    <div class="alert alert-info fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-info-circle faa-pulse animated"></i>
        <strong><?php echo e(trans('general.notification_info')); ?>: </strong>
        <?php echo e($message); ?>

    </div>
</div>
<?php endif; ?>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/notifications.blade.php ENDPATH**/ ?>
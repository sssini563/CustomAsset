<!-- begin redirect submit options -->
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'object',
    'object_type' => '',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'object',
    'object_type' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<!-- begin non-ajaxed file listing table -->
<div class="table-responsive">
    <table
            data-columns="<?php echo e(\App\Presenters\UploadedFilesPresenter::dataTableLayout()); ?>"
            data-cookie-id-table="<?php echo e($object_type); ?>-FileUploadsTable"
            data-id-table="<?php echo e($object_type); ?>-FileUploadsTable"
            id="<?php echo e($object_type); ?>-FileUploadsTable"
            data-side-pagination="server"
            data-pagination="true"
            data-sort-order="desc"
            data-sort-name="created_at"
            data-show-custom-view="true"
            data-custom-view="customViewFormatter"
            data-show-custom-view-button="true"
            data-url="<?php echo e(route('api.files.index', ['object_type' => $object_type, 'id' => $object->id])); ?>"
            class="table table-striped snipe-table"
            data-export-options='{
                    "fileName": "export-uploads-<?php echo e(str_slug($object->name)); ?>-<?php echo e(date('Y-m-d')); ?>",
                    "ignoreColumn": ["image","delete","download","icon"]
                    }'>
    </table>

    <?php if (isset($component)) { $__componentOriginal1197806225ccb86fbe1b3848a0f222f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1197806225ccb86fbe1b3848a0f222f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::gallery-card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gallery-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1197806225ccb86fbe1b3848a0f222f6)): ?>
<?php $attributes = $__attributesOriginal1197806225ccb86fbe1b3848a0f222f6; ?>
<?php unset($__attributesOriginal1197806225ccb86fbe1b3848a0f222f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1197806225ccb86fbe1b3848a0f222f6)): ?>
<?php $component = $__componentOriginal1197806225ccb86fbe1b3848a0f222f6; ?>
<?php unset($__componentOriginal1197806225ccb86fbe1b3848a0f222f6); ?>
<?php endif; ?>

</div>



<!-- end non-ajaxed file listing table --><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\app\Providers/../../resources/views/blade/filestable.blade.php ENDPATH**/ ?>
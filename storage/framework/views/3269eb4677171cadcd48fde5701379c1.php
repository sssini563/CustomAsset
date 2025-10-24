<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    // <options> can either be provided as key => value pairs
    // or passed in via the default $slot
    'options',
    'selected' => null,
    'includeEmpty' => false,
    'forLivewire' => false,
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
    // <options> can either be provided as key => value pairs
    // or passed in via the default $slot
    'options',
    'selected' => null,
    'includeEmpty' => false,
    'forLivewire' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<select
    <?php echo e($attributes->class(['select2', 'livewire-select2' => $forLivewire])); ?>

    <?php if($forLivewire): ?> data-livewire-component="<?php echo e($this->getId()); ?>" <?php endif; ?>
>
    <?php if($includeEmpty): ?>
        <option value=""></option>
    <?php endif; ?>
    
    <?php if($slot->isEmpty()): ?>
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($key); ?>" <?php if($selected == $key): echo 'selected'; endif; ?>><?php echo e($value); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
</select>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\app\Providers/../../resources/views/blade/input/select.blade.php ENDPATH**/ ?>
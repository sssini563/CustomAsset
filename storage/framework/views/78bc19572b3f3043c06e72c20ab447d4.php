<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'locale',
    'selected' => null,
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
    'name' => 'locale',
    'selected' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<select
    name="<?php echo e($name); ?>"
    <?php echo e($attributes->merge(['class' => 'select2', 'style' => 'width:100%'])); ?>

    aria-label="<?php echo e($name); ?>"
    data-placeholder="<?php echo e(trans('localizations.select_language')); ?>"
>
    <option value=""  role="option"><?php echo e(trans('localizations.select_language')); ?></option>'
    <?php $__currentLoopData = trans('localizations.languages'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abbr => $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option
            value="<?php echo e($abbr); ?>"
            role="option"
            <?php if($abbr == $selected): echo 'selected'; endif; ?>
            aria-selected="<?php echo e($abbr == $selected ? 'true' : 'false'); ?>"
        >
            <?php echo e($locale); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\app\Providers/../../resources/views/blade/input/locale-select.blade.php ENDPATH**/ ?>
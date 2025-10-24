<?php $__env->startSection('title'); ?>
    <?php echo e(trans('general.dashboard')); ?>

    <?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <?php if($snipeSettings->dashboard_message != ''): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo Helper::parseEscapedMarkedown($snipeSettings->dashboard_message); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="row">
        
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <!-- Assets Card -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <a href="<?php echo e(route('hardware.index')); ?>"
                        style="text-decoration: none !important; border-bottom: none !important;">
                        <div class="dashboard small-box bg-teal">
                            <div class="inner">
                                <h3 style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(number_format(\App\Models\Asset::AssetsForShow()->count())); ?></h3>
                                <p style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(trans('general.assets')); ?></p>
                            </div>
                            <div class="icon" aria-hidden="true">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'assets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'assets']); ?>
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
                            </div>
                            <span class="small-box-footer"
                                style="text-decoration: none !important; border-bottom: none !important;">
                                <?php echo e(trans('general.view_all')); ?>

                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'arrow-circle-right']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'arrow-circle-right']); ?>
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
                            </span>
                        </div>
                    </a>
                </div><!-- ./col -->

                <!-- Licenses Card -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <a href="<?php echo e(route('licenses.index')); ?>" aria-hidden="true"
                        style="text-decoration: none !important; border-bottom: none !important;">
                        <div class="dashboard small-box bg-maroon">
                            <div class="inner">
                                <h3 style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(number_format($counts['license'])); ?></h3>
                                <p style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(trans('general.licenses')); ?></p>
                            </div>
                            <div class="icon" aria-hidden="true">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'licenses']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'licenses']); ?>
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
                            </div>
                            <span class="small-box-footer"
                                style="text-decoration: none !important; border-bottom: none !important;">
                                <?php echo e(trans('general.view_all')); ?>

                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'arrow-circle-right']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'arrow-circle-right']); ?>
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
                            </span>
                        </div>
                    </a>
                </div><!-- ./col -->

                <!-- Accessories Card -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <a href="<?php echo e(route('accessories.index')); ?>"
                        style="text-decoration: none !important; border-bottom: none !important;">
                        <div class="dashboard small-box bg-orange">
                            <div class="inner">
                                <h3 style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(number_format($counts['accessory'])); ?></h3>
                                <p style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(trans('general.accessories')); ?></p>
                            </div>
                            <div class="icon" aria-hidden="true">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'accessories']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'accessories']); ?>
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
                            </div>
                            <span class="small-box-footer"
                                style="text-decoration: none !important; border-bottom: none !important;">
                                <?php echo e(trans('general.view_all')); ?>

                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'arrow-circle-right']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'arrow-circle-right']); ?>
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
                            </span>
                        </div>
                    </a>
                </div><!-- ./col -->

                <!-- Consumables Card -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <a href="<?php echo e(route('consumables.index')); ?>"
                        style="text-decoration: none !important; border-bottom: none !important;">
                        <div class="dashboard small-box bg-purple">
                            <div class="inner">
                                <h3 style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(number_format($counts['consumable'])); ?></h3>
                                <p style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(trans('general.consumables')); ?></p>
                            </div>
                            <div class="icon" aria-hidden="true">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'consumables']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'consumables']); ?>
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
                            </div>
                            <span class="small-box-footer"
                                style="text-decoration: none !important; border-bottom: none !important;">
                                <?php echo e(trans('general.view_all')); ?>

                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'arrow-circle-right']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'arrow-circle-right']); ?>
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
                            </span>
                        </div>
                    </a>
                </div><!-- ./col -->

                <!-- Components Card -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <a href="<?php echo e(route('components.index')); ?>"
                        style="text-decoration: none !important; border-bottom: none !important;">
                        <div class="dashboard small-box bg-yellow">
                            <div class="inner">
                                <h3 style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(number_format($counts['component'])); ?></h3>
                                <p style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(trans('general.components')); ?></p>
                            </div>
                            <div class="icon" aria-hidden="true">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'components']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'components']); ?>
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
                            </div>
                            <span class="small-box-footer"
                                style="text-decoration: none !important; border-bottom: none !important;">
                                <?php echo e(trans('general.view_all')); ?>

                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'arrow-circle-right']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'arrow-circle-right']); ?>
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
                            </span>
                        </div>
                    </a>
                </div><!-- ./col -->

                <!-- People Card -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                    <a href="<?php echo e(route('users.index')); ?>"
                        style="text-decoration: none !important; border-bottom: none !important;">
                        <div class="dashboard small-box bg-blue">
                            <div class="inner">
                                <h3 style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(number_format($counts['user'])); ?></h3>
                                <p style="text-decoration: none !important; border-bottom: none !important;">
                                    <?php echo e(trans('general.people')); ?></p>
                            </div>
                            <div class="icon" aria-hidden="true">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'users']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'users']); ?>
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
                            </div>
                            <span class="small-box-footer"
                                style="text-decoration: none !important; border-bottom: none !important;">
                                <?php echo e(trans('general.view_all')); ?>

                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'arrow-circle-right']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'arrow-circle-right']); ?>
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
                            </span>
                        </div>
                    </a>
                </div><!-- ./col -->
            </div><!-- ./row 6 cards -->
        </div><!-- ./col-lg-4 left -->

        
        <div class="col-lg-3 col-md-3">
            <div class="box" style="height: 370px;">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <?php echo e(\App\Models\Setting::getSettings()->dash_chart_type == 'name' ? trans('general.assets_by_status') : trans('general.assets_by_status_type')); ?>

                    </h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'minus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'minus']); ?>
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
                            <span class="sr-only"><?php echo e(trans('general.collapse')); ?></span>
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body" style="height: 320px; display: flex; align-items: center; justify-content: center;">
                    <div class="chart-responsive" style="width: 100%; height: 100%;">
                        <canvas id="statusPieChart" style="max-height: 280px;"></canvas>
                    </div> <!-- ./chart-responsive -->
                </div><!-- /.box-body -->
            </div> <!-- /.box -->
        </div><!-- ./col-lg-3 middle -->

        
        <div class="col-lg-5 col-md-5">
            <div class="box box-default" style="height: 370px;">
                <div class="box-header with-border" style="padding: 5px 10px;">
                    <h2 class="box-title" style="font-size: 14px; margin: 0; line-height: 1.4; font-weight: 600;">
                        <?php echo e(trans('general.asset')); ?>

                        <?php echo e(trans('general.categories')); ?></h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'minus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'minus']); ?>
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
                            <span class="sr-only"><?php echo e(trans('general.collapse')); ?></span>
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body" style="height: 320px; overflow: auto; padding: 3px;">
                    <div class="table-responsive">
                        <table data-cookie-id-table="dashCategorySummary" data-height="280" data-pagination="false"
                            data-side-pagination="server" data-sort-order="desc" data-sort-field="assets_count"
                            id="dashCategorySummary" class="table table-striped snipe-table table-condensed"
                            data-url="<?php echo e(route('api.categories.index', ['sort' => 'assets_count', 'order' => 'asc'])); ?>"
                            style="font-size: 11px; margin-bottom: 0;">
                            <thead>
                                <tr>
                                    <th class="col-sm-4" data-visible="true" data-field="name"
                                        data-formatter="categoriesLinkFormatter" data-sortable="true"
                                        style="padding: 4px 6px;">
                                        <?php echo e(trans('general.name')); ?></th>
                                    <th class="col-sm-3" data-visible="true" data-field="category_type"
                                        data-sortable="true" style="padding: 4px 6px;"><?php echo e(trans('general.type')); ?></th>
                                    <th class="col-sm-1" data-visible="true" data-field="assets_count"
                                        data-sortable="true" style="padding: 4px 6px;">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'assets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'assets']); ?>
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
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="accessories_count"
                                        data-sortable="true" style="padding: 4px 6px;">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'accessories']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'accessories']); ?>
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
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="consumables_count"
                                        data-sortable="true" style="padding: 4px 6px;">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'consumables']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'consumables']); ?>
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
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="components_count"
                                        data-sortable="true" style="padding: 4px 6px;">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'components']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'components']); ?>
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
                                    </th>
                                    <th class="col-sm-1" data-visible="true" data-field="licenses_count"
                                        data-sortable="true" style="padding: 4px 6px;">
                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'licenses']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'licenses']); ?>
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
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- /.responsive -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- ./col-lg-5 right -->
    </div><!-- ./row 1 -->

    
    <?php if($counts['grand_total'] > 0): ?>
        <div class="row">
            
            <div class="col-lg-6 col-md-6">
                <div class="box">
                    <div class="box-header with-border" style="padding: 5px 10px;">
                        <h2 class="box-title" style="font-size: 14px; margin: 0; line-height: 1.4; font-weight: 600;">
                            <?php echo e(trans('general.recent_activity')); ?>

                        </h2>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'minus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'minus']); ?>
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
                                <span class="sr-only"><?php echo e(trans('general.collapse')); ?></span>
                            </button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="padding: 3px;">
                        <div class="table-responsive">
                            <table data-cookie-id-table="dashActivityReport" data-height="350" data-pagination="false"
                                data-side-pagination="server" data-sort-order="desc" data-sort-field="created_at"
                                id="dashActivityReport" class="table table-striped snipe-table table-condensed"
                                data-url="<?php echo e(route('api.activity.index', ['limit' => 15, 'order' => 'desc'])); ?>"
                                style="font-size: 11px; margin-bottom: 0;">
                                <thead>
                                    <tr>
                                        <th class="col-sm-2" data-visible="true" data-field="icon"
                                            data-formatter="iconFormatter" style="padding: 4px 6px;"></th>
                                        <th class="col-sm-3" data-visible="true" data-field="created_at"
                                            data-formatter="dateDisplayFormatter" data-sortable="true"
                                            style="padding: 4px 6px;"><?php echo e(trans('general.date')); ?></th>
                                        <th class="col-sm-2" data-visible="true" data-field="admin"
                                            data-formatter="usersLinkObjFormatter" data-sortable="true"
                                            style="padding: 4px 6px;"><?php echo e(trans('general.admin')); ?></th>
                                        <th class="col-sm-2" data-visible="true" data-field="action_type"
                                            data-sortable="true" style="padding: 4px 6px;"><?php echo e(trans('general.action')); ?>

                                        </th>
                                        <th class="col-sm-3" data-visible="true" data-field="item"
                                            data-formatter="polymorphicItemFormatter" data-sortable="false"
                                            style="padding: 4px 6px;"><?php echo e(trans('general.item')); ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div><!-- /.responsive -->
                    </div><!-- /.box-body -->
                </div> <!-- /.box -->
            </div><!-- ./col recent activity -->

            
            <div class="col-lg-6 col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border" style="padding: 5px 10px;">
                        <h2 class="box-title" style="font-size: 14px; margin: 0; line-height: 1.4; font-weight: 600;">
                            <?php echo e(trans('general.locations')); ?></h2>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'minus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'minus']); ?>
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
                                <span class="sr-only"><?php echo e(trans('general.collapse')); ?></span>
                            </button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="padding: 3px;">
                        <div class="table-responsive">
                            <table data-cookie-id-table="dashLocationSummary" data-height="350"
                                data-side-pagination="server" data-pagination="false" data-sort-order="desc"
                                data-sort-field="assets_count" id="dashLocationSummary"
                                class="table table-striped snipe-table table-condensed"
                                data-url="<?php echo e(route('api.locations.index', ['sort' => 'assets_count', 'order' => 'asc'])); ?>"
                                style="font-size: 11px; margin-bottom: 0;">
                                <thead>
                                    <tr>
                                        <th class="col-sm-6" data-visible="true" data-field="name"
                                            data-formatter="locationsLinkFormatter" data-sortable="true"
                                            style="padding: 4px 6px;">
                                            <?php echo e(trans('general.name')); ?></th>
                                        <th class="col-sm-2" data-visible="true" data-field="assets_count"
                                            data-sortable="true" style="padding: 4px 6px;">
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'assets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'assets']); ?>
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
                                        </th>
                                        <th class="col-sm-2" data-visible="true" data-field="assigned_assets_count"
                                            data-sortable="true" style="padding: 4px 6px;">
                                            <?php echo e(trans('general.assigned')); ?>

                                        </th>
                                        <th class="col-sm-2" data-visible="true" data-field="users_count"
                                            data-sortable="true" style="padding: 4px 6px;">
                                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'users']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'users']); ?>
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
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div><!-- /.responsive -->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- ./col locations -->
        </div><!-- ./row 2 -->
    <?php endif; ?>

    <?php if($counts['grand_total'] == 0): ?>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h2 class="box-title"><?php echo e(trans('general.dashboard_info')); ?></h2>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="progress">
                                    <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="60"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span class="sr-only"><?php echo e(trans('general.60_percent_warning')); ?></span>
                                    </div>
                                </div>


                                <p><strong><?php echo e(trans('general.dashboard_empty')); ?></strong></p>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Asset::class)): ?>
                                    <a class="btn bg-teal" style="width: 100%"
                                        href="<?php echo e(route('hardware.create')); ?>"><?php echo e(trans('general.new_asset')); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\License::class)): ?>
                                    <a class="btn bg-maroon" style="width: 100%"
                                        href="<?php echo e(route('licenses.create')); ?>"><?php echo e(trans('general.new_license')); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Accessory::class)): ?>
                                    <a class="btn bg-orange" style="width: 100%"
                                        href="<?php echo e(route('accessories.create')); ?>"><?php echo e(trans('general.new_accessory')); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Consumable::class)): ?>
                                    <a class="btn bg-purple" style="width: 100%"
                                        href="<?php echo e(route('consumables.create')); ?>"><?php echo e(trans('general.new_consumable')); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Component::class)): ?>
                                    <a class="btn btn-warning-modern"
                                        style="width: 100%; background: linear-gradient(135deg, #FFB74D 0%, #FFA726 100%); color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 500;"
                                        href="<?php echo e(route('components.create')); ?>"><?php echo e(trans('general.new_component')); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\User::class)): ?>
                                    <a class="btn btn-info-modern"
                                        style="width: 100%; background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%); color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 500;"
                                        href="<?php echo e(route('users.create')); ?>"><?php echo e(trans('general.new_user')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        </div> <!--/row-->
        <div class="row">
            <div class="col-md-6">

                <?php if($snipeSettings->scope_locations_fmcs != '1' && $snipeSettings->full_multiple_companies_support == '1'): ?>
                    <!-- Companies -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h2 class="box-title"><?php echo e(trans('general.companies')); ?></h2>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'minus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'minus']); ?>
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
                                    <span class="sr-only"><?php echo e(trans('general.collapse')); ?></span>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table data-cookie-id-table="dashCompanySummary" data-height="400"
                                            data-pagination="false" data-side-pagination="server" data-sort-order="desc"
                                            data-sort-field="assets_count" id="dashCompanySummary"
                                            class="table table-striped snipe-table"
                                            data-url="<?php echo e(route('api.companies.index', ['sort' => 'assets_count', 'order' => 'asc'])); ?>">

                                            <thead>
                                                <tr>
                                                    <th class="col-sm-3" data-visible="true" data-field="name"
                                                        data-formatter="companiesLinkFormatter" data-sortable="true">
                                                        <?php echo e(trans('general.name')); ?></th>
                                                    <th class="col-sm-1" data-visible="true" data-field="users_count"
                                                        data-sortable="true">
                                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'users']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'users']); ?>
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
                                                        <span class="sr-only"><?php echo e(trans('general.people')); ?></span>
                                                    </th>
                                                    <th class="col-sm-1" data-visible="true" data-field="assets_count"
                                                        data-sortable="true">
                                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'assets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'assets']); ?>
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
                                                        <span class="sr-only"><?php echo e(trans('general.asset_count')); ?></span>
                                                    </th>
                                                    <th class="col-sm-1" data-visible="true"
                                                        data-field="accessories_count" data-sortable="true">
                                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'accessories']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'accessories']); ?>
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
                                                        <span
                                                            class="sr-only"><?php echo e(trans('general.accessories_count')); ?></span>
                                                    </th>
                                                    <th class="col-sm-1" data-visible="true"
                                                        data-field="consumables_count" data-sortable="true">
                                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'consumables']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'consumables']); ?>
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
                                                        <span
                                                            class="sr-only"><?php echo e(trans('general.consumables_count')); ?></span>
                                                    </th>
                                                    <th class="col-sm-1" data-visible="true"
                                                        data-field="components_count" data-sortable="true">
                                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'components']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'components']); ?>
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
                                                        <span
                                                            class="sr-only"><?php echo e(trans('general.components_count')); ?></span>
                                                    </th>
                                                    <th class="col-sm-1" data-visible="true" data-field="licenses_count"
                                                        data-sortable="true">
                                                        <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'licenses']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'licenses']); ?>
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
                                                        <span class="sr-only"><?php echo e(trans('general.licenses_count')); ?></span>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div> <!-- /.col -->
                                <div class="text-center col-md-12" style="padding-top: 10px;">
                                    <a href="<?php echo e(route('companies.index')); ?>" class="btn btn-primary btn-sm"
                                        style="width: 100%"><?php echo e(trans('general.viewall')); ?></a>
                                </div>
                            </div> <!-- /.row -->

                        </div><!-- /.box-body -->
                    </div> <!-- /.box -->
                <?php endif; ?>

            </div>


    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>
    <?php echo $__env->make('partials.bootstrap-table', ['simple_view' => true, 'nopages' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <style>
        /* Compact table styling for dashboard */
        #dashCategorySummary .fixed-table-toolbar,
        #dashActivityReport .fixed-table-toolbar,
        #dashLocationSummary .fixed-table-toolbar {
            padding: 1px 3px !important;
            min-height: 22px !important;
            margin-bottom: 2px !important;
        }

        #dashCategorySummary .search input,
        #dashActivityReport .search input,
        #dashLocationSummary .search input {
            height: 20px !important;
            font-size: 9px !important;
            padding: 1px 4px !important;
            width: 120px !important;
        }

        #dashCategorySummary .fixed-table-toolbar .btn-group button,
        #dashActivityReport .fixed-table-toolbar .btn-group button,
        #dashLocationSummary .fixed-table-toolbar .btn-group button {
            padding: 1px 3px !important;
            font-size: 9px !important;
            height: 20px !important;
            line-height: 1 !important;
        }

        #dashCategorySummary .fixed-table-toolbar .btn-group button i,
        #dashActivityReport .fixed-table-toolbar .btn-group button i,
        #dashLocationSummary .fixed-table-toolbar .btn-group button i {
            font-size: 9px !important;
        }

        #dashCategorySummary tbody td,
        #dashActivityReport tbody td,
        #dashLocationSummary tbody td {
            padding: 2px 4px !important;
            font-size: 9px !important;
            line-height: 1.2 !important;
        }

        #dashCategorySummary thead th,
        #dashActivityReport thead th,
        #dashLocationSummary thead th {
            padding: 2px 4px !important;
            font-size: 9px !important;
            line-height: 1.2 !important;
        }

        #dashCategorySummary .fixed-table-container,
        #dashActivityReport .fixed-table-container,
        #dashLocationSummary .fixed-table-container {
            border: none !important;
            padding: 0 !important;
        }

        /* Remove extra spacing */
        #dashCategorySummary .fixed-table-toolbar .columns,
        #dashActivityReport .fixed-table-toolbar .columns,
        #dashLocationSummary .fixed-table-toolbar .columns {
            margin-right: 1px !important;
        }

        /* Compact toolbar buttons */
        #dashCategorySummary .fixed-table-toolbar .pull-right,
        #dashActivityReport .fixed-table-toolbar .pull-right,
        #dashLocationSummary .fixed-table-toolbar .pull-right {
            margin-left: 2px !important;
        }

        #dashCategorySummary .fixed-table-toolbar .pull-left,
        #dashActivityReport .fixed-table-toolbar .pull-left,
        #dashLocationSummary .fixed-table-toolbar .pull-left {
            margin-right: 2px !important;
        }

        /* Make search form more compact */
        #dashCategorySummary .search,
        #dashActivityReport .search,
        #dashLocationSummary .search {
            margin-bottom: 0 !important;
            margin-top: 0 !important;
        }

        /* Remove spacing from button groups */
        #dashCategorySummary .fixed-table-toolbar .btn-group,
        #dashActivityReport .fixed-table-toolbar .btn-group,
        #dashLocationSummary .fixed-table-toolbar .btn-group {
            margin-left: 1px !important;
            margin-right: 1px !important;
        }

        /* Compact table body */
        #dashCategorySummary .fixed-table-body,
        #dashActivityReport .fixed-table-body,
        #dashLocationSummary .fixed-table-body {
            padding: 0 !important;
        }

        /* Reduce spacing between header and toolbar */
        #dashCategorySummary .fixed-table-toolbar::before,
        #dashActivityReport .fixed-table-toolbar::before,
        #dashLocationSummary .fixed-table-toolbar::before {
            display: none !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(url(mix('js/dist/Chart.min.js'))); ?>"></script>
    <script nonce="<?php echo e(csrf_token()); ?>">
        // ---------------------------
        // - ASSET STATUS CHART -
        // ---------------------------
        var pieChartCanvas = $("#statusPieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var ctx = document.getElementById("statusPieChart");
        var pieOptions = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'top',
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        counts = data.datasets[0].data;
                        total = 0;
                        for (var i in counts) {
                            total += counts[i];
                        }
                        prefix = data.labels[tooltipItem.index] || '';
                        return prefix + " " + Math.round(counts[tooltipItem.index] / total * 100) + "%";
                    }
                }
            }
        };

        $.ajax({
            type: 'GET',
            url: '<?php echo e(\App\Models\Setting::getSettings()->dash_chart_type == 'name' ? route('api.statuslabels.assets.byname') : route('api.statuslabels.assets.bytype')); ?>',
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: pieOptions
                });
            },
            error: function(data) {
                // window.location.reload(true);
            },
        });
        // Removed resize listener to prevent height changes on screen resize
    </script>

    <script nonce="<?php echo e(csrf_token()); ?>">
        // Force compact toolbar styling after bootstrap-table renders
        $(document).ready(function() {
            // Wait for tables to initialize
            setTimeout(function() {
                // Target all dashboard tables
                var tables = ['#dashCategorySummary', '#dashActivityReport', '#dashLocationSummary'];

                tables.forEach(function(tableId) {
                    // Make search input compact (ukuran sedang)
                    $(tableId).closest('.bootstrap-table').find('.search input').attr('style',
                        'height: 22px !important; font-size: 10px !important; padding: 2px 6px !important; width: 130px !important; border-radius: 4px !important;'
                    );

                    // Make all toolbar buttons compact (ukuran sedang)
                    $(tableId).closest('.bootstrap-table').find('.fixed-table-toolbar button').attr(
                        'style',
                        'padding: 2px 5px !important; font-size: 10px !important; height: 22px !important; line-height: 1.1 !important; min-width: 22px !important;'
                    );

                    // Make button icons compact (ukuran sedang)
                    $(tableId).closest('.bootstrap-table').find('.fixed-table-toolbar button i')
                        .attr('style',
                            'font-size: 10px !important; line-height: 1.1 !important;'
                        );

                    // Make dropdown toggles compact (ukuran sedang)
                    $(tableId).closest('.bootstrap-table').find(
                        '.fixed-table-toolbar .dropdown-toggle').attr('style',
                        'padding: 2px 5px !important; height: 22px !important; font-size: 10px !important;'
                    );

                    // Compact toolbar (ukuran sedang)
                    $(tableId).closest('.bootstrap-table').find('.fixed-table-toolbar').attr(
                        'style',
                        'padding: 2px 5px !important; min-height: 26px !important; margin-bottom: 2px !important;'
                    );
                });
            }, 500);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/dashboard.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>

    <form role="form" action="<?php echo e(url('/login')); ?>" method="POST" autocomplete="<?php echo e((config('auth.login_autocomplete') === true) ? 'on' : 'off'); ?>">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />


        <!-- this is a hack to prevent Chrome from trying to autocomplete fields -->
        <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" aria-hidden="true">
        <input type="password" name="password_fake" id="password_fake" value="" style="display:none;" aria-hidden="true">

        <div class="container">
            <div class="row">

                <div class="col-md-4 col-md-offset-4">

                    <?php if(($snipeSettings->google_login=='1') && ($snipeSettings->google_client_id!='') && ($snipeSettings->google_client_secret!='')): ?>

                        <br><br>
                        <a href="<?php echo e(route('google.redirect')); ?>" class="btn btn-block btn-social btn-google btn-lg">
                            <i class="fa-brands fa-google"></i>
                            <?php echo e(trans('auth/general.google_login')); ?>

                        </a>

                        <div class="separator"><?php echo e(strtoupper(trans('general.or'))); ?></div>
                    <?php endif; ?>


                    <div class="box login-box">
                        <div class="box-header with-border">
                            <h1 class="box-title"> <?php echo e(trans('auth/general.login_prompt')); ?></h1>
                        </div>


                        <div class="login-box-body">
                            <div class="row">

                                <?php if($snipeSettings->login_note): ?>
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <?php echo Helper::parseEscapedMarkedown($snipeSettings->login_note); ?>

                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Notifications -->
                                <?php echo $__env->make('notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                <?php if(!config('app.require_saml')): ?>
                                <div class="col-md-12">
                                    <!-- CSRF Token -->


                                    <fieldset name="login" aria-label="login">

                                        <div class="form-group<?php echo e($errors->has('username') ? ' has-error' : ''); ?>">
                                            <label for="username">
                                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f76d7e2a0d8b0621e4effea0def75119::icon','data' => ['type' => 'user']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'user']); ?>
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
                                                <?php echo e(trans('admin/users/table.username')); ?>

                                            </label>
                                            <input class="form-control" placeholder="<?php echo e(trans('admin/users/table.username')); ?>" name="username" type="text" id="username" autocomplete="<?php echo e((config('auth.login_autocomplete') === true) ? 'on' : 'off'); ?>" autofocus>
                                            <?php echo $errors->first('username', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

                                        </div>
                                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                            <label for="password">
                                                <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f76d7e2a0d8b0621e4effea0def75119::icon','data' => ['type' => 'password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password']); ?>
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
                                                <?php echo e(trans('admin/users/table.password')); ?>

                                            </label>
                                            <input class="form-control" placeholder="<?php echo e(trans('admin/users/table.password')); ?>" name="password" type="password" id="password" autocomplete="<?php echo e((config('auth.login_autocomplete') === true) ? 'on' : 'off'); ?>">
                                            <?php echo $errors->first('password', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

                                        </div>
                                        <div class="form-group">
                                            <label class="form-control">
                                                <input name="remember" type="checkbox" value="1" id="remember"> <?php echo e(trans('auth/general.remember_me')); ?>

                                            </label>
                                        </div>
                                    </fieldset>
                                </div> <!-- end col-md-12 -->
                                <?php endif; ?>
                            </div> <!-- end row -->

                            <?php if(!config('app.require_saml') && $snipeSettings->saml_enabled): ?>
                            <div class="row">
                                <div class="text-right col-md-12">
                                    <a href="<?php echo e(route('saml.login')); ?>"><?php echo e(trans('auth/general.saml_login')); ?></a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="box-footer">
                            <?php if(config('app.require_saml')): ?>
                                <a class="btn btn-primary btn-block" href="<?php echo e(route('saml.login')); ?>"><?php echo e(trans('auth/general.saml_login')); ?></a>
                            <?php else: ?>
                                <button class="btn btn-primary btn-block" type="submit" id="submit">
                                    <?php echo e(trans('auth/general.login')); ?>

                                </button>
                            <?php endif; ?>

                            <?php if($snipeSettings->custom_forgot_pass_url): ?>
                                <div class="col-md-12 text-right" style="padding-top: 15px;">
                                    <a href="<?php echo e($snipeSettings->custom_forgot_pass_url); ?>" rel="noopener"><?php echo e(trans('auth/general.forgot_password')); ?></a>
                                </div>
                            <?php elseif(!config('app.require_saml')): ?>
                                <div class="col-md-12 text-right" style="padding-top: 15px;">
                                    <a href="<?php echo e(route('password.request')); ?>"><?php echo e(trans('auth/general.forgot_password')); ?></a>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div> <!-- end login box -->


                </div> <!-- col-md-4 -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/basic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>
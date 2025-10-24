<?php $__env->startSection('title'); ?>
	<?php if($user->id): ?>
		<?php echo e(trans('admin/users/table.updateuser')); ?>

		<?php echo e($user->display_name); ?>

	<?php else: ?>
		<?php echo e(trans('admin/users/table.createuser')); ?>

	<?php endif; ?>

<?php echo \Illuminate\View\Factory::parentPlaceholder('title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header_right'); ?>
<a href="<?php echo e(URL::previous()); ?>" class="btn btn-primary pull-right">
  <?php echo e(trans('general.back')); ?></a>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<style>
    .form-horizontal .control-label {
      padding-top: 0px;
    }

    input[type='text'][disabled], input[disabled], textarea[disabled], input[readonly], textarea[readonly], .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
      background-color: white;
      color: #555555;
      cursor:text;
    }
    table.permissions {
      display:flex;
      flex-direction: column;
    }

    .permissions.table > thead, .permissions.table > tbody {
      margin: 15px;
      margin-top: 0px;
    }

    .permissions.table > tbody {
        border: 1px solid;
    }

    .header-row {
      border-bottom: 1px solid #ccc;
    }

    .permissions-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .table > tbody > tr > td.permissions-item {
      padding: 1px;
      padding-left: 8px;
    }

    .header-name {
      cursor: pointer;
    }

</style>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
      <form class="form-horizontal" method="post" autocomplete="off"
            action="<?php echo e((isset($user->id)) ? route('users.update', ['user' => $user->id]) : route('users.store')); ?>"
            enctype="multipart/form-data" id="userForm">
      <?php echo e(csrf_field()); ?>


      <?php if($user->id): ?>
          <?php echo e(method_field('PUT')); ?>

      <?php endif; ?>
        <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#info" data-toggle="tab"><?php echo e(trans('general.information')); ?> </a></li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                <li><a href="#permissions" data-toggle="tab"><?php echo e(trans('general.permissions')); ?> </a></li>
            <?php endif; ?>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="info">
            <div class="row">
              <div class="col-md-12">
                <!-- First Name -->
                 <?php echo $__env->make('partials.forms.edit.name-first', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <!-- Last Name -->
                <?php echo $__env->make('partials.forms.edit.name-last', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <!-- Username -->
                <div class="form-group <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">

                  <label class="col-md-3 control-label" for="username">
                      <?php echo e(trans('admin/users/table.username')); ?>

                  </label>

                  <div class="col-md-6">
                      <input type="hidden" name="username" value="<?php echo e(old('username', $user->username)); ?>">
                    <!-- if the user is not managed by LDAP, or this is a clone operation, allow editing of the username -->
                          <?php if($user->ldap_import!='1' || str_contains(Route::currentRouteName(), 'clone')): ?>
                              <input class="form-control" type="text" name="username" id="username" value="<?php echo e(old('username', $user->username)); ?>" autocomplete="off" maxlength="191" <?php echo e((Helper::checkIfRequired($user, 'username')) ? ' required' : ''); ?> onfocus="this.removeAttribute('readonly');" readonly <?php echo (!Gate::allows('canEditAuthFields', $user)) || ((!Gate::allows('editableOnDemo')) && ($user->id)) ? ' style="cursor: not-allowed" disabled ' : ''; ?>>
                          <?php else: ?>

                              <!-- insert the old username so we don't break validation -->
                              <p class="help-block">
                                  <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                                  <?php echo e(trans('general.managed_ldap')); ?>

                              </p>
                              <input type="hidden" name="username" value="<?php echo e(old('username', $user->username)); ?>">
                          <?php endif; ?>

                         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('canEditAuthFields', $user)): ?>
                          <p class="help-block">
                              <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                              <?php echo e(trans('general.action_permission_generic', ['action' => trans('general.edit'), 'item_type' => trans('general.username')])); ?>

                          </p>
                      <?php endif; ?>
                  </div> <!--/col-md-6-->


                <?php if(!Gate::allows('editableOnDemo') && ($user->id)): ?>
                    <!-- disallow changing existing usernames on the demo -->
                    <div class="col-md-8 col-md-offset-3">
                        <p class="text-warning">
                            <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                            <?php echo e(trans('admin/users/table.lock_passwords')); ?>

                        </p>
                    </div>
                <?php endif; ?>

                <?php if($errors->first('username')): ?>
                    <div class="col-md-8 col-md-offset-3">
                        <?php echo $errors->first('username', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                    </div>
                <?php endif; ?>

                </div>

                <!-- Password -->
                <div class="form-group <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">

                  <label class="col-md-3 control-label" for="password">
                    <?php echo e(trans('admin/users/table.password')); ?>

                  </label>

                  <div class="col-md-6">
                        <?php if($user->ldap_import!='1' || str_contains(Route::currentRouteName(), 'clone') ): ?>
                          <input type="password" name="password" class="form-control<?php echo e((!Gate::allows('canEditAuthFields', $user)) || ((!Gate::allows('editableOnDemo') && ($user->id))) ? ' form-control--disabled' : ''); ?>" id="password" value="" maxlength="500" autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly <?php echo e(((Helper::checkIfRequired($user, 'password')) && (!$user->id)) ? ' required' : ''); ?><?php echo (!Gate::allows('canEditAuthFields', $user)) || ((!Gate::allows('editableOnDemo')) && ($user->id)) ? ' style="cursor: not-allowed" disabled ' : ''; ?>>
                              <span id="generated-password"></span>
                              <?php echo $errors->first('password', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                        <?php else: ?>
                              <p class="form-control-static">
                              <?php echo e(trans('general.managed_ldap')); ?>

                              </p>
                        <?php endif; ?>

                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('canEditAuthFields', $user)): ?>
                          <p class="help-block">
                              <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                              <?php echo e(trans('general.action_permission_generic', ['action' => trans('general.edit'), 'item_type' => trans('general.password')])); ?>

                          </p>
                      <?php endif; ?>

                      <?php if(!Gate::allows('editableOnDemo') && ($user->id)): ?>
                          <p class="text-warning">
                              <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                              <?php echo e(trans('admin/users/table.lock_passwords')); ?>

                          </p>
                      <?php endif; ?>

                  </div>

                  <div class="col-md-2">

                    <?php if(Gate::allows('editableOnDemo') && (Gate::allows('canEditAuthFields', $user)) && ($user->ldap_import!='1')): ?>
                      <a href="#" class="left" id="genPassword"><?php echo e(trans('general.generate')); ?></a>
                    <?php endif; ?>
                  </div>
                </div>

                <?php if(($user->ldap_import!='1') || str_contains(Route::currentRouteName(), 'clone')): ?>
                    <!-- Password Confirm -->
                    <div class="form-group <?php echo e($errors->has('password_confirmation') ? 'has-error' : ''); ?>">
                      <label class="col-md-3 control-label" for="password_confirmation">
                        <?php echo e(trans('admin/users/table.password_confirm')); ?>

                      </label>
                      <div class="col-md-6">
                        <input type="password" name="password_confirmation" id="password_confirm" class="form-control" value="" maxlength="500" autocomplete="off" aria-label="password_confirmation" <?php echo e((!$user->id) ? ' required' : ''); ?> onfocus="this.removeAttribute('readonly');" readonly <?php echo (!Gate::allows('canEditAuthFields', $user)) || ((!Gate::allows('editableOnDemo')) && ($user->id)) ? ' style="cursor: not-allowed" disabled ' : ''; ?>>

                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('canEditAuthFields', $user)): ?>
                          <p class="help-block">
                              <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                              <?php echo e(trans('general.action_permission_generic', ['action' => trans('general.edit'), 'item_type' => trans('general.password')])); ?>

                          </p>
                      <?php endif; ?>

                        <?php if(!Gate::allows('editableOnDemo') && ($user->id)): ?>
                              <p class="text-warning">
                                  <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                                <?php echo e(trans('admin/users/table.lock_passwords')); ?>

                              </p>
                        <?php endif; ?>
                        <?php echo $errors->first('password_confirmation', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                      </div>
                    </div>
                <?php endif; ?>

              <!-- Activation Status (Can the user login?) -->
                  <div class="form-group <?php echo e($errors->has('activated') ? 'has-error' : ''); ?>">
                          <div class="col-md-9 col-md-offset-3">

                              <!-- disallow changes to the user's login status -->
                              <?php if(((!Gate::allows('editableOnDemo'))  && ($user->id)) || (!Gate::allows('canEditAuthFields', $user)) || ($user->id == auth()->user()->id)): ?>
                                  <!-- demo mode - disallow changes -->
                                  <label class="form-control form-control--disabled">
                                      <input type="checkbox" value="1" name="activated" class="disabled" <?php echo e((old('activated', $user->activated)) == '1' ? ' checked="checked"' : ''); ?> disabled aria-label="activated">
                                      <?php echo e(trans('admin/users/general.activated_help_text')); ?>

                                  </label>

                                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('canEditAuthFields', $user)): ?>
                                  <!-- authed user is an admin or regular user and is trying to edit someone higher -->
                                      <p class="help-block">
                                      <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                                          <?php echo e(trans('general.action_permission_generic', ['action' => trans('general.edit'), 'item_type' => trans('general.login_status')])); ?>

                                  </p>
                                  <?php endif; ?>

                                  <?php if((auth()->user()->cannot('editableOnDemo')) && ($user->id)): ?>
                                      <!-- app is locked -->
                                      <p class="text-warning">
                                          <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                                          <?php echo e(trans('admin/users/table.lock_passwords')); ?>

                                      </p>
                                  <?php endif; ?>

                                  <?php if($user->id == auth()->user()->id): ?>
                                      <!-- disallow editing activation on your own account -->
                                      <p class="help-block">
                                          <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                                          <?php echo e(trans('admin/users/general.activated_disabled_help_text')); ?>

                                      </p>
                                  <?php endif; ?>

                              <?php else: ?>
                                  <!-- everything is normal - as you were -->
                                  <label class="form-control">
                                      <input type="checkbox" value="1" name="activated"<?php echo e(((old('activated') == '1') || ($user->activated) == '1') ? ' checked="checked"' : ''); ?> aria-label="activated" id="activated">
                                      <?php echo e(trans('admin/users/general.activated_help_text')); ?>

                                  </label>

                              <?php endif; ?>


                          </div>
                  </div>

                  <!-- Email -->
                <div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                  <label class="col-md-3 control-label" for="email"><?php echo e(trans('admin/users/table.email')); ?> </label>
                  <div class="col-md-6">
                        <input class="form-control" type="email" name="email" id="email" maxlength="191" value="<?php echo e(old('email', $user->email)); ?>" autocomplete="off"
                          readonly onfocus="this.removeAttribute('readonly');" <?php echo e((Helper::checkIfRequired($user, 'email')) ? ' required' : ''); ?><?php echo (!Gate::allows('canEditAuthFields', $user)) || ((!Gate::allows('editableOnDemo')) && ($user->id)) ? ' style="cursor: not-allowed" disabled ' : ''; ?>>

                          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('canEditAuthFields', $user)): ?>
                              <!-- authed user is an admin or regular user and is trying to edit someone higher -->
                              <p class="help-block">
                                  <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                                  <?php echo e(trans('general.action_permission_generic', ['action' => trans('general.edit'), 'item_type' => trans('general.email')])); ?>

                              </p>
                          <?php endif; ?>


                            <?php if(!Gate::allows('editableOnDemo') && ($user->id)): ?>
                              <p class="text-warning">
                                  <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                                  <?php echo e(trans('admin/users/table.lock_passwords')); ?>

                              </p>
                          <?php endif; ?>

                        <?php echo $errors->first('email', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>



                  </div>
                </div>

                  <!-- Send welcome email to user -->
                  <?php if(!$user->id): ?>
                      <div class="form-group" id="email_user_row">

                          <div class="col-md-8 col-md-offset-3">
                              <label class="form-control form-control--disabled">
                                  <input
                                      type="checkbox"
                                      name="send_welcome"
                                      id="email_user_checkbox"
                                      value="1"
                                      aria-label="send_welcome"
                                      <?php if(old('send_welcome')): echo 'checked'; endif; ?>
                                  />
                                  <?php echo e(trans('general.send_welcome_email_to_users')); ?>

                              </label>

                              <p class="help-block"> <?php echo e(trans('general.send_welcome_email_help')); ?></p>

                          </div>
                      </div> <!--/form-group-->
                  <?php endif; ?>

                  
                  <?php echo $__env->make('partials.forms.edit.image-upload', ['fieldname' => 'avatar', 'image_path' => app('users_upload_path')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


                  <!-- begin optional disclosure arrow stuff -->

                      <div class="col-md-12">

                      <fieldset name="optional-details">

                          <legend class="highlight">
                              <a id="optional_user_info">
                                  <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'caret-right','id' => 'optional_user_info_icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'caret-right','id' => 'optional_user_info_icon']); ?>
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
                                  <?php echo e(trans('admin/hardware/form.optional_infos')); ?>

                              </a>
                          </legend>

                          <div id="optional_user_details" class="col-md-12" style="display:none">



                              <!-- everything here should be what is considered optional -->
                              <br>

                              <!-- Display Name -->
                              <div class="form-group <?php echo e($errors->has('display_name') ? 'has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="display_name"><?php echo e(trans('admin/users/table.display_name')); ?></label>
                                  <div class="col-md-6">
                                      <input
                                              class="form-control"
                                              type="text"
                                              maxlength="191"
                                              name="display_name"
                                              id="display_name"
                                              value="<?php echo e(old('display_name', $user->getRawOriginal('display_name'))); ?>"
                                      />
                                      <?php echo $errors->first('display_name', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>


                              <!-- Company -->
                              <?php if((Gate::allows('canEditAuthFields', $user)) && (\App\Models\Company::canManageUsersCompanies())): ?>
                                  <?php echo $__env->make('partials.forms.edit.company-select', ['translated_name' => trans('general.select_company'), 'fieldname' => 'company_id'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                              <?php else: ?>
                                  <?php if($user->company): ?>
                                      <div class="form-group">
                                          <label class="col-md-3 control-label" for="locale"><?php echo e(trans('general.company')); ?></label>
                                          <div class="col-md-6">
                                              <p class="form-control-static">
                                                  <?php echo e($user->company ? $user->company->name : ''); ?>

                                              </p>
                                          </div>
                                      </div>
                                  <?php endif; ?>
                              <?php endif; ?>


                              <!-- language -->
                              <div class="form-group <?php echo e($errors->has('locale') ? 'has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="locale"><?php echo e(trans('general.language')); ?></label>
                                  <div class="col-md-6">
                                      <?php if (isset($component)) { $__componentOriginal7d0a682e0815be85aedd9fbba1a53208 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d0a682e0815be85aedd9fbba1a53208 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::input.locale-select','data' => ['name' => 'locale','selected' => old('locale', $user->locale)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.locale-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'locale','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('locale', $user->locale))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d0a682e0815be85aedd9fbba1a53208)): ?>
<?php $attributes = $__attributesOriginal7d0a682e0815be85aedd9fbba1a53208; ?>
<?php unset($__attributesOriginal7d0a682e0815be85aedd9fbba1a53208); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d0a682e0815be85aedd9fbba1a53208)): ?>
<?php $component = $__componentOriginal7d0a682e0815be85aedd9fbba1a53208; ?>
<?php unset($__componentOriginal7d0a682e0815be85aedd9fbba1a53208); ?>
<?php endif; ?>
                                      <?php echo $errors->first('locale', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>

                              <!-- Employee Number -->
                              <div class="form-group <?php echo e($errors->has('employee_num') ? 'has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="employee_num"><?php echo e(trans('general.employee_number')); ?></label>
                                  <div class="col-md-6">
                                      <input
                                              class="form-control"
                                              type="text"
                                              aria-label="employee_num"
                                              name="employee_num"
                                              maxlength="191"
                                              id="employee_num"
                                              value="<?php echo e(old('employee_num', $user->employee_num)); ?>"
                                      />
                                      <?php echo $errors->first('employee_num', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>


                              <!-- Jobtitle -->
                              <div class="form-group <?php echo e($errors->has('jobtitle') ? 'has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="jobtitle"><?php echo e(trans('admin/users/table.title')); ?></label>
                                  <div class="col-md-6">
                                      <input
                                              class="form-control"
                                              type="text"
                                              maxlength="191"
                                              name="jobtitle"
                                              id="jobtitle"
                                              value="<?php echo e(old('jobtitle', $user->jobtitle)); ?>"
                                      />
                                      <?php echo $errors->first('jobtitle', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>


                              <!-- Manager -->
                              <?php echo $__env->make('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                              <!--  Department -->
                              <?php echo $__env->make('partials.forms.edit.department-select', ['translated_name' => trans('general.department'), 'fieldname' => 'department_id'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                              <?php echo $__env->make('partials.forms.edit.datepicker', ['translated_name' => trans('general.start_date'), 'fieldname' => 'start_date', 'item' => $user], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                              <?php echo $__env->make('partials.forms.edit.datepicker', ['translated_name' => trans('general.end_date'), 'fieldname' => 'end_date', 'item' => $user], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                              <!-- VIP checkbox -->

                              <div class="form-group">
                                  <div class="col-md-7 col-md-offset-3">

                                      <label class="form-control" for="vip">
                                          <input type="checkbox" value="1" name="vip" <?php echo e((old('vip', $user->vip)) == '1' ? ' checked="checked"' : ''); ?> aria-label="vip">
                                          <?php echo e(trans('admin/users/general.vip_label')); ?>

                                      </label>

                                      <p class="help-block"><?php echo e(trans('admin/users/general.vip_help')); ?></p>
                                  </div>
                              </div>

                              <!-- Auto assign checkbox -->

                              <div class="form-group">
                                  <div class="col-md-7 col-md-offset-3">

                                      <label class="form-control" for="autoassign_licenses">
                                          <input type="checkbox" value="1" name="autoassign_licenses" <?php echo e((old('autoassign_licenses', $user->autoassign_licenses)) == '1' ? " checked='checked'" : ''); ?> aria-label="autoassign_licenses">
                                          <?php echo e(trans('general.autoassign_licenses')); ?>

                                      </label>

                                      <p class="help-block"><?php echo e(trans('general.autoassign_licenses_help_long')); ?></p>
                                  </div>
                              </div>


                              <!-- remote checkbox -->
                              <div class="form-group">
                                  <div class="col-md-7 col-md-offset-3">
                                      <label for="remote" class="form-control">
                                          <input type="checkbox" value="1" name="remote" <?php echo e((old('remote', $user->remote)) == '1' ? ' checked="checked"' : ''); ?> aria-label="remote">
                                          <?php echo e(trans('admin/users/general.remote_label')); ?>

                                      </label>
                                      <p class="help-block"><?php echo e(trans('admin/users/general.remote_help')); ?>

                                      </p>
                                  </div>
                              </div>


                              <!-- Location -->
                              <?php echo $__env->make('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                              <!-- Phone -->
                              <div class="form-group <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="phone"><?php echo e(trans('admin/users/table.phone')); ?></label>
                                  <div class="col-md-6">
                                      <input class="form-control" type="text" name="phone" id="phone" value="<?php echo e(old('phone', $user->phone)); ?>" maxlength="191" />
                                      <?php echo $errors->first('phone', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>

                              <!-- Mobile -->
                              <div class="form-group <?php echo e($errors->has('mobile') ? 'has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="phone"><?php echo e(trans('admin/users/table.mobile')); ?></label>
                                  <div class="col-md-6">
                                      <input class="form-control" type="text" name="mobile" id="mobile" value="<?php echo e(old('mobile', $user->mobile)); ?>" maxlength="191" />
                                      <?php echo $errors->first('mobile', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>

                              <!-- Website URL -->
                              <div class="form-group <?php echo e($errors->has('website') ? ' has-error' : ''); ?>">
                                  <label for="website" class="col-md-3 control-label"><?php echo e(trans('general.website')); ?></label>
                                  <div class="col-md-6">
                                      <input class="form-control" type="url" name="website" id="website" value="<?php echo e(old('website', $user->website)); ?>" maxlength="191" />
                                      <?php echo $errors->first('website', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

                                  </div>
                              </div>

                              <!-- Address -->
                              <div class="form-group<?php echo e($errors->has('address') ? ' has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="address"><?php echo e(trans('general.address')); ?></label>
                                  <div class="col-md-6">
                                      <input class="form-control" type="text" name="address" id="address" value="<?php echo e(old('address', $user->address)); ?>" maxlength="191" />
                                      <?php echo $errors->first('address', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>

                              <!-- City -->
                              <div class="form-group<?php echo e($errors->has('city') ? ' has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="city"><?php echo e(trans('general.city')); ?></label>
                                  <div class="col-md-6">
                                      <input class="form-control" type="text" name="city" id="city" aria-label="city" value="<?php echo e(old('city', $user->city)); ?>" maxlength="191" />
                                      <?php echo $errors->first('city', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>

                              <!-- State -->
                              <div class="form-group<?php echo e($errors->has('state') ? ' has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="state"><?php echo e(trans('general.state')); ?></label>
                                  <div class="col-md-6">
                                      <input class="form-control" type="text" name="state" id="state" value="<?php echo e(old('state', $user->state)); ?>" maxlength="191" />
                                      <?php echo $errors->first('state', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>

                              <!-- Country -->
                              <div class="form-group<?php echo e($errors->has('country') ? ' has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="country"><?php echo e(trans('general.country')); ?></label>
                                  <div class="col-md-6">
                                      <?php echo Form::countries('country', old('country', $user->country), 'col-md-12 select2'); ?>


                                      <p class="help-block"><?php echo e(trans('general.countries_manually_entered_help')); ?></p>
                                      <?php echo $errors->first('country', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>

                              <!-- Zip -->
                              <div class="form-group<?php echo e($errors->has('zip') ? ' has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="zip"><?php echo e(trans('general.zip')); ?></label>
                                  <div class="col-md-3">
                                      <input class="form-control" type="text" name="zip" id="zip" value="<?php echo e(old('zip', $user->zip)); ?>" maxlength="10" />
                                      <?php echo $errors->first('zip', '<span class="alert-msg" aria-hidden="true">:message</span>'); ?>

                                  </div>
                              </div>

                              <!-- Notes -->
                              <div class="form-group<?php echo $errors->has('notes') ? ' has-error' : ''; ?>">
                                  <label for="notes" class="col-md-3 control-label"><?php echo e(trans('admin/users/table.notes')); ?></label>
                                  <div class="col-md-6">
                                      <textarea class="form-control" rows="5" id="notes" name="notes"><?php echo e(old('notes', $user->notes)); ?></textarea>
                                      <?php echo $errors->first('notes', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>'); ?>

                                  </div>
                              </div>

                              <?php if($snipeSettings->two_factor_enabled!=''): ?>
                                  <?php if($snipeSettings->two_factor_enabled=='1'): ?>
                                      <div class="form-group">
                                          <div class="col-md-9 col-md-offset-3">

                                              <?php if(!Gate::allows('editableOnDemo')): ?>

                                                  <label class="form-control form-control--disabled" for="two_factor_optin">
                                                      <input type="checkbox" value="1" name="two_factor_optin" <?php echo e((old('two_factor_optin', $user->two_factor_optin)) == '1' ? ' checked="checked"' : ''); ?> aria-label="two_factor_optin" disabled>
                                                      <?php echo e(trans('admin/settings/general.two_factor')); ?>

                                                  </label>

                                              <?php else: ?>

                                                  <label class="form-control" for="two_factor_optin">
                                                      <input type="checkbox" value="1" name="two_factor_optin" <?php echo e((old('two_factor_optin', $user->two_factor_optin)) == '1' ? ' checked="checked"' : ''); ?> aria-label="two_factor_optin">
                                                      <?php echo e(trans('admin/settings/general.two_factor')); ?>

                                                  </label>
                                                  <p class="help-block">
                                                      <?php echo e(trans('admin/users/general.two_factor_admin_optin_help')); ?>

                                                  </p>

                                              <?php endif; ?>

                                          </div>
                                      </div>
                                  <?php endif; ?>

                                  <?php if((Auth::user()->isSuperUser()) && ($user->two_factor_active_and_enrolled()) && ($snipeSettings->two_factor_enabled!='0') && ($snipeSettings->two_factor_enabled!='')): ?>
                                      <!-- Reset Two Factor -->
                                      <div class="form-group">
                                          <div class="col-md-8 col-md-offset-3 two_factor_resetrow">
                                              <a class="btn btn-default btn-sm pull-left" id="two_factor_reset" style="margin-right: 10px;"> <?php echo e(trans('admin/settings/general.two_factor_reset')); ?></a>
                                              <span id="two_factor_reseticon"></span>
                                              <span id="two_factor_resetresult"></span>
                                              <span id="two_factor_resetstatus"></span>
                                          </div>
                                          <div class="col-md-8 col-md-offset-3 two_factor_resetrow">
                                              <p class="help-block">
                                                  <?php echo e(trans('admin/settings/general.two_factor_reset_help')); ?>

                                              </p>
                                          </div>
                                      </div>
                                  <?php endif; ?>

                              <?php endif; ?>

                              <!-- Groups -->
                              <div class="form-group<?php echo e($errors->has('groups') ? ' has-error' : ''); ?>">
                                  <label class="col-md-3 control-label" for="groups[]">
                                      <?php echo e(trans('general.groups')); ?>

                                  </label>
                                  <div class="col-md-6">

                                      <?php if($groups->count()): ?>
                                          <?php if((!Gate::allows('editableOnDemo') || (!Auth::user()->isSuperUser()))): ?>

                                              <?php if(count($userGroups->keys()) > 0): ?>
                                                  <ul>
                                                      <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                          <?php echo ($userGroups->keys()->contains($id) ? '<li>'.e($group).'</li>' : ''); ?>

                                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </ul>
                                              <?php endif; ?>

                                              <p class="help-block">
                                                  <?php if (isset($component)) { $__componentOriginalce262628e3a8d44dc38fd1f3965181bc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce262628e3a8d44dc38fd1f3965181bc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::icon','data' => ['type' => 'locked']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'locked']); ?>
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
                                                  <?php echo e(trans('admin/users/general.group_memberships_helpblock')); ?>

                                              </p>
                                          <?php else: ?>
                                               <div class="controls">
                                                <select
                                                        name="groups[]"
                                                        aria-label="groups[]"
                                                        id="groups[]"
                                                        multiple="multiple"
                                                        class="form-control">

                                                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($id); ?>"
                                                                <?php echo e(($userGroups->keys()->contains($id) ? ' selected="selected"' : '')); ?>>
                                                            <?php echo e($group); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                            <p class="help-block">
                                              <?php echo e(trans('admin/users/table.groupnotes')); ?>

                                            </p>
                                </div>
                                     <?php endif; ?>
                               <?php else: ?>
                                          <p><?php echo e(trans('admin/users/table.nogroup')); ?> <code><?php echo e(trans('admin/settings/general.admin_settings')); ?> <i class="fa fa-cogs"></i> > <?php echo e(trans('general.groups')); ?> <i class="fas fa-user-friends"></i></code> </p>
                               <?php endif; ?>

                                  </div>
                              </div>
                          </div>

                    </fieldset>
                      </div>




              </div> <!--/col-md-12-->
            </div>
          </div><!-- /.tab-pane -->

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
          <div class="tab-pane" id="permissions">
            <div class="col-md-12">
              <?php if(!Auth::user()->isSuperUser()): ?>
                <p class="alert alert-warning"><?php echo e(trans('admin/users/general.superadmin_permission_warning')); ?></p>
              <?php endif; ?>

              <?php if(!Auth::user()->hasAccess('admin')): ?>
                <p class="alert alert-warning"><?php echo e(trans('admin/users/general.admin_permission_warning')); ?></p>
              <?php endif; ?>
            </div>

            <table class="table table-striped permissions">
              <thead>
                <tr class="permissions-row">
                  <th class="col-md-5"><?php echo e(trans('admin/groups/titles.permission')); ?></th>
                  <th class="col-md-1"><?php echo e(trans('admin/groups/titles.grant')); ?></th>
                  <th class="col-md-1"><?php echo e(trans('admin/groups/titles.deny')); ?></th>
                  <th class="col-md-1"><?php echo e(trans('admin/users/table.inherit')); ?></th>
                </tr>
              </thead>
                <?php echo $__env->make('partials.forms.edit.permissions-base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </table>
          </div><!-- /.tab-pane -->
          <?php endif; ?>
        </div><!-- /.tab-content -->
          <?php if (isset($component)) { $__componentOriginal897bfaf5cfb025541cae5f511fed1c5f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal897bfaf5cfb025541cae5f511fed1c5f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '53a84532857250ffb7b99fa272c3af08::redirect_submit_options','data' => ['indexRoute' => 'users.index','buttonLabel' => trans('general.save'),'options' => [
                        'back' => trans('admin/hardware/form.redirect_to_type',['type' => trans('general.previous_page')]),
                        'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'users']),
                        'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.user')]),
                        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('redirect_submit_options'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['index_route' => 'users.index','button_label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('general.save')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                        'back' => trans('admin/hardware/form.redirect_to_type',['type' => trans('general.previous_page')]),
                        'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'users']),
                        'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.user')]),
                        ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal897bfaf5cfb025541cae5f511fed1c5f)): ?>
<?php $attributes = $__attributesOriginal897bfaf5cfb025541cae5f511fed1c5f; ?>
<?php unset($__attributesOriginal897bfaf5cfb025541cae5f511fed1c5f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal897bfaf5cfb025541cae5f511fed1c5f)): ?>
<?php $component = $__componentOriginal897bfaf5cfb025541cae5f511fed1c5f; ?>
<?php unset($__componentOriginal897bfaf5cfb025541cae5f511fed1c5f); ?>
<?php endif; ?>
      </div><!-- nav-tabs-custom -->
    </form>
  </div> <!--/col-md-8-->
</div><!--/row-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('moar_scripts'); ?>

<script nonce="<?php echo e(csrf_token()); ?>">

$(document).ready(function() {


    // Set some defaults
    $('#email_user_checkbox').prop("disabled", true);
    $('#email_user_checkbox').prop("checked", false);
    $("#email_user_checkbox").removeAttr('checked');

    // If the email address is longer than 5 characters, enable the "send email" checkbox
    $('#email').on('keyup',function(){
        //event.preventDefault();

        <?php if(!config('app.lock_passwords')): ?>

        if (this.value.length > 5) {
            $('#email_user_checkbox').prop("disabled", false);
            $("#email_user_checkbox").parent().removeClass("form-control--disabled");
        } else {
            $('#email_user_checkbox').prop("disabled", true);
            $('#email_user_checkbox').prop("checked", false);
            $("#email_user_checkbox").parent().addClass("form-control--disabled");
        }

        <?php endif; ?>
    });


	// Check/Uncheck all radio buttons in the group
    $('tr.header-row input:radio').change(function() {
        value = $(this).attr('value');
        area = $(this).data('checker-group');
        $('.radiochecker-'+area+'[value='+value+']').prop('checked', true);
    });

    $('.header-name').click(function() {
        $(this).parent().nextUntil('tr.header-row').slideToggle(500);
    });

    $('.tooltip-base').tooltip({container: 'body'})
    $(".superuser").change(function() {
        var perms = $(this).val();
        if (perms =='1') {
            $("#nonadmin").hide();
        } else {
            $("#nonadmin").show();
        }
    });

    $('#genPassword').pGenerator({
        'bind': 'click',
        'passwordElement': '#password',
        'displayElement': '#generated-password',
        'passwordLength': <?php echo e(($settings->pwd_secure_min + 5)); ?>,
        'uppercase': true,
        'lowercase': true,
        'numbers':   true,
        'specialChars': true,
        'onPasswordGenerated': function(generatedPassword) {
            $('#password_confirm').val($('#password').val());
        }
    });

    $("#optional_user_info").on("click",function(){
        $('#optional_user_details').fadeToggle(100);
        $('#optional_user_info_icon').toggleClass('fa-caret-right fa-caret-down');
        var optional_user_info_open = $('#optional_user_info_icon').hasClass('fa-caret-down');
        document.cookie = "optional_user_info_open="+optional_user_info_open+'; path=/';
    });

    var all_cookies = document.cookie.split(';')
    for(var i in all_cookies) {
        var trimmed_cookie = all_cookies[i].trim(' ')
        if (trimmed_cookie.startsWith('optional_user_info_open=')) {
            elems = all_cookies[i].split('=', 2)
            if (elems[1] == 'true') {
                $('#optional_user_info').trigger('click')
            }
        }
    }

    $("#two_factor_reset").click(function(){
        $("#two_factor_resetrow").removeClass('success');
        $("#two_factor_resetrow").removeClass('danger');
        $("#two_factor_resetstatus").html('');
        $("#two_factor_reseticon").html('<i class="fas fa-spinner spin"></i> ');
        $.ajax({
            url: '<?php echo e(route('api.users.two_factor_reset', ['id'=> $user->id])); ?>',
            type: 'POST',
            data: {},
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') // TODO` - we should do this in ajaxSetup
            },
            dataType: 'json',

            success: function (data) {
                $("#two_factor_reseticon").html('');
                $("#two_factor_resetstatus").html('<span class="text-success"><i class="fas fa-check"></i> ' + data.message + '</span>');
            },

            error: function (data) {
                $("#two_factor_reseticon").html('');
                $("#two_factor_resetstatus").html('<span class="text-danger"><i class="fas fa-exclamation-triangle text-danger"></i> ' + data.message + '</span>');
            }


        });
    });


});
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/users/edit.blade.php ENDPATH**/ ?>
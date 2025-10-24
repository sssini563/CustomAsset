<?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area => $permissionsArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php if(count($permissionsArray) == 1): ?>
    <?php $localPermission = $permissionsArray[0]; ?>
    <tbody class="permissions-group">
    <tr class="header-row permissions-row">
      <td class="col-md-5 tooltip-base permissions-item"
        data-tooltip="true"
        data-placement="right"
        title="<?php echo e($localPermission['note']); ?>"
      >
        <?php if (! (empty($localPermission['label']))): ?>
         <h2><?php echo e($area . ': ' . $localPermission['label']); ?></h2>
        <?php else: ?>
          <h2><?php echo e($area); ?></h2>
        <?php endif; ?>
      </td>

      <td class="col-md-1 permissions-item">
        <label class="sr-only" for="<?php echo e('permission['.$localPermission['permission'].']'); ?>"><?php echo e('permission['.$localPermission['permission'].']'); ?></label>
        <?php if(($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser())): ?>
          <input
              disabled="disabled"
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '1'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="1"
          />
        <?php elseif(($localPermission['permission'] == 'admin') && (!Auth::user()->hasAccess('admin'))): ?>
          <input
              disabled="disabled"
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '1'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="1"
          />
        <?php else: ?>
          <input
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '1'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="1"
          />
        <?php endif; ?>

        
      </td>
      <td class="col-md-1 permissions-item">
        <label class="sr-only" for="<?php echo e('permission['.$localPermission['permission'].']'); ?>"><?php echo e('permission['.$localPermission['permission'].']'); ?></label>
        <?php if(($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser())): ?>
          <input
              disabled="disabled"
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '-1'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="-1"
          />
        <?php elseif(($localPermission['permission'] == 'admin') && (!Auth::user()->hasAccess('admin'))): ?>
          <input
              disabled="disabled"
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '-1'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="-1"
          />
        <?php else: ?>
          <input
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '-1'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="-1"
          />
        <?php endif; ?>
      </td>
      <td class="col-md-1 permissions-item">
        <label class="sr-only" for="<?php echo e('permission['.$localPermission['permission'].']'); ?>">
           <?php echo e('permission['.$localPermission['permission'].']'); ?></label>
        <?php if(($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser())): ?>
          <input
              disabled="disabled"
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '0'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="0"
          />
        <?php elseif(($localPermission['permission'] == 'admin') && (!Auth::user()->hasAccess('admin'))): ?>
          <input
              disabled="disabled"
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '0'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="0"
          />
        <?php else: ?>
          <input
              aria-label="permission[<?php echo e($localPermission['permission']); ?>]"
              <?php if($userPermissions[$localPermission['permission']] == '0'): echo 'checked'; endif; ?>
              name="permission[<?php echo e($localPermission['permission']); ?>]"
              type="radio"
              value="0"
          />
        <?php endif; ?>
      </td>
    </tr>
  </tbody>

  <?php else: ?> <!-- count($permissionsArray) == 1-->
  <tbody class="permissions-group">
    <tr class="header-row permissions-row">
      <td class="col-md-5 header-name">
        <h2> <?php echo e($area); ?></h2>
      </td>
      <td class="col-md-1 permissions-item">
        <label for="<?php echo e($area); ?>" class="sr-only"><?php echo e($area); ?></label>
        <input
            value="1"
            data-checker-group="<?php echo e(str_slug($area)); ?>"
            aria-label="<?php echo e($area); ?>"
            name="<?php echo e($area); ?>"
            type="radio"
        />
      </td>
      <td class="col-md-1 permissions-item">
        <label for="<?php echo e($area); ?>" class="sr-only"><?php echo e($area); ?></label>
        <input
            value="-1"
            data-checker-group="<?php echo e(str_slug($area)); ?>"
            aria-label="<?php echo e($area); ?>"
            name="<?php echo e($area); ?>"
            type="radio"
        />
      </td>
      <td class="col-md-1 permissions-item">
        <label for="<?php echo e($area); ?>" class="sr-only"><?php echo e($area); ?></label>
        <input
            value="0"
            data-checker-group="<?php echo e(str_slug($area)); ?>"
            aria-label="<?php echo e($area); ?>"
            name="<?php echo e($area); ?>"
            type="radio"
        />
      </td>
    </tr>

    <?php $__currentLoopData = $permissionsArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr class="permissions-row">
        <?php if($permission['display']): ?>
          <td
            class="col-md-5 tooltip-base permissions-item"
            data-tooltip="true"
            data-placement="right"
            title="<?php echo e($permission['note']); ?>"
          >
            <?php echo e($permission['label']); ?>

          </td>
          <td class="col-md-1 permissions-item">
            <label class="sr-only" for="<?php echo e('permission['.$permission['permission'].']'); ?>"><?php echo e('permission['.$permission['permission'].']'); ?></label>
            <input
                value="1"
                class="radiochecker-<?php echo e(str_slug($area)); ?>"
                aria-label="permission[<?php echo e($permission['permission']); ?>]"
                <?php if($userPermissions[$permission['permission']] == '1'): echo 'checked'; endif; ?>
                <?php if(($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser())): echo 'disabled'; endif; ?>
                name="permission[<?php echo e($permission['permission']); ?>]"
                type="radio"
            />
          </td>
          <td class="col-md-1 permissions-item">
            <input
                value="-1"
                class="radiochecker-<?php echo e(str_slug($area)); ?>"
                aria-label="permission[<?php echo e($permission['permission']); ?>]"
                <?php if($userPermissions[$permission['permission']] == '-1'): echo 'checked'; endif; ?>
                <?php if(($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser())): echo 'disabled'; endif; ?>
                name="permission[<?php echo e($permission['permission']); ?>]"
                type="radio"
            />
          </td>
          <td class="col-md-1 permissions-item">
            <input
                value="0"
                class="radiochecker-<?php echo e(str_slug($area)); ?>"
                aria-label="permission[<?php echo e($permission['permission']); ?>]"
                <?php if($userPermissions[$permission['permission']] =='0'): echo 'checked'; endif; ?>
                <?php if(($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser())): echo 'disabled'; endif; ?>
                name="permission[<?php echo e($permission['permission']); ?>]"
                type="radio"
            />
          </td>
        <?php endif; ?>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/partials/forms/edit/permissions-base.blade.php ENDPATH**/ ?>
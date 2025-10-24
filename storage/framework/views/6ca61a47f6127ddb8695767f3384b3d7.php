<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo e(trans('general.assigned_to', array('name' => $location->display_name))); ?> </title>
    <style>
        body {
            font-family: "Arial, Helvetica", sans-serif;
        }
        table.inventory {
            border: solid #000;
            border-width: 1px 1px 1px 1px;
            width: 100%;
        }

        @page {
            size: auto;
        }
        table.inventory th, table.inventory td {
            border: solid #000;
            border-width: 0 1px 1px 0;
            padding: 3px;
            font-size: 12px;
        }

        .print-logo {
            max-height: 40px;
        }

    </style>
</head>
<body>

<?php if($snipeSettings->logo_print_assets=='1'): ?>
    <?php if($snipeSettings->brand == '3'): ?>

        <h3>
        <?php if($snipeSettings->acceptance_pdf_logo!=''): ?>
            <img class="print-logo" src="<?php echo e(config('app.url')); ?>/uploads/<?php echo e($snipeSettings->acceptance_pdf_logo); ?>">
        <?php endif; ?>
        <?php echo e($snipeSettings->site_name); ?>

        </h3>
    <?php elseif($snipeSettings->brand == '2'): ?>
        <?php if($snipeSettings->acceptance_pdf_logo!=''): ?>
            <img class="print-logo" src="<?php echo e(config('app.url')); ?>/uploads/<?php echo e($snipeSettings->acceptance_pdf_logo); ?>">
        <?php endif; ?>
    <?php else: ?>
      <h3><?php echo e($snipeSettings->site_name); ?></h3>
    <?php endif; ?>
<?php endif; ?>

<h2>
    <?php if($assigned): ?>
        <?php echo e(trans('general.assigned_to', array('name' => $location->display_name))); ?>

    <?php else: ?>
        <?php echo e(trans('admin/locations/table.print_inventory')); ?> : <?php echo e($location->display_name); ?>

    <?php endif; ?>
    </h2>
    <?php if($location->parent): ?>
    <strong><?php echo e(trans('admin/locations/table.parent')); ?>:</strong> <?php echo e($location->parent->display_name); ?>

<?php endif; ?>
<br>
<?php if($location->company): ?>
<b><?php echo e(trans('admin/companies/table.name')); ?>:</b> <?php echo e($location->company->display_name); ?>

<br>
<?php endif; ?>
<?php if($location->manager): ?>
<b><?php echo e(trans('admin/users/table.manager')); ?>:</b> <?php echo e($location->manager->display_name); ?><br>
<?php endif; ?>
<b><?php echo e(trans('general.date')); ?>:</b>  <?php echo e(\App\Helpers\Helper::getFormattedDateObject(now(), 'datetime', false)); ?><br><br>

<?php if($users->count() > 0): ?>
<?php
    $counter = 1;
?>
<table class="inventory">
    <thead>
    <tr>
        <th colspan="6"><?php echo e(trans('general.users')); ?></th>
    </tr>
    </thead>
    <thead>
        <tr>
        <th style="width: 5px;"></th>
        <th style="width: 25%;"><?php echo e(trans('general.company')); ?></th>
        <th style="width: 25%;"><?php echo e(trans('admin/locations/table.user_name')); ?></th>
        <th style="width: 10%;"><?php echo e(trans('general.employee_number')); ?></th>
        <th style="width: 20%;"><?php echo e(trans('admin/locations/table.department')); ?></th>
        <th style="width: 20%;"><?php echo e(trans('admin/locations/table.location')); ?></th>
        </tr>
    </thead>
<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <tr>
    <td><?php echo e($counter); ?></td>
    <td><?php echo e((($user) && ($user->company)) ? $user->company->name : ''); ?></td>
    <td><?php echo e(($user)  ? $user->first_name .' '. $user->last_name : ''); ?></td>
    <td><?php echo e(($user)  ? $user->employee_num : ''); ?></td>
    <td><?php echo e((($user) && ($user->department)) ? $user->department->name : ''); ?></td>
    <td><?php echo e((($user) && ($user->location)) ? $user->location->name : ''); ?></td>
    </tr>
        <?php
            $counter++
        ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php endif; ?>

<?php if($children->count() > 0): ?>
    <br><br>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="10"><?php echo e(trans('general.child_locations')); ?></th>
        </tr>
        </thead>
        <thead>
        <tr>
            <th style="width: 20px;"></th>
            <th><?php echo e(trans('general.name')); ?></th>
            <th><?php echo e(trans('general.address')); ?></th>
            <th><?php echo e(trans('general.city')); ?></th>
            <th><?php echo e(trans('general.state')); ?></th>
            <th><?php echo e(trans('general.country')); ?></th>
            <th><?php echo e(trans('general.zip')); ?></th>

        </tr>
        </thead>
        <?php
            $counter = 1;
        ?>

        <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($counter); ?></td>
                <td><?php echo e($child->name); ?></td>
                <td><?php echo e($child->address); ?></td>
                <td><?php echo e($child->city); ?></td>
                <td><?php echo e($child->state); ?></td>
                <td><?php echo e($child->country); ?></td>
                <td><?php echo e($child->zip); ?></td>
            </tr>
            <?php
                $counter++
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php endif; ?>

<?php if($assets->count() > 0): ?>
<br><br>
<table class="inventory">
    <thead>
    <tr>
        <th colspan="10"><?php echo e(trans('general.assets')); ?></th>
    </tr>
    </thead>
    <thead>
        <tr>
        <th style="width: 20px;"></th>
        <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_tag')); ?></th>
        <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_name')); ?></th>
        <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_category')); ?></th>
        <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_manufacturer')); ?></th>
        <th style="width: 15%;"><?php echo e(trans('admin/locations/table.asset_model')); ?></th>
        <th style="width: 15%;"><?php echo e(trans('admin/locations/table.asset_serial')); ?></th>
        <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_location')); ?></th>
        <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_checked_out')); ?></th>
        <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_expected_checkin')); ?></th>
        </tr>
    </thead>
    <?php
        $counter = 1;
    ?>

    <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            if($snipeSettings->show_archived_in_list != 1 && $asset->assetstatus?->archived == 1){
                continue;
            }
        ?>
    <tr>
    <td><?php echo e($counter); ?></td>
    <td><?php echo e($asset->asset_tag); ?></td>
    <td><?php echo e($asset->name); ?></td>
    <td><?php echo e((($asset->model) && ($asset->model->category)) ? $asset->model->category->name : ''); ?></td>
    <td><?php echo e((($asset->model) && ($asset->model->manufacturer)) ? $asset->model->manufacturer->name : ''); ?></td>
    <td><?php echo e(($asset->model) ? $asset->model->name : ''); ?></td>
    <td><?php echo e($asset->serial); ?></td>
    <td><?php echo e(($asset->location) ? $asset->location->name : ''); ?></td>
    <td><?php echo e(\App\Helpers\Helper::getFormattedDateObject( $asset->last_checkout, 'datetime', false)); ?></td>
    <td><?php echo e(\App\Helpers\Helper::getFormattedDateObject( $asset->expected_checkin, 'datetime', false)); ?></td>
    </tr>
        <?php
            $counter++
        ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php endif; ?>

<?php if($assigned): ?>
    <?php if($assignedAssets->count() > 0): ?>
        <br><br>
        <table class="inventory">
            <thead>
            <tr>
                <th colspan="10"><?php echo e(trans('admin/locations/message.assigned_assets')); ?></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th style="width: 20px;"></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_tag')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_name')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_category')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_manufacturer')); ?></th>
                <th style="width: 15%;"><?php echo e(trans('admin/locations/table.asset_model')); ?></th>
                <th style="width: 15%;"><?php echo e(trans('admin/locations/table.asset_serial')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_location')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_checked_out')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_expected_checkin')); ?></th>
            </tr>
            </thead>
            <?php
                $counter = 1;
            ?>

            <?php $__currentLoopData = $assignedAssets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    if($snipeSettings->show_archived_in_list != 1 && $asset->assetstatus?->archived == 1){
                        continue;
                    }
                ?>
                <tr>
                    <td><?php echo e($counter); ?></td>
                    <td><?php echo e($asset->asset_tag); ?></td>
                    <td><?php echo e($asset->name); ?></td>
                    <td><?php echo e((($asset->model) && ($asset->model->category)) ? $asset->model->category->name : ''); ?></td>
                    <td><?php echo e((($asset->model) && ($asset->model->manufacturer)) ? $asset->model->manufacturer->name : ''); ?></td>
                    <td><?php echo e(($asset->model) ? $asset->model->name : ''); ?></td>
                    <td><?php echo e($asset->serial); ?></td>
                    <td><?php echo e(($asset->location) ? $asset->location->name : ''); ?></td>
                    <td><?php echo e(\App\Helpers\Helper::getFormattedDateObject( $asset->last_checkout, 'datetime', false)); ?></td>
                    <td><?php echo e(\App\Helpers\Helper::getFormattedDateObject( $asset->expected_checkin, 'datetime', false)); ?></td>
                </tr>
                <?php
                    $counter++
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    <?php endif; ?>
<?php endif; ?>

<?php if($accessories->count() > 0): ?>
    <br><br>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="10"><?php echo e(trans('general.accessories')); ?></th>
        </tr>
        </thead>
        <thead>
        <tr>
            <th style="width: 20px;"></th>
            <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_name')); ?></th>
            <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_category')); ?></th>
            <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_manufacturer')); ?></th>
            <th><?php echo e(trans('admin/models/table.modelnumber')); ?></th>
            <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_location')); ?></th>
        </tr>
        </thead>
        <?php
            $counter = 1;
        ?>

        <?php $__currentLoopData = $accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($counter); ?></td>
                <td><?php echo e($accessory->name); ?></td>
                <td><?php echo e(($accessory->category) ? $accessory->category->name : ''); ?></td>
                <td><?php echo e(($accessory->manufacturer) ? $accessory->manufacturer->name : ''); ?></td>
                <td><?php echo e($asset->model_number); ?></td>
                <td><?php echo e(($asset->location) ? $asset->location->name : ''); ?></td>
            </tr>
            <?php
                $counter++
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php endif; ?>

<?php if($assigned): ?>
    <?php if($assignedAccessories->count() > 0): ?>
        <br><br>
        <table class="inventory">
            <thead>
            <tr>
                <th colspan="10"><?php echo e(trans('general.accessories_assigned')); ?></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th style="width: 20px;"></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_name')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_category')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_manufacturer')); ?></th>
                <th><?php echo e(trans('admin/models/table.modelnumber')); ?></th>
                <th style="width: 10%;"><?php echo e(trans('admin/locations/table.asset_location')); ?></th>
            </tr>
            </thead>
            <?php
                $counter = 1;
            ?>

            <?php $__currentLoopData = $assignedAccessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($counter); ?></td>
                    <td><?php echo e($accessory->name); ?></td>
                    <td><?php echo e(($accessory->category) ? $accessory->category->name : ''); ?></td>
                    <td><?php echo e(($accessory->manufacturer) ? $accessory->manufacturer->name : ''); ?></td>
                    <td><?php echo e($asset->model_number); ?></td>
                    <td><?php echo e(($asset->location) ? $asset->location->name : ''); ?></td>
                </tr>
                <?php
                    $counter++
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    <?php endif; ?>
<?php endif; ?>

<?php if($consumables->count() > 0): ?>
    <br><br>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="10"><?php echo e(trans('general.accessories')); ?></th>
        </tr>
        </thead>
        <thead>
        <tr>
            <th style="width: 20px;"></th>
            <th><?php echo e(trans('admin/locations/table.asset_name')); ?></th>
            <th><?php echo e(trans('general.qty')); ?></th>
            <th><?php echo e(trans('admin/locations/table.asset_category')); ?></th>
            <th><?php echo e(trans('admin/locations/table.asset_manufacturer')); ?></th>
            <th><?php echo e(trans('admin/models/table.modelnumber')); ?></th>
        </tr>
        </thead>
        <?php
            $counter = 1;
        ?>

        <?php $__currentLoopData = $consumables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consumable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($counter); ?></td>
                <td><?php echo e($consumable->name); ?></td>
                <td><?php echo e($consumable->qty); ?></td>
                <td><?php echo e(($consumable->category) ? $consumable->category->name : ''); ?></td>
                <td><?php echo e(($consumable->manufacturer) ? $consumable->manufacturer->name : ''); ?></td>
                <td><?php echo e($consumable->model_number); ?></td>
            </tr>
            <?php
                $counter++
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php endif; ?>

<?php if($components->count() > 0): ?>
    <br><br>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="10"><?php echo e(trans('general.components')); ?></th>
        </tr>
        </thead>
        <thead>
        <tr>
            <th style="width: 20px;"></th>
            <th><?php echo e(trans('admin/locations/table.asset_name')); ?></th>
            <th><?php echo e(trans('general.qty')); ?></th>
            <th><?php echo e(trans('admin/locations/table.asset_category')); ?></th>
            <th><?php echo e(trans('admin/locations/table.asset_manufacturer')); ?></th>
            <th><?php echo e(trans('admin/models/table.modelnumber')); ?></th>
        </tr>
        </thead>
        <?php
            $counter = 1;
        ?>

        <?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($counter); ?></td>
                <td><?php echo e($component->name); ?></td>
                <td><?php echo e($component->qty); ?></td>
                <td><?php echo e(($component->category) ? $component->category->name : ''); ?></td>
                <td><?php echo e(($component->manufacturer) ? $component->manufacturer->name : ''); ?></td>
                <td><?php echo e($component->model_number); ?></td>
            </tr>
            <?php
                $counter++
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php endif; ?>

<br>
<br>
<br>
<table>
<tr>
    <td><?php echo e(trans('admin/locations/table.signed_by_asset_auditor')); ?></td>
    <td><br>------------------------------------------------------ &nbsp;&nbsp;&nbsp;<br></td>
    <td><?php echo e(trans('admin/locations/table.date')); ?></td>
    <td><br>------------------------------ &nbsp;&nbsp;&nbsp;<br></td>
</tr>

<tr>
    <td><?php echo e(trans('admin/locations/table.signed_by_finance_auditor')); ?></td>
    <td><br>------------------------------------------------------ &nbsp;&nbsp;&nbsp;<br></td>
    <td><?php echo e(trans('admin/locations/table.date')); ?></td>
    <td><br>------------------------------ &nbsp;&nbsp;&nbsp;<br></td>
</tr>

<tr>
    <td><?php echo e(trans('admin/locations/table.signed_by_location_manager')); ?></td>
    <td><br>------------------------------------------------------ &nbsp;&nbsp;&nbsp;<br></td>
    <td><?php echo e(trans('admin/locations/table.date')); ?></td>
    <td><br>------------------------------ &nbsp;&nbsp;&nbsp;<br></td>
</tr>
</table>


</body>
</html>
<?php /**PATH C:\laravel\backup\snipe-it-8.3.3 - Copy\resources\views/locations/print.blade.php ENDPATH**/ ?>
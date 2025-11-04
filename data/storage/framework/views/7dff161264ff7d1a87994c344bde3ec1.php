<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(($snipeSettings) && ($snipeSettings->site_name) ? $snipeSettings->site_name : 'Snipe-IT'); ?></title>

    <link rel="shortcut icon" type="image/ico" href="<?php echo e(($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url').'/favicon.ico'); ?>">
    
    <link rel="stylesheet" href="<?php echo e(url(mix('css/dist/all.css'))); ?>">

    <script nonce="<?php echo e(csrf_token()); ?>">
        window.snipeit = {
            settings: {
                "per_page": 50
            }
        };
    </script>


    <?php if(($snipeSettings) && ($snipeSettings->header_color)): ?>
        <style>
        .main-header .navbar, .main-header .logo {
        background-color: <?php echo e($snipeSettings->header_color); ?>;
        background: -webkit-linear-gradient(top,  <?php echo e($snipeSettings->header_color); ?> 0%,<?php echo e($snipeSettings->header_color); ?> 100%);
        background: linear-gradient(to bottom, <?php echo e($snipeSettings->header_color); ?> 0%,<?php echo e($snipeSettings->header_color); ?> 100%);
        border-color: <?php echo e($snipeSettings->header_color); ?>;
        }
        .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a {
        border-left-color: <?php echo e($snipeSettings->header_color); ?>;
        }
        </style>
    <?php endif; ?>

    <?php if(($snipeSettings) && ($snipeSettings->custom_css)): ?>
        <style>
            <?php echo $snipeSettings->show_custom_css(); ?>

        </style>
    <?php endif; ?>

</head>

<body class="hold-transition login-page">

    <?php if(($snipeSettings) && ($snipeSettings->logo!='')): ?>
        <div class="text-center">
            <a href="<?php echo e(config('app.url')); ?>">
                <img id="login-logo" src="<?php echo e(Storage::disk('public')->url('').e($snipeSettings->logo)); ?>" alt="<?php echo e($snipeSettings->site_name); ?>">
            </a>
        </div>
    <?php endif; ?>
  <!-- Content -->
  <?php echo $__env->yieldContent('content'); ?>

    <div class="text-center" style="padding-top: 100px;">
        <?php if(($snipeSettings) && ($snipeSettings->privacy_policy_link!='')): ?>
        <a target="_blank" rel="noopener" href="<?php echo e($snipeSettings->privacy_policy_link); ?>" target="_new"><?php echo e(trans('admin/settings/general.privacy_policy')); ?></a>
    <?php endif; ?>
    </div>

    
    <script src="<?php echo e(url(mix('js/dist/all.js'))); ?>" nonce="<?php echo e(csrf_token()); ?>"></script>


    <?php echo $__env->yieldPushContent('js'); ?>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/layouts/basic.blade.php ENDPATH**/ ?>
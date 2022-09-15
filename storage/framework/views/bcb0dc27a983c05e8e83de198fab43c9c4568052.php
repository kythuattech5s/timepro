<!DOCTYPE html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="vi">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo SEOHelper::HEADER_SEO(@$currentItem ? $currentItem : null); ?>

    <link rel="stylesheet" href="<?php echo e(Support::asset('theme/frontend/css/toastify.css')); ?>"/>
    <?php echo $__env->yieldContent('cssl'); ?>
    <?php echo $__env->yieldContent('css'); ?>
    <script type="text/javascript">
        var showNotify = "";
        var messageNotify = "<?php echo e(Session::get('messageNotify', '')); ?>";
        var typeNotify = "<?php echo e(Session::get('typeNotify', '')); ?>";
        var typePopup = "<?php echo e(Session::get('type', '')); ?>";
        var emailSocial = "<?php echo e(Session::get('emailSocial', '')); ?>";
        var auth = "<?php echo e(Session::get('auth', '')); ?>";
        var redirect = "<?php echo e(Session::get('redirect', '')); ?>";
    </script>
    <?php echo vanhenry\helpers\helpers\SettingHelper::getSetting('CMS_HEADER') ?>
</head>
<body>
    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('main'); ?>
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo vanhenry\helpers\helpers\SettingHelper::getSetting('CMS_FOOTER') ?>
    <script src="<?php echo e(Support::asset('theme/frontend/js/xhr.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/validator.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/toastify.js')); ?>" defer></script>
    <?php echo $__env->yieldContent('jsl'); ?>
    <script src="<?php echo e(Support::asset('theme/frontend/js/base.js')); ?>" defer></script>
    <?php echo $__env->yieldContent('js'); ?>
    <script src="<?php echo e(Support::asset('theme/frontend/js/add/scrip.js')); ?>" defer></script>
</body>
</html>
<?php /**PATH D:\laragon\www\timepro\resources\views/index.blade.php ENDPATH**/ ?>
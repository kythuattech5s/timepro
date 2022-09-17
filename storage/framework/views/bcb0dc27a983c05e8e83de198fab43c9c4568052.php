<!DOCTYPE html>
<html itemscope="" itemtype="http://schema.org/WebPage" lang="vi">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo SEOHelper::HEADER_SEO(@$currentItem ? $currentItem : null); ?>

    <link rel="stylesheet" href="<?php echo e(Support::asset('theme/frontend/css/animate.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(Support::asset('theme/frontend/css/font-awesome.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(Support::asset('theme/frontend/css/swiper-bundle.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(Support::asset('theme/frontend/css/lightbox.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(Support::asset('theme/frontend/css/main.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(Support::asset('theme/frontend/css/toastify.css')); ?>"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'Averta': ['"Averta"'],
                    },
                    screens: {
                        'sm': '576px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1408px',

                    },
                    container: {
                        center: true,
                    },
                }
            }
        }
    </script>
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'Averta': ['"Averta"'],
                    },
                    screens: {
                        'sm': '576px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1408px',

                    },
                    container: {
                        center: true,
                    },
                }
            }
        }
    </script>
</head>
<body class="wrapper mx-auto xxl:text-[16px] sm:text-[14px] text-[12px] text-[#454545] leading-snug overflow-x-hidden bg-[#EEEAEA]">
    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('main'); ?>
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo vanhenry\helpers\helpers\SettingHelper::getSetting('CMS_FOOTER') ?>
    <script src="<?php echo e(Support::asset('theme/frontend/js/xhr.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/validator.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/toastify.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/tech5s_js/tech5s_base.min.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/tech5s_js/libraries/Tech.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/tech5s_js/libraries/BackToTop.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/wow.min.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/fslightbox.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/swiper-bundle.min.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/tabs.js')); ?>" defer></script>
    <?php echo $__env->yieldContent('jsl'); ?>
    <script src="<?php echo e(Support::asset('theme/frontend/js/base.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/cart.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/slider.js')); ?>" defer></script>
    <script src="<?php echo e(Support::asset('theme/frontend/js/script.js')); ?>" defer></script>
    <?php echo $__env->yieldContent('js'); ?>
    <script src="<?php echo e(Support::asset('theme/frontend/js/add/script.js')); ?>" defer></script>
</body>

</html>
<?php /**PATH D:\laragon\www\timepro\resources\views/index.blade.php ENDPATH**/ ?>
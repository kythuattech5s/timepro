
<?php $__env->startSection('main'); ?>
    <form action="<?php echo e(\VRoute::get("login")); ?>" class="formValidation" method="post" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
        <?php echo csrf_field(); ?>
        <input type="text" name="username" placeholder="Nhập email hoặc số điện thoại" rules="required||email">
        <input type="password" name="password" placeholder="Nhập mật khẩu" rules="required">
        <button type="submit">Đăng nhập</button>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\laragon\www\timepro\resources\views/auth/login.blade.php ENDPATH**/ ?>

<?php $__env->startSection('main'); ?>
    <form action="<?php echo e(\VRoute::get('register')); ?>" class="formValidation" method="post" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
        <?php echo csrf_field(); ?>
        <input type="text" name="name" rules="required" placeholder="Họ và tên">
        <input type="text" name="email" rules="required||email" placeholder="Nhập email của bạn">
        <input type="text" name="phone" rules="required" placeholder="Nhập số điện thoại của bạn">
        <input type="password" name="password" rules="required" placeholder="Nhập mật khẩu">
        <input type="password" name="password_confirmation" rules="required" placeholder="Xác nhận lại mật khẩu">
        <button type="submit">Đăng ký</button>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\timepro\resources\views/auth/register.blade.php ENDPATH**/ ?>
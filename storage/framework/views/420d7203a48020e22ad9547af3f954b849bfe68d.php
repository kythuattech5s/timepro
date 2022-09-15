
<?php $__env->startSection('content'); ?>
    <?php if(isset($gaViewKey) && $gaViewKey !=''): ?>
        <?php echo $__env->make('vh::statistical_google_analytics', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <p>Xin chào <strong><?php echo e(Auth::guard('h_users')->user()->name); ?></strong></p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('vh::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\laragon\www\timepro\packages\vanhenry\manager\src/views/dashboard.blade.php ENDPATH**/ ?>
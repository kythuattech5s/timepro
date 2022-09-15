<?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php echo $__env->make('commentRS::item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="no-result">
        Chưa có bài đánh giá.
    </div>
<?php endif; ?>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/comment.blade.php ENDPATH**/ ?>
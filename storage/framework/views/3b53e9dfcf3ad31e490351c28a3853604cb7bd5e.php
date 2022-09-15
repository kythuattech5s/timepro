<?php $__currentLoopData = $childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commentChild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php echo $__env->make('commentRS::comment_child', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/comment_childs.blade.php ENDPATH**/ ?>
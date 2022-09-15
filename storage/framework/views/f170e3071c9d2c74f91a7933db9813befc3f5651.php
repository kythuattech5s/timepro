<div class="rating-score">
    <p class="score-big"><?php echo e($ratings['scoreAll']); ?></p>
    <?php echo $__env->make('commentRS::rating',['rating'=>$ratings['percentAll'].'%'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <p class="count-comment mt-2"><?php echo e($ratings['totalRating']); ?> đánh giá</p>
</div>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/ratingScore.blade.php ENDPATH**/ ?>
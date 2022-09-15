<div class='comment-box__score'>
    <div class="comment-score-big">
        <?php echo e($ratings['scoreAll']); ?>

    </div>
    <div class="comment-score-big__rating d-flex flex-column align-items-center me-3">
        <p><i class="fa fa-star"></i></p>
        <p class="comment-score-max">/5</p>
    </div>
    <div>
        <p class="comment-name-score"><?php echo e(Support::show($ratings,'typePercent')); ?></p>
        <p class="comment-total-rating">Dựa trên <?php echo e(Support::show($ratings,'totalRating')); ?> bài đánh giá</p>
    </div>
</div>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/style/score_two.blade.php ENDPATH**/ ?>
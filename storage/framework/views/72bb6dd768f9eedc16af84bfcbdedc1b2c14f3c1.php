<div class='comment-box__score' three>
    <div class="rating-score">
        <p class="score-big"><?php echo e($ratings['scoreAll']); ?>/5 <span><i class="fa fa-star"></i></span></p>
        <p class="count-comment mt-2">Đánh giá trung bình</p>
    </div>
    <?php echo $__env->make('commentRS::ratingList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <button type="button" class="p-3 bg-gradient-to-r from-[#F44336] to-[#C62828] mx-[18px] rounded-[5px] px-[8] py-[10px] text-white" onclick="COMMENT.focusTextarea(this)" >Bình luận ngay</button>
</div>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/style/score_three.blade.php ENDPATH**/ ?>
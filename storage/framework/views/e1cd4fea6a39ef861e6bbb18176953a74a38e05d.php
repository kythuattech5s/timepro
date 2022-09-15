<div class="comment-box__content <?php echo e(config('cmrsc_comment.class')); ?>">
    <p class="title-medium__all f-bold cl-blue mb-15"><?php echo e($comments->total()); ?> đánh giá cho khóa học Tìm khách hàng khó hay dễ?</p>
    <?php if(config('cmrsc_comment.hasShowTotal')): ?>
        <div class="box-percent-load">
            <?php echo $__env->make('commentRS::box_percent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php endif; ?>
    <?php if(config('cmrsc_comment.hasFilter')): ?>
        <div class="comment-line"></div>
        <div class="comment-box__filter">
            <?php echo $__env->make('commentRS::comment_filter', ['map_table' => $map_table], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php endif; ?>
    <div class="comment-box__list" <?php if(config('cmrsc_comment.insertAfter')): ?> after <?php endif; ?>>
        <?php echo $__env->make('commentRS::comment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php if(config('cmrsc_comment.isPaginate')): ?>
        <?php echo e($comments->withQueryString()->links('vendor.pagination.pagination')); ?>

    <?php else: ?>
        <?php if($comments->lastPage() > $comments->currentPage()): ?>
            <button type="button" class="more-comment" page-table="<?php echo e($map_table); ?>" page-id="<?php echo Support::show($currentItem, 'id') ?>" page-current="<?php echo e($comments->currentPage()); ?>">Xem thêm</button>
        <?php endif; ?>
    <?php endif; ?>
    <?php echo $__env->make('commentRS::comment_form', ['map_table' => $map_table], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/comment_box.blade.php ENDPATH**/ ?>
<div class="comment-item">
    <div class="comment-item__top">
        <?php
            $user = $comment->user;
        ?>
        <?php if(config('cmrsc_comment.hasAvatar')): ?>
            <div class="comment-item__img" style="background-image:url(<?php echo vanhenry\helpers\helpers\FCHelper::eimg2($user,'img','390x0'); ?>)" comment-skeleton>
            </div>
        <?php endif; ?>
        <div class="comment-item__info">
            <div class="comment-user__info">
                <p class="user-info__name" comment-skeleton>
                    <?php echo e($comment->name ?? ($user->name ?? ($user->email ?? ''))); ?>

                </p>
                <p class="content-plus-comment gap-1">
                    <label class="comment-check" comment-skeleton>
                        <img src="<?php echo Support::asset('comment/images/check.svg')?>" alt="">
                    </label>
                    <span comment-skeleton>Học viên tại Timespro</span>
                </p>
                <span class="comment-item__datetime ml-auto" comment-skeleton><?php echo e(RSCustom::showTime($comment->created_at)); ?></span>
            </div>
            <?php if(($ratingInfo = $comment->rating) !== null): ?>
                <div class="comment-rating-group flex items-center">
                    <?php echo $__env->make('commentRS::rating', ['rating' => $ratingInfo->rating * 20 . '%', 'attribute' => 'comment-skeleton'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php if(config('cmrsc_comment.hasLabel')): ?>
                        <span class="comment-rating-label" comment-skeleton><?php echo e($ratingInfo->getLabel()); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="comment-item__content" comment-skeleton>
                <?php echo Support::show($comment, 'content') ?>
            </div>
            <div class="comment-item__imgs">
                <?php
                    $imgs = json_decode($comment->imgs, true);
                ?>
                <?php if($imgs !== null && count($imgs) > 0): ?>
                    <?php $__currentLoopData = $imgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $itemImg = new \stdClass();
                            $itemImg->img = json_encode($item);
                        ?>
                        <div class="comment-img__item" comment-skeleton>
                            <a href="<?php echo vanhenry\helpers\helpers\FCHelper::eimg2($itemImg,'img','-1'); ?>" data-fslightbox="lightbox<?php echo e(Support::show($comment, 'id')); ?>">
                                <?php echo $__env->make('image_loader.tiny', [
                                    'itemImage' => $itemImg,
                                    'key' => 'img',
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <div class="comment-action flex items-center gap-4">
                <?php if(config('cmrsc_comment.hasRep', false)): ?>
                    <a type="button" data-placeholder="Trả lời bình luận" class="group flex cursor-pointer gap-[4px] duration-300 hover:text-[#CD272F]" comment-skeleton button-show-reply>
                        <?php echo $__env->make('commentRS::icon.reply', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <span> Trả lời</span></a>
                <?php endif; ?>
                <?php if(config('cmrsc_comment.hasLike', false)): ?>
                    <?php
                        $user_like = $comment->likes->filter(function ($q) {
                            return $q->user->id == Auth::id();
                        });
                    ?>
                    <a like-comment class="<?php echo e($user_like->count() > 0 ? 'like' : ''); ?> flex gap-[4px] cursor-pointer" data-id="<?php echo Support::show($comment, 'id') ?>" comment-skeleton>
                        <?php echo $__env->make('commentRS::icon.like', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <span>Thích</span>
                    </a>
                <?php endif; ?>
                <?php if(config('cmrsc_comment.hasRep', false)): ?>
                    <div class="rep-comment hidden w-full justify-end" action="<?php echo e(config('cmrsc_comment.repUrl')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="comment_id" value="<?php echo Support::show($comment, 'id') ?>">
                        <input type="hidden" name="map_table" value="<?php echo Support::show($comment, 'map_table') ?>">
                        <input type="hidden" name="map_id" value="<?php echo Support::show($comment, 'map_id') ?>">
                        <div class="flex w-full flex-wrap items-center gap-4 rounded-md bg-[#F5F5F5] px-4 py-[13px]">
                            <div class="group-form flex-1"></div>
                            <button type="submit" button-reply data-placeholder="Nhập câu trả lời..." class="flex space-x-[4px] rounded-md bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-6 font-semibold text-white shadow-[0px_6px_20px_rgba(178,30,37,0.4)]" comment-skeleton>
                                Trả lời
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if(($childs = $comment->childs()->where('act', 1)->paginate(5,['*'],'page',1))->count() > 0): ?>
        <div class="comment-childs">
            <?php $__currentLoopData = $childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commentChild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('commentRS::comment_child', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($childs->lastPage() > $childs->currentPage()): ?>
            <button type="button" class="more-comment--child" page-current="<?php echo e($childs->currentPage()); ?>">Xem thêm</button>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/item.blade.php ENDPATH**/ ?>
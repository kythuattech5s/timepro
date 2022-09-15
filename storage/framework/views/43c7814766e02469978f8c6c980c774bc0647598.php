<div class="comment-item">
    <div class="comment-item__top">
        <?php
            $user = $commentChild->user;
        ?>
        <?php if(config('cmrsc_comment.hasAvatar',false)): ?>
            <div class="comment-item__img" style="background-image:url(<?php echo vanhenry\helpers\helpers\FCHelper::eimg2($user,'img','390x0'); ?>)" comment-skeleton>
            </div>
        <?php endif; ?>
        <div class="comment-item__info">
            <div class="comment-user__info">
                <p class="user-info__name" comment-skeleton>
                    <?php echo e($user->name ?? $user->email ?? 'Quản trị viên'); ?>

                </p>
                <span class="comment-item__datetime" comment-skeleton><?php echo e(RSCustom::showTime($commentChild->created_at, false)); ?></span>
            </div>
            <div class="comment-item__content" comment-skeleton>
                <?php echo Support::show($commentChild, 'content') ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/comment_child.blade.php ENDPATH**/ ?>
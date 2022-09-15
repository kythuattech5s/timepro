<p class="comment-box__title mt-4">Đánh giá và bình luận</p>
<div class="comment-box__form pb-2">
    
    <?php if(config('cmrsc_comment.checkUser', false)): ?>
        <?php
            $user = Auth::user();
        ?>
        <div class="comment-box__form-img"
             style="background-image:url('<?php echo vanhenry\helpers\helpers\FCHelper::eimg2($user,'img','390x0'); ?>')">
        </div>
    <?php endif; ?>
    <form action="<?php echo e(config('cmrsc_comment.url')); ?>" clear method="POST" class="formComment form-validate" parent=".form-alert-error" <?php if(config('cmrsc_comment.fields.hasImages')): ?> gallery <?php endif; ?> enctype="multipart/form-data" data-success="COMMENT.receivedComment" check>
        <?php echo csrf_field(); ?>
        <div class="mb-2 flex flex-col">
            <?php if(config('cmrsc_comment.hasRating', false)): ?>
                <div class="form-alert-error" m-required="Vui lòng đánh giá">
                    <?php echo $__env->make('commentRS::selectStar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php endif; ?>
            <?php if(config('cmrsc_comment.fields.hasImages')): ?>
                <ul class="gallery-preview" data-gallery>
                </ul>
            <?php endif; ?>
        </div>
        <input type="hidden" name="map_id" value="<?php echo Support::show($currentItem, 'id') ?>">
        <input type="hidden" name="map_table" value="<?php echo e($map_table); ?>">
        <div>
            <textarea name="content" placeholder="Bình luận" m-required="Hãy để lại bình luận" cols="26" rules="required"></textarea>
        </div>
        <div class="formComment__action">
            <button class="btn btn--orange" type="submit">Bình luận</button>
            <?php if(config('cmrsc_comment.fields.hasImages')): ?>
                <label for="formComment__file" class="formComment__label formComment__label--upload">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                    <span>Upload</span>
                    <input type="file" id="formComment__file" name="images" multiple input-file>
                </label>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/comment_form.blade.php ENDPATH**/ ?>
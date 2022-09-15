<?php if(config('cmrsc_comment.style') == 'ONE'): ?>
	<div class="comment-box__percent">
		<?php echo $__env->make('commentRS::ratingScore', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->make('commentRS::ratingList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>
<?php elseif(config('cmrsc_comment.style') == 'THREE'): ?>
	<?php echo $__env->make('commentRS::style.score_three', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php elseif(config('cmrsc_conmment.style') == 'FOUR'): ?>
    <?php echo $__env->make('commentRS::style.score_four', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
	<?php echo $__env->make('commentRS::style.score_two', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/box_percent.blade.php ENDPATH**/ ?>
<?php if($paginator->hasPages()): ?>
    <div class="pagination wow fadeInUp">
        
        <?php if(!$paginator->onFirstPage()): ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            <?php if(!in_array($paginator->currentPage(), [1, 2])): ?>
                <a href="<?php echo e($paginator->url(1)); ?>" >1</a></li>
                <?php if($paginator->currentPage() !== 3): ?>
                    <a style="pointer-events: none"> ... </a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <strong><?php echo e($page); ?></strong>
                    <?php elseif($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() - 1): ?>
                        <a href="<?php echo e($url); ?>" ><?php echo e($page); ?></a></li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <?php if($paginator->hasMorePages()): ?>
            <?php if(!in_array($paginator->currentPage(),[$paginator->lastPage(),$paginator->lastPage()-1])): ?>
                <?php if($paginator->currentPage() !== $paginator->lastPage()-2): ?>
                <a style="pointer-events: none"> ... </a>
                <?php endif; ?>
                <a href="<?php echo e($paginator->url($paginator->lastPage())); ?>" ><?php echo e($page); ?></a></li>
            <?php endif; ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
        <?php endif; ?>
    </div>
<?php endif; ?><?php /**PATH D:\laragon\www\timepro\packages\vanhenry\manager\src/views/vendor/pagination/pagination.blade.php ENDPATH**/ ?>
<div class="rating-select" <?php if(isset($size) && $size): ?> style="--font-size-select:<?php echo e($size); ?>px" <?php endif; ?>>
    <div class="rating">
        <?php for($i = 5; $i > 0; $i--): ?>
            <input class="star star-<?php echo e($i); ?>" rules="required" id="star-<?php echo e(isset($keySelectStar) ? $keySelectStar . '-' : ''); ?><?php echo e($i); ?>" type="radio"
                   value="<?php echo e($i); ?>" name="<?php echo e($name ?? 'rate'); ?><?php echo e(isset($keySelectStar) ? '-' . $keySelectStar : ''); ?>" <?php if(isset($rate) && $rate && $rate == $i): ?> checked <?php endif; ?> <?php if(isset($rate) && $rate && $rate != $i): ?> disabled <?php endif; ?> />
            <label class="star star-<?php echo e($i); ?>" for="star-<?php echo e(isset($keySelectStar) ? $keySelectStar . '-' : ''); ?><?php echo e($i); ?>"></label>
        <?php endfor; ?>
    </div>
</div>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/selectStar.blade.php ENDPATH**/ ?>
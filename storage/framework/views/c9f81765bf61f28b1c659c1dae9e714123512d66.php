<div class="filter-group">
    <?php
        $value = isset($dataSearch['raw_' . $search->name]) ? $dataSearch['raw_' . $search->name] : '';
    ?>
    <input type="text" name="raw_<?php echo e($search->name); ?>" placeholder="<?php echo e($search->note); ?>" value="<?php echo e($value); ?>">
</div><?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctsearch/text.blade.php ENDPATH**/ ?>
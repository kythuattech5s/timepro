<input name="search-<?php echo e($search->name); ?>" value="none" type="hidden">
<input name="type-<?php echo e($search->name); ?>" value="DATETIME" type="hidden">
<div class="filter-group">
    <?php
        if (isset($dataSearch['from-' . $search->name])) {
            $valueFrom = $dataSearch['from-' . $search->name];
        } else {
            $valueFrom = '';
        }

        if (isset($dataSearch['to-' . $search->name])) {
            $valueTo = $dataSearch['to-' . $search->name];
        } else {
            $valueTo = '';
        }
    ?>
    <input type="text" class="datepicker-filter" name="from-<?php echo e($search->name); ?>"
        placeholder="-- <?php echo e($search->note); ?> từ --" value="<?php echo e($valueFrom); ?>" autocomplete="off">
    <input type="text" class="datepicker-filter" name="to-<?php echo e($search->name); ?>"
        placeholder="-- <?php echo e($search->note); ?> đến --" value="<?php echo e($valueTo); ?>" autocomplete="off">
</div><?php /**PATH D:\laragon\www\timepro\/packages/vanhenry/views/ctsearch/datetime.blade.php ENDPATH**/ ?>
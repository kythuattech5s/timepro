<?php

$name = FCHelper::er($table, 'name');

$value = '';

if ($actionType == 'edit') {
    $value = FCHelper::er($dataItem, $name);
}

?>

<input type="hidden" name="<?php echo e($name); ?>"
	dt-type="<?php echo e(FCHelper::er($table, 'type_show')); ?>" value="<?php echo e($value); ?>">
<?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctedit/primary_key.blade.php ENDPATH**/ ?>
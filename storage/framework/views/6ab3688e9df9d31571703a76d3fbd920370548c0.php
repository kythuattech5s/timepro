<?php
$name = FCHelper::er($table, 'name');
$valueShow = date('d/m/Y H:i:s');
$valueHidden = date('Y-m-d H:i:s');
if ($actionType == 'edit' || $actionType == 'copy') {
    $value = FCHelper::ep($dataItem, $name);
    if (!is_null($value) && strtotime($value) > 0){
        $valueShow = $value;
        $valueHidden = $value;
    }
}
?>
<div class="form-group">
	<p class="form-title" for=""><?php echo e(FCHelper::ep($table, 'note', 1)); ?> <p/>
    <input value="<?php echo e($valueHidden); ?>" class="form-control" type="date" placeholder="<?php echo e(FCHelper::er($table, 'note')); ?>" <?php echo e(FCHelper::ep($table, 'require') == 1 ? 'required' : ''); ?> name="<?php echo e($name); ?>">
</div><?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctedit/date.blade.php ENDPATH**/ ?>
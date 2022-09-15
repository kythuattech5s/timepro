<?php 
$table = FCHelper::ep($arrData,'table');
$where = FCHelper::ep($arrData,'where');
$select = FCHelper::ep($arrData,'select');
$field_base = FCHelper::ep($arrData,'field_base');
$default = FCHelper::ep($arrData,'default');
$simpleDefault = array();
foreach ($default as $_key => $_value) {
	array_push($simpleDefault, $_key);
}
$select = vanhenry\helpers\helpers\StringHelper::isNull($select)?"id,name":$select;
$select = explode(',', $select);
$fullSelect = array();
$select = array_merge($select,$fullSelect);
$database = Config::get('database.connections.'.Config::get('database.default').'.database');
$isMultiselect = FCHelper::ep($arrConfig,'multiselect');
$arrTmp = Cache::remember('_vh_admin_view_select_'.$tableData->get($table,'')."_".$show->name, 10, function() use($select,$where,$table,$transTable) {
	if ($transTable != null) {
		$langChoose = FCHelper::langChooseOfTable($table);
		$q = DB::table($table)->select($select)->join($transTable->table_map, 'id', '=', 'map_id')->where('language_code', $langChoose);
	}
	else{
		$q = DB::table($table)->select($select);
	}
	if($where !=null && count($where)>0){
		$q = $q->where(array($where));
	}
	return $q->get();
}); 
?>
<?php 
	$currentID = FCHelper::ep($dataItem,$show->name);
?>
<?php $multi = explode(',', $currentID); $arrMerge = array_intersect($multi,$simpleDefault); ?>
<?php if($show->editable == 1 && !$isMultiselect): ?>
<select dt-prop="<?php echo e($show->is_prop ?? 0); ?>" dt-prop-id="<?php echo e($show->id); ?>" name="<?php echo e($show->name); ?>" class="select2 editable" table="<?php echo e($show->parent_name); ?>" style="width: 150px">
	<option value="0">Không xác định</option>
	<?php $__currentLoopData = $arrTmp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<option value="<?php echo e($value->id); ?>" <?php echo e($value->id == $currentID?"selected":""); ?>><?php echo e($value->name); ?></option>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php else: ?>
	<?php if(count($arrMerge)>0): ?>
		<?php $__currentLoopData = $arrMerge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<p class="select static-select" dt-value="<?php echo e($m); ?>"><?php echo e(FCHelper::ep($default[$m],'value',1)); ?></p>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>
	<?php $__currentLoopData = $arrTmp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php if($isMultiselect): ?>
			<?php if(in_array($value->id,$multi)): ?>
			<p class="select static-select" dt-value="<?php echo e($value->id); ?>"><?php echo e(FCHelper::ep($value,$select[1])); ?></p>
			<?php endif; ?>
		<?php else: ?>
			<?php if($value->id == $currentID): ?>
			<p class="select static-select" dt-value="<?php echo e($value->id); ?>"><?php echo e(FCHelper::ep($value,$select[1])); ?></p>
			<?php else: ?>
				<?php if(array_key_exists($currentID,$default)): ?>
				<p class="select static-select" dt-value="<?php echo e($currentID); ?>"><?php echo e(FCHelper::ep($default,'value',1)); ?></p>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctview/select/not_default.blade.php ENDPATH**/ ?>
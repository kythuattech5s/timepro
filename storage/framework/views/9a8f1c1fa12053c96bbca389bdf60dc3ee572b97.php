<?php 
    $table = FCHelper::ep($arrData,'table');
    $relationship = FCHelper::ep($arrData,'relationship');
    $field_show = FCHelper::ep($arrData,'field_show');
    $isAjax = FCHelper::ep($arrConfig, 'ajax');
    $tableMain = $show->parent_name;
    $fieldsSelect = explode(',',$arrData['select']);
    $fieldMain = $fieldsSelect[0];
    $defaultData = collect(FCHelper::ep($arrData,'default'));

    $dataFilter = $defaultData->first(function($q, $key) use($dataItem,$show){
        return $key == $dataItem[$show->name];
    });
?>
<?php if($show->editable == 1): ?>
    <?php
        $dataList = collect();
        if($isAjax == 0){
            $dataList =  Collect(FCHelper::getDataList($table, $tableMain, $show->name , $fieldsSelect));
        }
    ?>
    <select <?php if($isAjax == 1): ?> data-lang="<?php echo e(App::getLocale()); ?>" admin-cp="<?php echo e($admincp); ?>" data-table="<?php echo e($table); ?>" data-default="<?php echo e(json_encode($defaultData,JSON_UNESCAPED_UNICODE)); ?>" data-field-select="<?php echo e(implode(',',$fieldsSelect)); ?>" editable-field <?php endif; ?> name="<?php echo e($show->name); ?>" dt-prop-id="<?php echo e($show->id); ?>" dt-prop="<?php echo e($show->is_prop ?? 0); ?>"  class="select2 editable" table="<?php echo e($show->parent_name); ?>" table="<?php echo e($tableMain); ?>" style="width: 150px">
    <?php if($isAjax == 1 && $dataItem->$relationship): ?>
        <option value="<?php echo e($dataItem->$relationship->id); ?>" selected><?php echo e($dataItem->$relationship->$field_show); ?></option>
    <?php elseif($dataFilter): ?>
        <option value="<?php echo e($dataItem[$show->name]); ?>" selected><?php echo e($dataFilter[App::getLocale().'_value']); ?></option>
    <?php endif; ?>
    
	<?php $__currentLoopData = $dataList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e(FCHelper::ep($item, $fieldMain)); ?>" <?php if(!is_null($dataItem->$relationship) && $dataItem->$relationship->id  == $item->$fieldMain): ?> selected <?php endif; ?>><?php echo e(FCHelper::ep($item, $field_show)); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php elseif($dataItem->$relationship): ?>
	<p class="select static-select" dt-value="<?php echo e($dataItem->$relationship->id); ?>"><?php echo e($dataItem->$relationship->$field_show); ?></p>
<?php elseif($dataFilter): ?>
	<p class="select static-select" dt-value="<?php echo e($dataItem[$show->name]); ?>"><?php echo e($dataFilter[App::getLocale().'_value']); ?></p>
<?php endif; ?>


<?php /**PATH D:\laragon\www\timepro\/packages/vanhenry/views/ctview/select/normal.blade.php ENDPATH**/ ?>
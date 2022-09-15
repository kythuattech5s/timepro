<?php $data= $arrData;
$tableMap = $data['table'];
$dataMapDefault = [];
$isAjax = (isset($default_data['config']['ajax'])?$default_data['config']['ajax']:"")==1;
$intersectData1 =array();
$intersectData2 =array();
$value ="";
if($actionType=='edit'||$actionType=='copy'){
	$value = FCHelper::er($dataItem,$name);
	$dataMap = vanhenry\manager\helpers\DetailTableHelper::getAllDataOfTable($tableMap);
	$arrValue = explode(',', $value);
	$intersectData1 = array_intersect($arrValue, array_keys($dataMapDefault));
	$intersectData2 = array_intersect($arrValue, array_keys($dataMap));
}
?>
<div class="form-group ">
  <p class="form-title" for=""><?php echo e(FCHelper::ep($table,'note')); ?><p/>
  <div class="form-control form-reset flex">
    <select <?php echo e(FCHelper::ep($table,'require')==1?'required':''); ?> style="width:100%" placeholder="<?php echo e(FCHelper::ep($table,'note')); ?>" class=" <?php echo e($isAjax?'ajx_search_single_'.$name:'select2'); ?>" name="<?php echo e($name); ?>">
     <?php if($isAjax): ?>
    	<?php if($actionType=='edit'): ?>
    		<?php $__currentLoopData = $intersectData1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id1 =>$vid1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    		<option selected value="<?php echo e($vid1); ?>"><?php echo e(FCHelper::ep($dataMapDefault[$vid1],"value")); ?></option>
    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    		<?php $__currentLoopData = $intersectData2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id2 =>$vid2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    		<option selected value="<?php echo e($vid2); ?>"><?php echo e($dataMap[$vid2]->name); ?></option>
    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	<?php endif; ?>
    <?php else: ?>
    	<?php 
    		$arrData = vanhenry\manager\helpers\DetailTableHelper::recursiveDataTable($default_data['data']);
    		$arrData = $arrData->sortBy('id');
    		vanhenry\manager\helpers\DetailTableHelper::printOptionRecursiveData($arrData,0,$dataMapDefault,$intersectData1,$intersectData2,$default_data['data']);
    	?>
    <?php endif; ?>
	</select>
  </div>
  
</div>
<?php if($isAjax): ?>
<script type="text/javascript">
$(function() {
	$('.ajx_search_single_<?php echo e($name); ?>').select2({
	   ajax: {
	    url: "<?php echo e($admincp); ?>/getData/<?php echo e($tableMap); ?>",
	    dataType: 'json',
	    data: function (params) {
	      return {
	        q: params.term, 
	        page: params.page
	      };
	    },
	    processResults: function (data, page) {
	      return data;
	    },
	    cache: true
	  },
	  minimumInputLength: 1,
	  language:"<?php echo e(App::getLocale()); ?>",
});
});
	
</script>
<?php endif; ?><?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctedit/select/not_default.blade.php ENDPATH**/ ?>
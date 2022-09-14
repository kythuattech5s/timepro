<?php 
$name = FCHelper::er($table,'name');
$default_code = FCHelper::er($table,'default_code');
$default_code = json_decode($default_code,true);
$default_code = @$default_code?$default_code:array();
$value ="";
$img = 'admin/images/noimage.png';
if($actionType=='edit'||$actionType=='copy'){
	$value = FCHelper::ep($dataItem,$name);
	$tmp = json_decode($value,true);
	$filePath = isset($tmp) && is_array($tmp) ?$tmp["path"].$tmp["file_name"] : ''; 
}
?>
<div class="row">
	<p class="col-xs-12 form-title"><?php echo e(FCHelper::ep(($tableMap=='configs'?$dataItem:$table),'note')); ?></p>
	<div class="col-xs-12">
		<img src="<?php echo e($img); ?>" style="display: none" class="<?php echo e($name); ?> w100">
		<input placeholder="<?php echo e(FCHelper::er($table,'note')); ?>" class="<?php echo e($name); ?>" type="hidden" value="<?php echo e($value); ?>" name="<?php echo e($name); ?>" id="<?php echo e($name); ?>">
		<input type="text" id="preview_<?php echo e($name); ?>" class="form-control" value="<?php echo e($filePath ?? ''); ?>">
		<div class="form-group textcenter">
			<a href="<?php echo e($admincp); ?>/media/view?istiny=<?php echo e($name); ?>" class="browseimage bgmain btn btn-primary iframe-btn" type="button">Chọn File</a>
			<button style="margin-top: 15px;margin-left: 5px;" class="btndelete-<?php echo e($name); ?> bgmain btn btn-primary"><?php echo e(trans('db::delete')); ?></button>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('.btndelete-<?php echo e($name); ?>').click(function(event) {
			event.preventDefault();
			$("input[name='<?php echo e($name); ?>']").val("");
			$("input[name='<?php echo e($name); ?>']").prev().attr("src","");
			$('#preview_<?php echo e($name); ?>').val("");
		});
		$(document).on('change', 'input[name=<?php echo e($name); ?>]', function(event) {
			var infoFile = JSON.parse($(this).val());
			$('#preview_<?php echo e($name); ?>').val(infoFile.path+infoFile.file_name);
		});
	});
</script><?php /**PATH C:\laragon\www\timepro\/packages/vanhenry/views/ctedit/filev2.blade.php ENDPATH**/ ?>
<?php 
	$name = FCHelper::er($table,'name');
	
	$value ="";
	if($actionType=='edit'||$actionType=='copy'){
		$value = FCHelper::ep($dataItem,$name);
	}
?>
<div class="form-group">
  <p class="form-title" for=""><?php echo e(FCHelper::ep($table,'note')); ?> <span class="count"></span></p>
  <input placeholder="<?php echo e(FCHelper::er($table,'note')); ?>" <?php echo e(FCHelper::ep($table,'require')==1?'required':''); ?>  class="ccb _<?php echo e($name); ?>" type="checkbox" data-off-label="false" data-on-label="false" data-off-icon-cls="glyphicon-remove" <?php echo e($value == 1?'checked':''); ?> data-on-icon-cls="glyphicon-ok">
  <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
</div>

<script type="text/javascript">
	$(function() {
		$('input._<?php echo e($name); ?>').change(function(event) {
			var v = $(this).is(':checked')?1:0;
			$('input[name=<?php echo e($name); ?>]').val(v);
		});
	});
</script>
<?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctedit/checkbox_button.blade.php ENDPATH**/ ?>
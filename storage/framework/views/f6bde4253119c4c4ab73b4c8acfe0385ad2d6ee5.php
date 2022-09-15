<?php 
$name = FCHelper::er($table,'name');
$default_code = FCHelper::er($table,'default_code');
$default_code = json_decode($default_code,true);
$default_code = @$default_code?$default_code:array();
$value ="";
if($actionType=='edit'||$actionType=='copy'){
	$value = FCHelper::er($dataItem,$name);
	}
 ?>
<div class="form-group">
  <p class="form-title" for=""><?php echo e(FCHelper::ep($table,'note')); ?> <span class="count"></span></p>
  <input  <?php echo e(FCHelper::ep($table,'require')==1?'required':''); ?> type="text" name="<?php echo e($name); ?>" placeholder="<?php echo e(FCHelper::er($table,'note')); ?>"  class="form-control" dt-type="<?php echo e(FCHelper::er($table,'type_show')); ?>" value="<?php echo e($value); ?>" />
</div>
<script type="text/javascript">
	$(function() {
		$(document).on('change', 'input[name=<?php echo e($name); ?>]', function(event) {
			event.preventDefault();
			var val = $(this).val();
			if(val.indexOf("$")==0){
				return;
			}
			var _this = this;
			$.ajax({
				url: '<?php echo e($admincp); ?>/getCrypt',
				type: 'POST',
				data: {pass: $(this).val()},
			})
			.done(function(data) {
				$(_this).val(data);
			});
			
		});
	});
</script><?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctedit/password.blade.php ENDPATH**/ ?>
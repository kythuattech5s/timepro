<?php 
$name = FCHelper::er($table,'name');
$default_code = FCHelper::er($table,'default_code');
$default_code = json_decode($default_code,true);
$default_code = @$default_code?$default_code:array();
$value ="";
if($actionType=='edit'||$actionType=='copy'){
	$value = FCHelper::er($dataItem,$name);
}
$lang = \Session::get('_table_lang') != null ? \Session::get('_table_lang')[array_key_first(\Session::get('_table_lang'))] : Config::get('app.locale_origin');
if($lang == "en"){
	$langSlug = "en/";
}else{
	$langSlug = "";
}
?>

<div class="form-group">
	<p class="form-title" for=""><?php echo e(trans('db::link')); ?></p>
	<p><input style="width:100%" <?php echo e(FCHelper::ep($table,'require')==1?'required':''); ?> type="text" name="<?php echo e($name); ?>"  class="noborder" dt-type="<?php echo e(FCHelper::ep($table,'type_show')); ?>" placeholder="<?php echo e(FCHelper::er($table,'note')); ?>-<?php echo e(trans('db::suggest_link')); ?>" value="<?php echo e($value); ?>" />
		<?php if($actionType=='edit'): ?>
		<button type="button" class="bgmain btnmall clfff preview-<?php echo e($name); ?>">
			<i class="fa fa-eye clfff"></i>
		Xem trước</button>
		<?php endif; ?>
	</p>
	
</div>
<script type="text/javascript">
	$(function() {
		<?php $__currentLoopData = $default_code; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		$(document).on('input', "<?php echo e($dc['source']); ?>", function(event) {
			event.preventDefault();
			<?php if($dc['function']=='slug' && $actionType!='edit'): ?>
			var input = $(this).val();
			var output = TECH.replaceUrl(input);
			
			$("input[name=<?php echo e($name); ?>]").val(output);
			$('a._<?php echo e($name); ?>').attr('href',output).text(output);
			<?php endif; ?>
		});
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		$('input[name=<?php echo e($name); ?>]').dblclick(function(event) {
			$(this).removeClass('noborder').addClass('border');
		}).focusout(function(event) {
			$(this).removeClass('border').addClass('noborder');
		});;

		$(".preview-<?php echo e($name); ?>").click(function(event) {
			var win = window.open($('base').attr('href')+'<?php echo $langSlug ?>'+$(this).prev().val(), '_blank');
			win.focus();
		});
	});
</script><?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctedit/slug.blade.php ENDPATH**/ ?>
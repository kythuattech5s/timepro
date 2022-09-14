<?php 
$name = FCHelper::er($table,'name');
$valueShow =date("d/m/Y H:i:s");
$valueHidden = date("Y-m-d H:i:s");
if($actionType=='edit'||$actionType=='copy'){
	$value = FCHelper::ep($dataItem,$name);
  if($value==""){
    // $valueShow = date("d/m/Y H:i:s");
    // $valueHidden = date("Y-m-d H:i:s");
  }
  else{
    if( strtotime($value) <0 ){
    }
    else{
      $valueShow = \DateTime::createFromFormat('Y-m-d H:i:s', $value)->format('d/m/Y H:i:s');
      $valueHidden = $value;  
    }
    
  }
	
}
 ?>
<div class="form-group ">
  <p class="form-title" for=""><?php echo e(FCHelper::ep($table,'note',1)); ?><p/>
  <div class="form-control flex">
    <i class="fa fa-calendar"></i>
    <input value="<?php echo e($valueShow); ?>"   dt-type="<?php echo e(FCHelper::er($table,'type_show')); ?>" class="date-control datepicker" type="text" />
    <input value="<?php echo e($valueHidden); ?>"  placeholder="<?php echo e(FCHelper::er($table,'note')); ?>" <?php echo e(FCHelper::ep($table,'require')==1?'required':''); ?>  type="hidden" name="<?php echo e($name); ?>">
  </div>
</div>
<script type="text/javascript">
	$(function() {
		$.datetimepicker.setLocale('<?php echo e(App::getLocale()); ?>');
	});
</script><?php /**PATH C:\laragon\www\timepro\/packages/vanhenry/views/ctedit/datetime.blade.php ENDPATH**/ ?>
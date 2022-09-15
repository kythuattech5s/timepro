<td data-title="<?php echo e($show->note); ?>">
<?php $defaultData = FCHelper::ep($show,"default_data"); 
$arrKey = json_decode($defaultData,true);
$arrData = FCHelper::er($arrKey,'data');
$arrConfig = FCHelper::er($arrKey,'config');
$source = FCHelper::er($arrConfig,'source'); 
?>
<?php if(View::exists('tv::ctview.select.'.$source)): ?>
<?php echo $__env->make('tv::ctview.select.'.$source,array('arrData'=>$arrData,'arrConfig'=> $arrConfig), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</td><?php /**PATH D:\laragon\www\timepro\/packages/vanhenry/views/ctview/select.blade.php ENDPATH**/ ?>
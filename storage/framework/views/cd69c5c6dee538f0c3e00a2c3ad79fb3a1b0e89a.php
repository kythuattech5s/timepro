<?php
    $name = FCHelper::er($table, 'name');
    $default_data = FCHelper::er($table, 'default_data');
    $default_data = json_decode($default_data, true);

    $default_code = FCHelper::er($table, 'default_code');
    $default_code = json_decode($default_code, true);

    $arrData = FCHelper::er($default_data, 'data'); 
    $arrConfig = FCHelper::er($default_data, 'config');
    $source = FCHelper::er($arrConfig, 'source');
?>

<?php if(View::exists('tv::ctedit.select.' . $source)): ?>
	<?php echo $__env->make('tv::ctedit.select.' . $source, ['arrData' => $arrData, 'arrConfig' => $arrConfig, 'default_data' => $default_data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctedit/select.blade.php ENDPATH**/ ?>
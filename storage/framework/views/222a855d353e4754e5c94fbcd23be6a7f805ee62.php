<?php $data = $arrData;
$tableMap = $data['table'];
$dataMapDefault = $data['default'];
$isAjax = (isset($default_data['config']['ajax']) ? $default_data['config']['ajax'] : '') == 1;
$intersectData1 = [];
$intersectData2 = [];
$value = '';
if ($actionType == 'edit' || $actionType == 'copy') {
    $value = FCHelper::er($dataItem, $name);
    $dataMap = vanhenry\manager\helpers\DetailTableHelper::getAllDataOfTable($tableMap);
    $arrValue = explode(',', $value);
    $intersectData1 = array_intersect($arrValue, array_keys($dataMapDefault));
    $intersectData2 = array_intersect($arrValue, array_keys($dataMap));
}
$dataSelect = explode(',', $default_data['data']['select']);
$mainSelect = $dataSelect[1];
$field_main = $dataSelect[0];
?>
<div class="form-group">
    <p class="form-title" for=""><?php echo e(FCHelper::ep($table, 'note')); ?>

        <p />
    <div class="form-control form-reset flex">
        <select <?php echo e(FCHelper::ep($table, 'require') == 1 ? 'required' : ''); ?> style="width:100%" placeholder="<?php echo e(FCHelper::ep($table, 'note')); ?>" class="<?php echo e($isAjax ? 'ajx_search_single_' . $name : 'select2'); ?>" name="<?php echo e($name); ?>">
            <?php if($isAjax): ?>
                <?php if($actionType == 'edit'): ?>
                    <?php $__currentLoopData = $intersectData1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id1 => $vid1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option selected value="<?php echo e($vid1); ?>"><?php echo e(FCHelper::ep($dataMapDefault[$vid1], 'value')); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $intersectData2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id2 => $vid2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option selected value="<?php echo e($vid2); ?>"><?php echo e($dataMap[$vid2]->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php else: ?>
                <?php
                $arrData = vanhenry\manager\helpers\DetailTableHelper::recursiveDataTable($default_data['data']);
                vanhenry\manager\helpers\DetailTableHelper::printOptionRecursiveData($arrData, 0, $dataMapDefault, $intersectData1, $intersectData2, $default_data['data']);
                ?>
            <?php endif; ?>
        </select>
    </div>

</div>
<?php if($isAjax): ?>
    <script type="text/javascript">
        $(function() {
            var timeout;
            $('.ajx_search_single_<?php echo e($name); ?>').select2({
                ajax: {
                    transport: function(params, success, failure) {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => {
                            var request = $.ajax({
                                url: "<?php echo e($admincp); ?>/getData/<?php echo e($tableMap); ?>",
                                data: "POST",
                                data: {
                                    q: params.data.term,
                                    target: '<?php echo e(implode(',', $dataSelect)); ?>',
                                    page: params.data.page
                                }
                            });
                            request.then(res => {
                                try {
                                    success(JSON.parse(res));
                                } catch (err) {}
                            });
                        }, 350);
                    },
                    processResults: function(data, page) {
                        return data;
                    },
                    cache: true
                },
                minimumInputLength: 1,
                language: "<?php echo e(App::getLocale()); ?>",
            });
        });
    </script>
<?php endif; ?>
<?php /**PATH C:\laragon\www\timepro\/packages/vanhenry/views/ctedit/select/normal.blade.php ENDPATH**/ ?>
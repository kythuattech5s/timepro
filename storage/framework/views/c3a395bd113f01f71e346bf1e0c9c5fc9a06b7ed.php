<?php if(strtolower($search->type_show) == 'pivot'): ?>
    <input name="search-<?php echo e($search->name); ?>" value="none" type="hidden">
    <input name="type-<?php echo e($search->name); ?>" value="PIVOT" type="hidden">
<?php endif; ?>
<?php
    $name = strtolower($search->type_show) == 'pivot' ? $search->name  : 'raw_' . $search->name;
    $dataDefault = json_decode($search->default_data, true);
    $isAjax = isset($dataDefault['isAjaxSearch']) && (int) $dataDefault['isAjaxSearch'] === 1; 
    $tableMap = $dataDefault['target_table'];
    $dataSelect = $dataDefault['target_select'];

    if (isset($dataDefault['target_table']) && !$isAjax) {
        $dataValues = DB::table($dataDefault['target_table'])->select($dataDefault['target_select'])->get();
    } else{
        $dataValues = [];
    }

    $value = isset($dataSearch[$name]) ? $dataSearch[$name] : false;
    if($value){
        $defaultValue = collect(DB::table($tableMap)->select($dataSelect)->where('id', $value)->first());
    }

?>
<div class="filter-group">
    <select name="<?php echo e(strtolower($search->type_show) == 'pivot' ? '' : 'raw_'); ?><?php echo e($search->name); ?>" id=""
        class="select2 <?php if($isAjax): ?> ajx_search_single_<?php echo e($name); ?> <?php endif; ?>" style="width:250px">
        <option value="">-- <?php echo e($search->note); ?> --</option>
        <?php if(isset($defaultValue)): ?>
            <option value="<?php echo e($defaultValue[$dataSelect[0]]); ?>" selected><?php echo e($defaultValue[$dataSelect[1]]); ?></option>
        <?php endif; ?>
        <?php $__currentLoopData = @$dataValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $type_show_value = strtolower($search->type_show) == 'pivot' ? $search->name : 'raw_' . $search->name;
                if (isset($dataSearch) && isset($dataSearch[$type_show_value]) && $dataSearch[$type_show_value] == ($data->id ?? $data['key'])) {
                    $selectedFilter = 'selected';
                } else {
                    $selectedFilter = '';
                }
            ?>
            <option value="<?php echo e($data->id ?? $data['key']); ?>" <?php echo e($selectedFilter); ?>>
                <?php echo e(FCHelper::ep($data, 'name')); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
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
                                    target: '<?php echo e(implode($dataSelect,',')); ?>',
                                    page: params.data.page
                                }
                            });
                            request.then(res => {
                                try{
                                    success(JSON.parse(res));
                                }catch(err){}
                            });
                        }, 350);
                    },
                    processResults: function(data, page) {
                        const newData = {};
                        newData['results'] = [{
                            id:"",
                            text: `-- <?php echo e($search->note); ?> --`,
                        },...data.results]
                        return newData;
                    },
                    cache: true
                },
                minimumInputLength: 1,
                language: "<?php echo e(App::getLocale()); ?>",
            });
        });
    </script>
<?php endif; ?><?php /**PATH D:\laragon\www\timepro\/packages/vanhenry/views/ctsearch/pivot.blade.php ENDPATH**/ ?>
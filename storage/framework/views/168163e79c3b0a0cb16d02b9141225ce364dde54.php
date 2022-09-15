<?php
    $dataDefault = json_decode($search->default_data, true);
    $config = $dataDefault['config'];
    $data = $dataDefault['data'];
    $source = $config['source'];
    $isAjax = FCHelper::ep($config, 'ajax');
    $table = $search->parent_name;
    $tableMap = FCHelper::ep($data, 'table');
    if (isset($data['select'])) {
        $dataSelect = explode(',', $data['select']);
    }
    $lang = App::getLocale();
    $name = strtolower($search->type_show) == 'pivot' ? '' : 'raw_' . $search->name;
    $_where = isset($data['where']) && is_array($data['where']) ? $data["where"] : array();
    $baseWhere = array();
    foreach ($_where as $k => $v) {
        foreach ($v as $key => $value) {
            $baseWhere[$key] = $value;
        }
    }
    $buildDataDefault = collect();
    if (isset($data['default'])) {
        $defaultDatas = $data['default'];
        foreach ($defaultDatas as $key => $data) {
            $buildDataDefault[] = [
                'id' => $key,
                'text' => $data[$lang . '_value'],
            ];
        }
    }

    $buildDataDefault = $buildDataDefault->toJson();

    if (isset($dataDefault['data']) && isset($dataDefault['data']['table']) && !$isAjax) {
        $dataValues = DB::table($dataDefault['data']['table'])
            ->when(count($baseWhere) > 0,function($q) use ($baseWhere){
                $q->where($baseWhere);
            })
            ->select(explode(',', $dataDefault['data']['select']))
            ->get();
    } elseif (isset($dataDefault['data']) && !$isAjax) {
        $dataValues = $dataDefault['data'];
    } else {
        $dataValues = [];
    }
    $value = isset($dataSearch['raw_' . $search->name]) ? $dataSearch['raw_' . $search->name] : false;
    if ($value && isset($dataSelect)) {
        $defaultValue = collect(
            DB::table($tableMap)
                ->select($dataSelect)
                ->where('id', $value)
                ->first(),
        );
    }
    preg_match('/(.*?)(::)(.+)/', $source, $matches);
    $viewSelect = isset($matches[1], $matches[2], $matches[3]) && $matches[2] == '::' ? $matches[1] . $matches[2] . 'ctsearch.select.' . $matches[3] : 'tv::ctsearch.select.' . StringHelper::normal($source);
    $viewSelect = View::exists($viewSelect) ? $viewSelect : 'tv::ctsearch.select.normal';
?>
<div class="filter-group">
    <?php echo $__env->make($viewSelect, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH D:\laragon\www\timepro\/packages/vanhenry/views/ctsearch/select.blade.php ENDPATH**/ ?>
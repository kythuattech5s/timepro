<?php
    $has_history = $tableData->get('has_history', '') == 1;
    $arrayIncludesHistory = ['news']
?>
<div class="filter-table">
    <?php $advanceSearchs = vanhenry\manager\helpers\DetailTableHelper::filterAdvanceSearch($tableDetailData);  ?>
    <?php $simpleSearch = vanhenry\manager\helpers\DetailTableHelper::filterSimpleSearch($tableDetailData);  ?>
    <?php $simpleSort = vanhenry\manager\helpers\DetailTableHelper::filterSimpleSort($tableDetailData);  ?>
    <?php
        $simple_search_value = isset($dataSearch['raw_' . $simpleSearch->name]) && $dataSearch['raw_' . $simpleSearch->name] !== 'raw_' . $simpleSearch->name ? $dataSearch['raw_' . $simpleSearch->name] : '';
    ?>
    <form id="frmsearch" action="<?php echo e($admincp); ?>/search/<?php echo e($tableData->get('table_map', '')); ?>"
        class="">
        <div class="filter-table__top">
            <div class="group-filter--left">
                <?php if(isset($history_table_name) || ($tableData->get('table_map', '') == 'h_histories' && isset(request()->raw_table_name) && in_array(request()->raw_table_name,$arrayIncludesHistory) )): ?>
                    <input type="hidden" name="raw_table_name" value="<?php echo e($history_table_name ?? request()->raw_table_name); ?>">
                <?php endif; ?>
                <?php if($simpleSearch !== null): ?>
                    <div class="filter-group">
                        <select name="raw_<?php echo e($simpleSearch->name); ?>_type_filter" id="">
                            <option value="~=" <?php echo e(request()->input("raw_".$simpleSearch->name."_type_filter") == '!=' ? 'selected' : ''); ?>>~=</option>
                            <option value="==" <?php echo e(request()->input("raw_".$simpleSearch->name."_type_filter") == '==' ? 'selected' : ''); ?>>=</option>
                        </select>
                        <input type="text" name="raw_<?php echo e($simpleSearch->name); ?>"
                            placeholder="<?php echo e(trans('db::search')); ?> <?php echo e(trans('db::as')); ?> <?php echo e(FCHelper::ep($simpleSearch, 'note')); ?>"
                            value="<?php echo e(@$simple_search_value); ?>">
                    </div>
                <?php endif; ?>
                <?php $__currentLoopData = $advanceSearchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $search): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $viewSearch = strpos(FCHelper::er($search,'type_show'),'::') ? FCHelper::er($search,'type_show').'_view' : 'tv::ctsearch.'.StringHelper::normal(FCHelper::er($search ,'type_show'));
                        $viewSearch = View::exists($viewSearch)?$viewSearch:"tv::ctsearch.base";
                    ?>    
                    <?php echo $__env->make($viewSearch, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            <?php if(isset($history_table_name) || ($tableData->get('table_map', '') == 'h_histories' && isset(request()->raw_table_name) && in_array(request()->raw_table_name,$arrayIncludesHistory) )): ?>
                <a class="refresh ms-2" href="<?php echo e(url('esystem/history/'.($history_table_name ?? request()->raw_table_name ).'/0')); ?>"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <?php else: ?>
                <a class="refresh ms-2" href="<?php echo e(url('esystem/view/' . $tableData['table_map'] . (isset($key) ? '?tab=' . $key : ''))); ?>"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <?php endif; ?>
        </div>
        <div class="filter-table__bottom">
            <p class="filter-table__sort-title">Sắp xếp</p>
            <div class="filter-group">
                <select name="orderkey" class="select2" style="width:160px">
                    <?php $simpleSort = vanhenry\manager\helpers\DetailTableHelper::filterSimpleSort($tableDetailData);  ?>
                    <?php $__currentLoopData = $simpleSort; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset(request()->orderkey) && request()->orderkey == $ss->name): ?>
                            <option <?php echo e(request()->orderkey == $ss->name ? 'selected' : ''); ?>

                                value="<?php echo e($ss->name); ?>"><?php echo e($ss->note); ?></option>
                        <?php elseif(!isset($dataSearch) || $dataSearch['orderkey'] == 'id'): ?>
                            <option <?php echo e($ss->type_show == 'PRIMARY_KEY' ? 'selected' : ''); ?>

                                value="<?php echo e($ss->name); ?>"><?php echo e($ss->note); ?></option>
                        <?php else: ?>
                            <option <?php echo e($ss->name == $dataSearch['orderkey'] ? 'selected' : ''); ?>

                                value="<?php echo e($ss->name); ?>"><?php echo e($ss->note); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="filter-group">
                <select name="ordervalue" class="select2" style="width:100px">
                    <?php if(isset($dataSearch['ordervalue'])): ?>
                        <option <?php echo e($dataSearch['ordervalue'] == 'desc' ? 'selected' : ''); ?> value="desc">
                            <?php echo e(trans('db::from')); ?> Z->A</option>
                        <option <?php echo e($dataSearch['ordervalue'] == 'asc' ? 'selected' : ''); ?> value="asc">
                            <?php echo e(trans('db::from')); ?> A->Z</option>
                    <?php elseif(isset(request()->ordervalue)): ?>
                        <option <?php echo e(request()->ordervalue == 'desc' ? 'selected' : ''); ?> value="desc">
                            <?php echo e(trans('db::from')); ?> Z->A</option>
                        <option <?php echo e(request()->ordervalue == 'asc' ? 'selected' : ''); ?> value="asc">
                            <?php echo e(trans('db::from')); ?> A->Z</option>
                    <?php else: ?>
                        <option selected value="desc"><?php echo e(trans('db::from')); ?> Z->A</option>
                        <option value="asc"><?php echo e(trans('db::from')); ?> A->Z</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="filter-group">
                <select name="limit" class="select2" style="width:80px">
                    <option <?php echo e(isset($dataSearch) && $dataSearch['limit'] == 10 ? 'selected' : ''); ?> value="10">10</option>
                    <option <?php echo e(isset($dataSearch) && $dataSearch['limit'] == 20 ? 'selected' : ''); ?> value="20">20
                    </option>
                    <option <?php echo e(isset($dataSearch) && $dataSearch['limit'] == 50 ? 'selected' : ''); ?> value="50">50
                    </option>
                    <option <?php echo e(isset($dataSearch) && $dataSearch['limit'] == 100 ? 'selected' : ''); ?> value="100">100
                    </option>
                </select>
            </div>
            <?php if($has_history): ?>
            <div class="filter-group">
                <a href="<?php echo e(url('esystem/history/'. $tableData['table_map'].'/0')); ?>"><i class="fa fa-history" aria-hidden="true"></i> Lịch sử thay đổi</a>
                </div>
            <?php endif; ?>
            <?php if(isset($history_table_name) || ($tableData->get('table_map', '') == 'h_histories' && isset(request()->raw_table_name) && in_array(request()->raw_table_name,$arrayIncludesHistory)  )): ?>
                <div class="filter-group">
                    <a href="<?php echo e(url('esystem/view/'. ($history_table_name ?? request()->raw_table_name))); ?>"> <i class="fa fa-list" aria-hidden="true"></i> Quay lại danh sách</a>
                </div>
            <?php endif; ?>
        </div>
    </form>
</div><?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctview/filter/filter.blade.php ENDPATH**/ ?>
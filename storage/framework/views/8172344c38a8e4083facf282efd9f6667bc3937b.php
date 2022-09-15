<?php
    $has_delete = $tableData->get('has_delete', '') == 1;
    $has_update = $tableData->get('has_update', '') == 1;
    $has_copy = $tableData->get('has_copy', '') == 1;
    $has_trash = $tableData->get('has_trash', '') == 1;
    $has_history = $tableData->get('has_history', '') == 1;
?>
<div class="pagination">
    <span class="total"><?php echo e(trans('db::number_record')); ?>: <strong><?php echo e($listData->total()); ?></strong></span>
    <?php echo e($listData->withQueryString()->links('vh::vendor.pagination.pagination')); ?>

</div>
<div id="no-more-tables" class="row m0">
    <div class="tablecontrol none">
        <a class="_vh_action_all btn bg-red-400 text-white" data-confirm="Bạn có thực sự muốn xóa?" href="<?php echo e($admincp); ?>/deleteAll/<?php echo e($tableData->get('table_map', '')); ?>" title="<?php echo e(trans('db::delete_all')); ?> <?php echo e($tableData->get('name', '')); ?>">
        <i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('db::delete_all')); ?>

        </a>
        <?php if($tableData->get('table_parent', '') != ''): ?>
            <a href="#" data-toggle="modal" data-target="#addToParent" class="_vh_add_to_parent"
                title="Thêm vào danh mục cha"><i class="fa fa-puzzle-piece" aria-hidden="true">Thêm vào danh mục cha</i>
            </a>
            <a href="#" title="Xóa khỏi danh mục cha" data-toggle="modal" data-target="#addToParent"
                class="_vh_remove_from_parent"><i class="fa fa-chain-broken" aria-hidden="true">Xóa khỏi danh mục
                    cha</i></a>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.double-scroll').doubleScroll();
        });
    </script>
    <div class="main_table double-scroll">
        <table class="col-md-12 table-bordered table-striped table-condensed cf p0 table-data-view">
            <thead class="cf">
                <tr>
                    <?php if($has_delete): ?>
                        <th>
                            <div class="squaredTwo">
                                <input type="checkbox" class="all" value="None"
                                    id="squaredTwoall<?php echo e(@$dataKey ?? ''); ?>" name="check">
                                <label for="squaredTwoall<?php echo e(@$dataKey ?? ''); ?>"
                                    data-tab="<?php echo e(@$dataKey ?? ''); ?>"></label>
                            </div>
                        </th>
                    <?php endif; ?>
                    <?php $simpleShow = vanhenry\manager\helpers\DetailTableHelper::filterShow($tableDetailData);  ?>
                    <th>STT</th>
                    <?php $__currentLoopData = $simpleShow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $show): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $urlSorts = FCHelper::buildUrlSort($show);
                        ?>
                        <?php if($show->hide !== 1): ?>
                            <th class="<?php echo e($urlSorts['cursor']); ?>" data-href="<?php echo e(\Str::replaceFirst('/view/', '/search/', \Str::replaceFirst('?&', '?', $urlSorts['url_sort']))); ?>">
                                <?php echo e($show->note); ?>

                                <?php if($urlSorts['ordervalue'] == 'asc'): ?>
                                    <i class="fa fa-sort-asc" aria-hidden="true"></i>
                                <?php elseif($urlSorts['ordervalue'] == 'desc'): ?>
                                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                <?php endif; ?>
                            </th>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($has_delete || $has_update || $has_copy || $has_trash || $has_history): ?>
                        <th>Chức năng</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $urlFull = base64_encode(Request::fullUrl()); ?>
                <?php for($i = 0; $i < $listData->count(); $i++): ?>
                    <?php $itemMain = $listData->get($i); ?>
                    <tr class="<?php echo e($has_update ? 'row-item-main':''); ?>" dt-id="<?php echo e($has_update ? FCHelper::ep($itemMain, 'id') :''); ?>">
                        <?php if($has_delete): ?>
                            <td data-title="#">
                                <div class="squaredTwo">
                                    <input type="checkbox" class="one"
                                        dt-id="<?php echo e(FCHelper::ep($itemMain, 'id')); ?>"
                                        id="squaredTwo<?php echo e(FCHelper::ep($itemMain, 'id')); ?>" name="check">
                                    <label for="squaredTwo<?php echo e(FCHelper::ep($itemMain, 'id')); ?>"></label>
                                </div>
                            </td>
                        <?php endif; ?>
                        <td data-title="STT"><?php echo e($i + 1); ?></td>
                        
                        <?php $__currentLoopData = $simpleShow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $show): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                preg_match('/(.*?)(::)(.+)/', $show->type_show, $matches);
                                $viewView = isset($matches[1], $matches[2], $matches[3]) && $matches[2] == '::' ? $matches[1].$matches[2].'ctview.'.$matches[3] : 'tv::ctview.'.StringHelper::normal(FCHelper::er($show ,'type_show'));
                                $viewView = View::exists($viewView)?$viewView:"tv::ctview.base";
                            ?>
                            <?php if($show->hide !== 1): ?>
                                <?php echo $__env->make($viewView,array('item'=>$show,'dataItem'=>$itemMain), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $actions = config('sys_action.'.FCHelper::ep($tableData,'table_map'));
                        ?>
                        <?php if($has_delete || $has_copy || $has_update || $has_trash || $has_history || !is_null($actions)): ?>
                            <td data-title="<?php echo e(trans('db::function')); ?>" style="min-width: 130px;"
                                class="action">
                                <?php if(!is_null($actions)): ?>
                                    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make('vh::table.action_button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php if(isset($itemMain->slug)): ?>
                                    <a href="<?php echo e($itemMain->slug); ?>" target="_blank"
                                        class="<?php echo e(trans('db::edit')); ?> tooltipx <?php echo e($tableData->get('table_map', '')); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        <span class="tooltiptext">Xem demo</span>
                                    </a>
                                <?php endif; ?>
                                <?php if($has_history): ?>
                                    <a href="<?php echo e($admincp); ?>/history/<?php echo e($tableData->get('table_map', '')); ?>/<?php echo e(FCHelper::ep($itemMain, 'id')); ?>?returnurl=<?php echo e($urlFull); ?>"
                                        class="<?php echo e(trans('db::history')); ?> tooltipx <?php echo e($tableData->get('table_map', '')); ?>">
                                        <i class="fa fa-history" aria-hidden="true"></i>
                                        <span class="tooltiptext">Lịch sử thay đổi</span>
                                    </a>
                                <?php endif; ?>
                                <?php if($has_copy): ?>
                                    <a href="<?php echo e($admincp); ?>/copy/<?php echo e($tableData->get('table_map', '')); ?>/<?php echo e(FCHelper::ep($itemMain, 'id')); ?>?returnurl=<?php echo e($urlFull); ?>"
                                        class="<?php echo e(trans('db::edit')); ?> tooltipx <?php echo e($tableData->get('table_map', '')); ?>"><i
                                            class="fa fa-copy" aria-hidden="true"></i>
                                        <span class="tooltiptext">Copy</span>
                                    </a>
                                <?php endif; ?>
                                <?php if($has_update): ?>
                                    <a href="<?php echo e($admincp); ?>/edit/<?php echo e($tableData->get('table_map', '')); ?>/<?php echo e(FCHelper::ep($itemMain, 'id')); ?>?returnurl=<?php echo e($urlFull); ?>"
                                        class="<?php echo e(trans('db::edit')); ?> tooltipx <?php echo e($tableData->get('table_map', '')); ?>"><i
                                            class="fa fa-pencil" aria-hidden="true"></i>
                                        <span class="tooltiptext">Sửa</span>
                                    </a>
                                <?php endif; ?>
                                <?php if($has_trash): ?>
                                    <a href="<?php echo e($admincp); ?>/<?php echo e(isset($trash) ? 'backtrash' : 'trash'); ?>/<?php echo e($tableData->get('table_map', '')); ?>"
                                        class="_vh_<?php echo e(isset($trash) ? 'backtrash' : 'trash'); ?> tooltipx <?php echo e(trans('db::delete')); ?> <?php echo e($tableData->get('table_map', '')); ?>"><i
                                            class="fa fa-<?php echo e(isset($trash) ? 'level-up' : 'trash'); ?>"
                                            aria-hidden="true"></i>
                                        <span
                                            class="tooltiptext"><?php echo e(isset($trash) ? 'Restore' : 'Thùng rác'); ?></span>
                                    </a>
                                <?php endif; ?>
                                <?php if($has_delete): ?>
                                    <a href="<?php echo e($admincp); ?>/delete/<?php echo e($tableData->get('table_map','')); ?>" class="_vh_delete_permanent _vh_delete tooltipx <?php echo e(trans('db::delete')); ?> <?php echo e($tableData->get('table_map','')); ?>"><i class="fa fa-times-circle" aria-hidden="true"></i>
                                        <span class="tooltiptext">Xóa vĩnh viễn</span>
                                    </a>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <span class="total"><?php echo e(trans('db::number_record')); ?>:<strong>
                <?php echo e($listData->total()); ?></strong></span>
        <?php echo e($listData->withQueryString()->links('vh::vendor.pagination.pagination')); ?>

    </div>
</div>
<?php /**PATH C:\laragon\www\dethi\packages\vanhenry\manager\src/views/view/table.blade.php ENDPATH**/ ?>
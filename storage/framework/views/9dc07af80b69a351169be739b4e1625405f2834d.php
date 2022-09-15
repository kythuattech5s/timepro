
    <?php $__env->startSection('css'); ?>
        <?php if($tableData->get('has_yoast_seo','') == 1): ?>
            <link rel="stylesheet" href="admin/tech5s_yoast_seo/theme/css/yoastseo.css" type="text/css">
        <?php endif; ?>
        <?php
            $styles = config('sys_view'.'.'.$tableData->get('table_map').'.style',false);
        ?>
        <?php if($styles): ?>
            <?php $__currentLoopData = $styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $style_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <link rel="stylesheet" href="<?php echo e($style_link); ?>" type="text/css">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<a href="<?php echo e($admincp); ?>/editableajax/<?php echo e($tableData->get('table_map','')); ?>" class="hidden" id="editableajax"></a>
<div class="header-top aclr">
	<div class="breadc pull-left">
		<ul class="aclr pull-left list-link">
			<li class="active">
                <a  href="<?php echo e($admincp); ?>/view/<?php echo e($tableData->get('table_map','')); ?>">
                    <?php echo e(FCHelper::ep($tableData,'name')); ?>

                </a>
            </li>
		</ul>
	</div>
</div>
<div id="maincontent">
    <?php
        $tabData = config('sys_tab'.'.'.$tableData->get('table_map',''),false);
    ?>
	<div class="listcontent">
		<ul class="nav nav-tabs">
            <?php if($tabData): ?>
				<?php $__currentLoopData = $tabData['tabs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $detailTab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        if(isset(request()->tab) && $key == request()->tab){
                            $active_tab = 'active';
                        }elseif(!isset(request()->tab)){
                            $active_tab = $loop->first ? 'active' : '';
                        }else{
                            $active_tab = '';
                        }

                         
                    ?>
                    <li class="<?php echo e($active_tab); ?>">
                        <a class="pull-right bgmain" href="<?php echo e(url()->current().'?tab='.$key); ?>">
                            <?php echo e($detailTab['label']); ?>

                            <span class="count">
                                <?php echo e($listData[$detailTab['name']]->total()); ?>

                            </span>
                        </a>
                    </li>
                    <?php
                       if(!empty($active_tab)){
                            $dataList = $listData[$detailTab['name']];
                        }
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			<?php if($tableData->get("has_trash","") == 1): ?>
				<li class=""><a  href="<?php echo e($admincp); ?>/trashview/<?php echo e($tableData->get('table_map','')); ?>"><?php echo e(trans('db::trash')); ?></a></li>
			<?php endif; ?>
			<?php if($transTable != null): ?>
				<li>
					<ul class="table-lang view">
						<?php $tableLangs = \Session::get('_table_lang') ?>
						<?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><a href="<?php echo e($admincp); ?>/table-lang/<?php echo e($tableData->get('table_map','')); ?>/<?php echo e($localeCode); ?>" class="<?php echo e((isset($tableLangs[$tableData->get('table_map')]) && $tableLangs[$tableData->get('table_map')] == $localeCode) || (!isset($tableLangs[$tableData->get('table_map')]) && $localeCode == Config::get('app.locale_origin')) ? 'active' : ''); ?>"><?php echo e($v); ?></a></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</li>
			<?php endif; ?>
			<div class="header-top aclr">
				<div>
					<?php if($tableData->get("has_import","") == 1): ?>
						<a class="pull-right bgmain viewsite" href="<?php echo e($admincp); ?>/import/<?php echo e($tableData->get('table_map','')); ?>">
							<i class="fa fa-cloud-upload" aria-hidden="true"></i>
							<span  class="clfff">Import</span>
						</a>
					<?php endif; ?>
					<?php if($tableData->get('has_export',"") == 1): ?>
                        <a class="pull-right bgmain viewsite" href="<?php echo e($admincp); ?>/export/<?php echo e($tableData->get('table_map','')); ?>">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                           <span  class="clfff"> Xuất file excel </span>
                        </a>
                    <?php endif; ?>
					<?php if($tableData->get('has_insert','')==1): ?>
						<?php $urlFull = base64_encode(Request::fullUrl()); ?>
						<a class="pull-right bgmain viewsite " href="<?php echo e($admincp); ?>/insert/<?php echo e($tableData->get('table_map','')); ?>?returnurl=<?php echo e($urlFull); ?>">
							<i class="fa fa-file-o" aria-hidden="true"></i>
							<span  class="clfff"><?php echo e(trans('db::add')); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</ul>
		<div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <?php echo $__env->make('tv::ctview.filter.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div id="main-table">
                    <?php echo $__env->make('vh::view.table',['listData' => $dataList ?? $listData, 'tableData'=>$tableData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
		</div>
	</div>
    <?php
        $includes = config('sys_components'.'.'.$tableData->get('table_map').'.view',false);
    ?>
    <?php if($includes): ?>
        <?php $__currentLoopData = $includes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $include): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make($include['view'],$include['params'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
	<?php echo $__env->make('vh::static.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more'); ?>
    <?php if($tableData->get('table_parent','')!=''): ?>
        <?php echo $__env->make('vh::view.addToParent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <?php
        $scripts = config('sys_view'.'.'.$tableData->get('table_map').'.script',false);
    ?>
    <?php if($scripts): ?>
        <?php $__currentLoopData = $scripts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <script src="<?php echo e($script_link); ?>" type="text/javascript" defer></script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('vh::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\timepro\packages\vanhenry\manager\src/views/view/view_normal.blade.php ENDPATH**/ ?>
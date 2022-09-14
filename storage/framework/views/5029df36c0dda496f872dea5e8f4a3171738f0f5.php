
<?php $__env->startSection('css'); ?>
	<?php if($tableData->get('has_yoast_seo', '') == 1): ?>
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
	<?php 
        $tableMap = $tableData->get('table_map', '');
        $configs = config('sys_table.edit');
    ?>
    <?php $__currentLoopData = $configs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $sys_config = config("sys_table.$config");
            $hasConfig = array_filter($sys_config,function($value, $key) use($tableMap){
                return $key === $tableMap;
            },ARRAY_FILTER_USE_BOTH);
        ?>
	    
        <?php if(count($hasConfig) > 0): ?>
            <span sys-config data-type="<?php echo e($config); ?>" data-table="<?php echo e($tableMap); ?>" data-action="<?php echo e($actionType); ?>" <?php if(isset($sys_config[$tableMap]['time'])): ?> data-time="<?php echo e($sys_config[$tableMap]['time']); ?>" <?php endif; ?>></span>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<input class="one hidden" dt-id="<?php echo e(FCHelper::er($dataItem, 'id')); ?>">
	<!--Lưu id để xóa-->
	<div class="header-top aclr">
		<div class="breadc pull-left">
			<ul class="aclr pull-left list-link">
				<li class="pull-left"><a href="<?php echo e($admincp); ?>/view/<?php echo e($tableMap); ?>"><?php echo e($tableData->get('name', '')); ?></a>
				</li>
			</ul>
			<?php if($transTable != null): ?>
				<ul class="table-lang edit">
					<?php $tableLangs = \Session::get('_table_lang'); ?>
					<?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><a
								href="<?php echo e($admincp); ?>/table-lang/<?php echo e($tableData->get('table_map', '')); ?>/<?php echo e($localeCode); ?>"
								data-lang="<?php echo e($localeCode); ?>"
								class="<?php echo e((!is_array($tableLangs) && $localeCode == Config::get('app.locale_origin')) ||(is_array($tableLangs) &&array_key_exists($tableData->get('table_map'), $tableLangs) &&$tableLangs[$tableData->get('table_map')] == $localeCode)? 'active': ''); ?>"><?php echo e($v); ?></a>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			<?php endif; ?>
		</div>
		<div>
			

			<?php if($actionType == 'edit'): ?>
				
				
				
			<?php endif; ?>
			<a class="pull-right bgmain viewsite _vh_save" href="#">
				<i class="fa fa-save" aria-hidden="true"></i>
				<span class="clfff">Lưu</span>
			</a>
			<a class="pull-right bgmain1 viewsite"
				href="<?php echo e(base64_decode(\Request::input('returnurl'))); ?>">
				<i class="fa fa-backward" aria-hidden="true"></i>
				<span class="clfff">Back</span>
			</a>

		</div>
	</div>
	<?php
	if ($actionType == 'edit') {
	    $actionAjax = "$admincp/update/" . $tableMap . '/' . FCHelper::er($dataItem, 'id');
	    $actionNormal = "$admincp/save/" . $tableMap . '/' . FCHelper::er($dataItem, 'id') . '?returnurl=' . Request::input('returnurl');
	} else {
	    $actionAjax = "$admincp/storeAjax/" . $tableMap;
	    $actionNormal = "$admincp/store/" . $tableMap . '?returnurl=' . Request::input('returnurl');
	}
	?>
	<div id="maincontent">
		<form action="<?php echo e($actionNormal); ?>" dt-ajax="<?php echo e($actionAjax); ?>"
			dt-normal="<?php echo e($actionNormal); ?>" method="post" id="frmUpdate">
			<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			<input type="hidden" name="tech5s_controller"
				value="<?php echo e($tableData->get('controller', '')); ?>">
			<div id="mainedit" class="row">
				<div class="col-xs-12 col-md-9 p0">
					<?php
					    $mainTable = count($tableDetailData) > 0 ? $tableDetailData[1] : [];
					?>
					<?php $__currentLoopData = $mainTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mTable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php $currentGroup = count($mTable) > 0 ? $mTable[0]->group : 0; ?>
						<?php if (!isset($groupControl[$currentGroup])) {
						    continue;
						} ?>
						<div class="row m0 boxedit">
							<?php if($groupControl[$currentGroup]->has_button_hide == 1): ?>
								<div class="col-xs-12 boxtitle">
									<h1 class="col-xs-9 p0">
										<?php echo e(FCHelper::ep($groupControl[$currentGroup], 'name', 1)); ?></h1>
									<div class="textright col-xs-3 p0">
										<button type="button"
											class="btn btn-primary bgmain btnshow"><?php echo e(trans('db::edit')); ?></button>
									</div>
								</div>
							<?php else: ?>
								<h1 class="col-xs-12">
									<?php echo e(FCHelper::ep($groupControl[$currentGroup], 'name', 1)); ?></h1>
							<?php endif; ?>
							<p class="des col-xs-12">
								<?php echo e(FCHelper::ep($groupControl[$currentGroup], 'note', 1)); ?></p>
							<div
								class="col-xs-12 <?php echo e($groupControl[$currentGroup]->has_button_hide == 1 ? 'boxhide' : ''); ?> <?php echo e($groupControl[$currentGroup]->display_default == 0 ? 'none' : ''); ?>">
								<?php $__currentLoopData = $mTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
                                        preg_match('/(.*?)(::)(.+)/', $table->type_show, $matches);
                                        $viewEdit = isset($matches[1], $matches[2], $matches[3]) && $matches[2] == '::' ? $matches[1].$matches[2].'ctedit.'.$matches[3] : 'tv::ctedit.' . StringHelper::normal(FCHelper::er($table, 'type_show'));
                                        $viewEdit = View::exists($viewEdit) ? $viewEdit : 'tv::ctedit.base';
									?>
									<?php echo $__env->make($viewEdit, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php $exs = \Event::dispatch('vanhenry.manager.insert.generate_view', [$tableData]); ?>
					<?php $__currentLoopData = $exs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exk => $exvs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if(is_array($exvs)): ?>
							<?php $__currentLoopData = $exvs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exvv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php echo $__env->make('vh::' . $exvv, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
				<div class="col-xs-12 col-md-3">
					<?php
					$sideTable = count($tableDetailData) > 1 ? $tableDetailData[2] : [];
					?>
					<?php $__currentLoopData = $sideTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $side): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php $currentGroup = count($side) > 0 ? $side[0]->group : 0; ?>
						<?php if (!isset($groupControl[$currentGroup])) {
						    continue;
						}
						?>
						<div class="row m0 boxedit">
							<h1 class="col-xs-12">
								<?php echo e(FCHelper::ep($groupControl[$currentGroup], 'name')); ?></h1>
							<div class="col-xs-12">
								<?php $__currentLoopData = $side; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										preg_match('/(.*?)(::)(.+)/', $table->type_show, $matches);
                                		$viewEdit = isset($matches[1], $matches[2], $matches[3]) && $matches[2] == '::' ? $matches[1].$matches[2].'ctedit.'.$matches[3] : 'tv::ctedit.' . StringHelper::normal(FCHelper::er($table, 'type_show'));
                                        $viewEdit = View::exists($viewEdit) ? $viewEdit : 'tv::ctedit.base';
									?>
									<?php echo $__env->make($viewEdit, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							</div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		</form>
		<?php echo $__env->make('vh::edit.view_edit_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->make('vh::static.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>
<?php $__env->stopSection(); ?>
<?php $tableYoastSeo = \Config::get('manager.table_yoast_seo'); ?>
<?php $__env->startSection('js'); ?>
	<?php if($tableData->get('has_yoast_seo', '') == 1): ?>
		<script type="text/javascript" src="admin/tech5s_yoast_seo/theme/js/yoastseo.js" defer></script>
		<script type="text/javascript" src="admin/tech5s_yoast_seo/theme/js/script.js" defer></script>
	<?php endif; ?>
    <?php
        $scripts = config('sys_view'.'.'.$tableData->get('table_map').'.script',false);
    ?>
    <?php if($scripts): ?>
        <?php $__currentLoopData = $scripts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <script src="<?php echo e($script_link); ?>" type="text/javascript" defer></script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vh::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\timepro\packages\vanhenry\manager\src/views/edit/view_normal.blade.php ENDPATH**/ ?>
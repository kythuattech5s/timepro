<td data-title="<?php echo e($show->note); ?>" style="text-align: left;<?php echo e($show->name == 'name' ? 'white-space: normal;min-width: 300px;':''); ?><?php echo e($show->name == 'ord' ? 'width: 50px;':''); ?>">
	<?php if($show->name == 'name'): ?>
		<p><a href="<?php echo e($admincp); ?>/edit/<?php echo e($tableData->get('table_map','')); ?>/<?php echo e(FCHelper::ep($itemMain,'id')); ?>?returnurl=<?php echo e($urlFull); ?>">
			<?php echo e(FCHelper::ep($dataItem,$show->name)); ?>

		</a></p>
		<?php if(isset($itemMain->slug)): ?>
			<p><a href="<?php echo e(url($itemMain->slug.'/')); ?>" class="smooth" title="Xem trước" target="_blank"><strong>(Xem trước)</strong></a></p>
		<?php endif; ?>
		<input type="hidden" dt-prop="<?php echo e($show->is_prop ?? 0); ?>" dt-prop-id="<?php echo e($show->id); ?>" class="<?php echo e($show->editable==1?'editable':''); ?>"  name="<?php echo e($show->name); ?>" title="<?php echo e($show->note); ?>" value="<?php echo e(FCHelper::ep($dataItem,$show->name)); ?>" type="text" disabled />
	<?php else: ?>
	<input dt-prop="<?php echo e($show->is_prop ?? 0); ?>" dt-prop-id="<?php echo e($show->id); ?>" class="<?php echo e($show->editable==1?'editable':''); ?>"  name="<?php echo e($show->name); ?>" title="<?php echo e($show->note); ?>" value="<?php echo e(FCHelper::ep($dataItem,$show->name)); ?>" type="text" disabled />
	<?php endif; ?>
</td><?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctview/text.blade.php ENDPATH**/ ?>
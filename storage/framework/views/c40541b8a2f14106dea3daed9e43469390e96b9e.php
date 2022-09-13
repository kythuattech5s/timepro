<?php 
	$value = FCHelper::ep($dataItem,$show->name);
	$hasEditable = $show->editable == 1 ? 'editable' : '';
?>
<td data-title="<?php echo e($show->note); ?>">
  <input dt-prop="<?php echo e($show->is_prop ?? 0); ?>" dt-prop-id="<?php echo e($show->id); ?>" type="checkbox" data-off-label="false" data-on-label="false" data-off-icon-cls="glyphicon-remove"  name="<?php echo e($show->name); ?>" <?php echo e($value == 1?'checked':''); ?> data-on-icon-cls="glyphicon-ok" class="ccb <?php echo e($hasEditable); ?>" />
</td>
<?php /**PATH C:\laragon\www\dethi\/packages/vanhenry/views/ctview/checkbox_button.blade.php ENDPATH**/ ?>
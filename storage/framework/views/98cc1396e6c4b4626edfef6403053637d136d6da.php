<select name="<?php echo e($name); ?>" class="select2 <?php if($isAjax): ?> ajx_search_single_<?php echo e($name); ?> <?php endif; ?>" style="width:250px">
	<option value="">-- <?php echo e($search->note); ?> --</option>
    <?php if(isset($defaultValue) && $isAjax): ?>
        <option value="<?php echo e($defaultValue[$dataSelect[0]]); ?>" selected><?php echo e($defaultValue[$dataSelect[1]]); ?></option>
    <?php endif; ?>
	<?php $__currentLoopData = @$dataValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$type_show_value = strtolower($search->type_show) == 'pivot' ? $search->name : 'raw_' . $search->name;
            $selectedFilter = isset($dataSearch) && isset($dataSearch[$type_show_value]) && $dataSearch[$type_show_value] == ($data->id ?? $data['key']) ? 'selected' : '';
		?>
		<option value="<?php echo e($data->id ?? $data['key']); ?>" <?php echo e($selectedFilter); ?>>
			<?php echo e(FCHelper::ep($data, 'name')); ?>

		</option>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

<?php if($isAjax): ?>
    <script type="text/javascript">
        $(function() {
            const listDatas = <?php echo $buildDataDefault; ?>;
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
                        },...listDatas,...data.results]
                        return newData;
                    },
                    cache: true
                },
                minimumInputLength: 1,
                language: "<?php echo e(App::getLocale()); ?>",
            });
        });
    </script>
<?php endif; ?>



<?php /**PATH D:\laragon\www\timepro\/packages/vanhenry/views/ctsearch/select/normal.blade.php ENDPATH**/ ?>
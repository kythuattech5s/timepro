<?php 
	$name = isset($itemSubControl['name'])?$itemSubControl['name']:'';
	$type = $itemSubControl['type'];
	$rows = isset($itemSubControl['rows'])?$itemSubControl['rows']:'3';
	$default = isset($itemSubControl['default'])?$itemSubControl['default']:'';
	$value = isset($subValue[$name])?$subValue[$name]:$default;
 ?>
<?php $idfile = $name."_".\Str::random(10); ?>
<div class="<?php echo $idfile ?>">
	<div class="d-flex">
		<textarea data-variable="elementor_json_field_<?php echo $key.$nameSubControl; ?>" cols="30" data-name="<?php echo $name ?>"  data-type="<?php echo $type ?>" rows="<?php echo $rows ?>" class="control <?php echo $idfile ?> <?php echo $name ?> hidden <?php echo $type ?>" value="<?php echo $default ?>"><?php echo $value ?></textarea>
	 	<?php 
			$tmp = json_decode($value,true);
			$file = isset($tmp) && is_array($tmp) ?$tmp["path"].$tmp["file_name"]:'';  
		?>
		<input type="text" class="<?php echo $idfile ?> <?php echo $name ?>" value="<?php echo $file ?>">
		<div class="btnadmin d-flex align-items-center">
			<a href="{{$admincp}}/media/view?istiny=<?php echo $idfile ?>&callback=ELEMENTOR_MANAGE_QUESTION_PROVIDER.callbackFile" class="btn iframe-btn" type="button">Browse File ...</a>
			<button onclick="window['elementor_json_field_<?php echo $key.$nameSubControl; ?>'].deleteFile('<?php echo $idfile ?>')" style="margin-left: 5px;" class="bgmain btn btn-primary" type="button">{{trans('db::delete')}}</button>
		</div>
	</div>
</div>
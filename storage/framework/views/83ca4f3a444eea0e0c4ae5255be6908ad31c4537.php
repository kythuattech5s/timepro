<?php
    $keyImage = $keyImage ?? 'img';
	$itemImageShow = new \StdClass;
	$itemImageShow->img = '';
	if(is_object($itemImage)){
		$itemImageShow->img = $itemImage->$keyImage;
	}
	if(is_array($itemImage)){
		$itemImageShow->img = $itemImage[$keyImage];
	}
?>
<?php echo $__env->make('image_loader.default.tiny',['itemImageShow' => $itemImageShow,'noLazyLoad' => $noLazyLoad ?? 0, 'attribute' => $attribute ?? ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
	unset($itemImageShow);
?><?php /**PATH H:\laragon\www\timepro\resources\views/image_loader/tiny.blade.php ENDPATH**/ ?>
<?php
    $keyImage = $keyImage ?? 'img';
	$itemImageShow = new \StdClass;
	$itemImageShow->img = '';
	if(is_object($itemImage)){
		$itemImageShow->img = $itemImage->$keyImage;
		if(isset($itemImage->name)){
            $itemImageShow->name = $itemImage->name;
        }
        if(isset($itemImage->title)){
            $itemImageShow->name = $itemImage->title;
        }
	}
	if(is_array($itemImage)){
		$itemImageShow->img = $itemImage[$keyImage];
        if(isset($itemImage['name'])){
            $itemImageShow->name = $itemImage['name'];
        }
        if(isset($itemImage['title'])){
            $itemImageShow->name = $itemImage['title'];
        }
	}
?>
@include('image_loader.default.tiny',['itemImageShow' => $itemImageShow,'noLazyLoad' => $noLazyLoad ?? 0, 'attribute' => $attribute ?? ''])
<?php unset($itemImageShow); ?>
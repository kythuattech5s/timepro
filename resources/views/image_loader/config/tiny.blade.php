<?php
	$itemImage = SettingHelper::getSetting($config_key);
	$itemImageShow = new \StdClass;
	$itemImageShow->img = $itemImage ?? null;
?>
@include('image_loader.default.tiny',['itemImageShow' => $itemImageShow,'noLazyLoad' => $noLazyLoad ?? 0])
<?php unset($itemImageShow); ?>
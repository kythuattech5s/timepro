<picture {{$attribute ?? ''}}>
	<source media="(min-width:0px)" data-srcset="{%IMGV2.itemImageShow.img.150x0%}" srcset="{%IMGV2.itemImageShow.img.150x0%}">
	<img loading="{{isset($noLazyLoad) && $noLazyLoad == 1 ? 'auto':'lazy'}}" src="{%IMGV2.itemImageShow.img.150x0%}" data-src="{%IMGV2.itemImageShow.img.150x0%}" title="{%IMGV2.itemImageShow.img.title%}" alt="{%IMGV2.itemImageShow.img.alt%}" class="img-fluid">
</picture>
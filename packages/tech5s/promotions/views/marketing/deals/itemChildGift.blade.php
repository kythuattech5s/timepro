@php

$deal = $item->dealSub()->where('deal_product_subs.deal_id',$currentItem->id)->first();
$checked = false;
if (isset($product_checked) && $product_checked->contains($item->id)) {
    $checked = true;
}
@endphp
<div class="item-child">
	<label for=""></label>
	<label for="product-{-item.id-}" style="display:block" class="c-hidden">
		<input type="checkbox" value="{-item.id-}" name="id" id="product-{-item.id-}" c-single>
		<span></span>
	</label>
	<div class="name-product">
		<a href="{-product.slug-}" target="_blank">
			{-item.name-}{{ isset($noProperty) && $noProperty ? '' : ' - ' . $item->getProperty($product) }}
		</a>
	</div>
	<div class="price-group">
		<p>
			{-item.price-}
			@if ($item->price_old > 0)
				<del>({-item.price_old-})</del>
			@endif
		</p>
	</div>
	<div class="price-group">
		0 đ
		<input type="hidden" value="0" name="price">
		<input type="hidden" value="100" name="percent">
	</div>

	<div class="qty-current warehouse">
		{{ $item->quantity ?? 'Không giới hạn' }}
	</div>
    <div class="order-item">
        <input type="text" name="ord" value="{{ $deal->pivot->ord ?? '' }}">
    </div>
	<div class="action-active">
		<label class="switch">
			<input type="checkbox" name="act" data-type-product="{{ $type }}" value="{{ $checked ? 1 : 0 }}"
				{{ $checked ? 'checked' : '' }}>
			<span class="slider"></span>
		</label>
	</div>
	<div class="action-box">
	</div>
</div>

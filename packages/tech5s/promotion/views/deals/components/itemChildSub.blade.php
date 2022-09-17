@php
$deal = $item->dealSub()->where('deal_product_subs.deal_id',$currentItem->id)->first();
$checked = false;
if (isset($deal)) {
	$checked = $deal->pivot->act == 1 ? true : false;
}
@endphp
<div class="item-child">
	<div class="name-product">
		<a href="{-product.slug-}" target="_blank">
			{-item.name-}
			{{-- {{ isset($noProperty) && $noProperty ? '' : ' - ' . $item->getProperty($product) }} --}}
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
		{{ Currency::showMoney($deal->pivot->price ?? 0) }}
	</div>
	<div class="percent show sale-item">
		{{ $deal->pivot->percent ?? 0}}
	</div>
	<div class="qty-current warehouse">
		{-item.remain-}
	</div>
	<div class="limit-order">
		{{ $deal->pivot->limit ?? 'Không giới hạn' }}
	</div>
    <div class="order-item">
        {{ $deal->pivot->ord ?? '' }}
    </div>
	<div class="action-active">
		{{ $checked ? 'Bật' : 'Tắt' }}
	</div>
</div>

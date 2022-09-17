@forelse($products as $product)
	@php
		$checked = $product_chooses->first(fn($item) => isset($item['id']) && (int) $item['id'] === (int) $product->id);
		
		$flagChecking = !isset($product_checked_old) || (isset($product_checked_old) && $product_checked_old->first(fn($item) => isset($item['id']) && (int) $item['id'] === (int) $product->id));
	@endphp
	<tr class="@if ($checked !== null && $flagChecking) disabled @endif">
		<td>
			@if ($checked !== null && $flagChecking)
				<input type="hidden" name="disabled" value="1" data-checked="disabled">
			@endif
			<label for="product-modal-{-product.id-}" style="display:block">
				<input type="checkbox" value="{-product.id-}" id="product-modal-{-product.id-}" @if ($checked !== null) checked no-check @endif c-single data-checked="id" data-checked-main>
				<span></span>
			</label>
		</td>
		<td class="d-flex align-items-center text-left">
			<img src="{%IMGV2.product.img.-1%}" alt="{%AIMGV2.product.img.alt%}" title="{%AIMGV2.product.img.title%}">
			<a href="{-product.slug-}" target="_blank">
				{-product.name-}
			</a>
		</td>
		@php
			$listPrice = collect($product->getFirstPrice());
		@endphp
		<td>
			@if ($listPrice->count() > 1)
				{{ Currency::showMoney($listPrice->min()) }}
				<p>~</p>
				{{ Currency::showMoney($listPrice->max()) }}
			@else
				{{ Currency::showMoney($listPrice->first()) }}
			@endif
		</td>
	</tr>
@empty
	<tr class="no-result">
		<td colspan="100%" style="flex: 0 0 100%">Không có sản phẩm nào hợp lệ!</td>
	</tr>
@endforelse

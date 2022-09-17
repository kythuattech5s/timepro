<div class="d-flex justify-content-between">
	<div>
		@if ($currentItem->type == DealHelper::TYPE_DEAL)
			<h4>Sản phẩm mua kèm</h4>
			<p>Người mua có thể tận hưởng các sản phẩm mua kèm giá khuyến mãi khi họ mua bất
				kỳ sản phẩm chính nào.
			</p>
		@else
			<h4>Quà tặng</h4>
			<p>Người mua chỉ có thể nhận quà tặng một lần duy nhất trên một đơn hàng.</p>
		@endif
	</div>
	<button class="btn btn-link edit-product-sub" data-id="{-currentItem.id-}" data-type-product="sub"
		data-action="{{ $action }}" data-type="{{ $promotion }}" type="button">
		<i class="fa fa-pencil" aria-hidden="true"></i>
		{{ $currentItem->type == DealHelper::TYPE_GIFT ? 'Thay đổi quà tặng kèm' : 'Thay đổi sản phẩm kèm' }}
	</button>
</div>
<div class="table-item">
	<div class="head-product-deal">
		<div class="name-product">
			Sản phẩm
		</div>
		<div class="price-group">
			Giá gốc
		</div>
		<div class="price-group">
			Giá đã giảm
		</div>
		<div class="sale-item">
			Khuyến mãi
		</div>
		<div class="warehouse">
			Kho hàng
		</div>
		<div class="limit-order">
			Giới hạn đặt hàng
		</div>
		<div class="order-item">
			Sắp xếp
		</div>
		<div class="action-active">
			Bật / Tắt
		</div>
	</div>
	<div class="item-product-deal">
		@foreach ($products as $product)
			@php
				$limit = '';
				if ($product->flash_sale->count() == 0 && isset($currentItem)) {
				$flash_sale = $product->variants->first() !== null ? $product->variants->first()->flash_sale->first() : null;
				$limit = $flash_sale !== null ? $flash_sale->pivot->limit : $limit;
				} elseif (isset($currentItem)) {
				$flash_sale = $product
				->flash_sale()
				->where('flash_sale_id', $currentItem->id)
				->first();
				$limit = $flash_sale !== null ? $flash_sale->pivot->limit : $limit;
				}
			@endphp
			<div class="item" c-check-item data-id="{-product.id-}" draggable>
				<div class="header">
					<div class="name-product">
						<img src="{%IMGV2.product.img.390x0%}" alt="{%AIMGV2.product.img.alt%}" title="{%AIMGV2.product.img.title%}">
						<a href="{-product.slug-}" target="_blank">{-product.name-}</a>
					</div>
					<div>
					</div>
				</div>
				<div class="body">
					@if ($product->variants->count() > 0)
						@foreach ($product->variants as $item)
							@include('tp::deals.components.itemChildSub')
						@endforeach
					@else
						@include('tp::deals.components.itemChildSub', [
						    'item' => $product,
						    'noProperty' => true,
						])
					@endif
				</div>
			</div>
		@endforeach
	</div>
</div>

<table class="table">
	<thead>
		<tr>
			<th>Tên sản phẩm</th>
			<th>Giá</th>
			@if (!isset($lock) || !$lock)
				<th>Hành động</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@forelse($courses as $key => $product)
			<tr data-id="{-product.id-}">
				<td data-label="Sản phẩm" class="flex justify-start space-x-2 text-left align-items-center">
					<img src="{%IMGV2.product.img.-1%}" alt="{%AIMGV2.product.img.alt%}"
										title="{%AIMGV2.product.img.title%}">
					<a href="{-product.slug-}" target="_blank">
						{-product.name-}
					</a>
				</td>
				@php
					$listPrice = collect($product->getFirstPrice());
				@endphp
				<td data-label="Giá">
					@if ($listPrice->count() > 1)
						{{ Currency::showMoney($listPrice->min()) }}
						<p>~</p>
						{{ Currency::showMoney($listPrice->max()) }}
					@else
						{{ Currency::showMoney($listPrice->first()) }}
					@endif
				</td>
				@if (!isset($lock) || !$lock)
					<td data-label="Thao tác">
						<div class="action">
							<button type="button" class="btn btn-sm bg-red-400 text-white" title="Xóa"><i class="fa fa-trash-o" aria-hidden="true"></i>
							</button>
						</div>
					</td>
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="100%">Không có kết quả phù hợp.</td>
			</tr>
		@endforelse
	</tbody>
</table>
{{ $courses->withQueryString()->links('vh::base.pagination', ['attributeAjax' => 'pagination-voucher-list', 'attribute' => 'data-promotion=vouchers data-page']) }}

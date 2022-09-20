<div class="category-filter d-flex gap-[10px]">
	<input type="text" placeholder="Nhập tên danh mục..." class="flex-1 rounded-[4px] px-[10px]">
	<button class="search-voucher-category rounded-[4px] bg-green-400 py-[5px] px-[20px]" type="button">Tìm kiếm</button>
</div>
<div class="my-3 flex justify-between">
	<p>Danh mục sản phẩm đã chọn:
		<span m-checkbox-count class="font-semibold">
			@if (isset($listProducts))
				{{ $listProducts->count() }}
			@else
				0
			@endif
		</span>
	</p>
	<p class="flex items-center space-x-3">
		<label for="show-category-selected">Danh mục đã chọn</label>
		<input type="checkbox" id="show-category-selected" {{isset($currentItem) ? 'checked' : ''}}>
	</p>
</div>
<div class="list-table">
	@include('tpv::components.table_category_list')
</div>

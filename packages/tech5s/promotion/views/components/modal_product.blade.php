<div class="modal-header flex justify-between">
	<h5 class="modal-title font-bold" id="modalProductLabel">Chọn sản phẩm</h5>
	<button type="button" class="btn-close" data-dismiss="modal">X</button>
</div>
<div class="modal-body">
	<div class="form-search-item">
		<input type="hidden" name="promotion" value="{{ $promotion }}" filter="promotion">
		<input type="hidden" name="type" value="{{ $type }}" filter="type">
		<input type="hidden" name="action" value="{{ $action }}" filter="action">
        @if($shop_id)
	    	<input type="hidden" name="shop_id" value="{{ $shop_id }}" filter="shop_id">
        @endif
		<div class="d-flex justify-content-between flex-wrap">
			<div class="search-category">
				<span>Danh mục</span>
				<select name="category" id="" filter="category_id">
					<option value="">-- Danh mục --</option>
					@foreach ($product_categories as $category)
						<option value="{-category.id-}">{-category.name-}</option>
					@endforeach
				</select>
			</div>
			<div class="search-name">
				<span>Tìm</span>
				<select name="by" id="" filter="by">
					<option value="">-- Tìm kiếm theo --</option>
					<option value="name">Tên sản phẩm</option>
					<option value="code">Mã sản phẩm</option>
				</select>
				<input type="text" name="q" placeholder="Nhập từ khóa" filter="q">
			</div>
			<label for="product_has_promotion" class="mt-3 w-full text-right">
				Sản phẩm có sẵn
				<input type="checkbox" name="product_in_promotion" style="width: initial;" filter="isShow" id="product_has_promotion">
			</label>

		</div>
		<button type="button" class="btn bg-blue-400 transition duration-300 hover:bg-blue-300">
			Tìm kiếm
		</button>
	</div>
</div>
<div class="form-choose-product">
	<div class="modal-body">
		<table class="table">
			@include('tp::components.table_item')
		</table>
	</div>
	<div class="modal-footer">
		<span>Đã chọn<span class="mx-2 font-bold" m-checkbox-count>{{ $product_chooses->count() }}</span>sản phẩm</span>
		<button type="button" class="btn bg-orange-300" data-dismiss="modal">Hủy</button>
		<button type="button" class="btn choose-product-button bg-green-400 text-white" data-action="{{ $action }}" data-type="{{ $promotion }}" data-type-product="{{ $type ?? '' }}">Lưu</button>
	</div>
</div>

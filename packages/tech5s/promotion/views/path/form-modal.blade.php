<div class="modal-header">
	<h5 class="modal-title" id="modalProductLabel">Chọn sản phẩm</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="" m-checkbox="{{ $promotion }}">
	<div class="modal-body">
		<div class="form-search">
			@if (isset($flash_sale_id) && $flash_sale_id !== null)
				<input type="hidden" name="flash_sale_id" filter="flash_sale_id" value="{{ $flash_sale_id }}">
			@endif
			<input type="hidden" name="promotion" value="{{ $promotion }}" filter="promotion">
			@if (isset($action))
				<input type="hidden" name="action" value="{{ $action }}" filter="action">
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
						<option value="name">Tên sản phẩm</option>
						<option value="code">Mã sản phẩm</option>
					</select>
					<input type="text" name="q" placeholder="Nhập từ khóa" filter="q">
				</div>
			</div>
			<div class="d-flex justify-content-between my-3 align-items-center">
				<button type="button" class="btn btn-sm btn_all btn-filter-product">
					Tìm
				</button>
				<label for="product_has_promotion" class="w-full text-right pro-availabel">
					<input type="checkbox" name="product_in_promotion" style="width: initial" class="show-and-hidden-product-choose" filter="product_in_promotion" id="product_has_promotion">
					<span class="text">Sản phẩm có sẵn</span>
					
				</label>
			</div>
		</div>
		<div class="product-list">
			@include('sp::path.table')
		</div>
	</div>
	<div class="modal-footer">
		<p>
			Đã chọn <span m-checkbox-count> 0 </span> sản phẩm
		</p>
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
		<button type="button" class="btn btn_all btn-choose-product" data-promotion="{{ $promotion }}" data-action="{{ $action }}" data-type-product="{{ $type }}">Xác nhận</button>
	</div>
</form>

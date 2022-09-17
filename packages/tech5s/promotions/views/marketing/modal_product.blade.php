<div class="modal-header flex justify-between">
	<h5 class="modal-title font-bold" id="modalProductLabel">Chọn sản phẩm</h5>
	<button type="button" class="btn-close" data-dismiss="modal">X</button>
</div>
<div class="modal-body">
	<div class="form-search-item">

		<input type="hidden" name="promotion" value="{{ $promotion }}"
			filter="filter" rlm-field="item-product">
		@if (isset($type))
			<input type="hidden" name="type" value="{{ $type }}" filter="filter"
				rlm-field="item-product">
		@endif
		<div class="d-flex justify-content-between flex-wrap">
			<div class="search-category">
				<span>Danh mục</span>
				<select name="category" id="" filter="filter" rlm-field="item-product">
					<option value="">--Danh mục--</option>
					@foreach ($product_categories as $category)
						<option value="{-category.id-}">{-category.name-}</option>
					@endforeach
				</select>
			</div>
			<div class="search-name">
				<span>Tìm</span>
				<select name="by" id="" filter="filter" rlm-field="item-product">
					<option value="">-- Tìm kiếm theo --</option>
					<option value="name">Tên sản phẩm</option>
					<option value="code">Mã sản phẩm</option>
				</select>
				<input type="text" name="q" placeholder="Nhập từ khóa" filter="filter"
					rlm-field="item-product">
			</div>
			<label for="product_has_promotion" class="text-right w-full mt-3">
				Sản phẩm có sẵn
				<input type="checkbox" name="product_in_promotion" style="width: initial;"
					filter="filter"
					id="product_has_promotion" rlm-field="item-product">
			</label>
		</div>
	</div>
</div>
<div class="form-choose-product">
	<div class="modal-body">
		<table class="table">
			<thead>
				<tr>
					<th>
						<label for="product-multiple-modal" class="d-block">
							<input type="checkbox" id="product-multiple-modal" c-multiple>
							<span></span>
						</label>
						<textarea style="display:none" name="product_choose" id="" cols="30" rows="10"
       c-data>{{ json_encode($product_chooses->toArray(), JSON_UNESCAPED_UNICODE) }}</textarea>
					</th>
					<th>Sản phẩm</th>
					<th>Giá</th>
				</tr>
			</thead>
			<tbody rlm-content="item-product"
				rlm-url="sys-promotion/marketing/search-product" rlm-method="POST"
				rlm-page-current="{{ $product_chooses->count() > 0 ? 0 : 1 }}"
				rlm-functions="M_CHECKBOX.refresh">
				@include(
				    'tech5spromotion::marketing.all_product'
				)
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<span>Đã chọn<span
				class="count-choose">{{ $product_chooses->count() }}</span>sản
			phẩm</span>
		<button type="button" class="btn bg-orange-300"
			data-dismiss="modal">Hủy</button>
		<button type="button"
			class="btn choose-product-button bg-green-400 text-white"
			data-action="{{ $action }}" data-type="{{ $promotion }}"
			data-type-product="{{ $type ?? '' }}">Lưu</button>
	</div>
</div>

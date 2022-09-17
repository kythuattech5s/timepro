@extends('tech5spromotion::marketing.view')
@section('main')
	<div class="row promotion-product">
		<div class="col-lg-12">
			<form
				action="/sys-promotion/promotion_products/update/{{ $currentItem->id }}"
				class="form-validate"
				method="POST"
				data-success="AJAX_PROMOTION.createSuccess"
				absolute
				parent=".check-parent"
				autocomplete="off">
				<input type="hidden"
					name="type"
					value="create">
				<input type="hidden"
					name="returnurl"
					value="{{ request()->input('returnurl') }}">
				@csrf
				<div class="card">
					<div class="card-header flex justify-between">
						<h4 class="card-title list-link mb-3 text-[20px]">Thêm chương trình giảm giá
							theo thời gian</h4>
					</div>
					<label for="">Tên chương trình</label>
					<input type="text"
						name="name"
						placeholder="Tên chương trình khuyến mãi"
						value="{{ $currentItem->name }}"
						class="form-control mb-3"
						rules="required">
					<label>Thời gian lưu mã giảm giá</label>
					<div class="flex justify-between space-x-3">
						<input class="form-control mb-3"
							type="datetime-local"
							name="start_at"
							rules="required"
							m-required="Vui lòng chọn thời gian bắt đầu"
							value="{{ date('Y-m-d\TH:i', strtotime($currentItem->start_at)) }}">
						<input class="form-control mb-3"
							type="datetime-local"
							name="expired_at"
							value="{{ date('Y-m-d\TH:i', strtotime($currentItem->expired_at)) }}"
							rules="required"
							m-required="Vui lòng chọn thời gian kết thúc">
					</div>
					<label for="">
						Loại khuyến mãi
					</label>
					<div class="flex justify-start space-x-4">
						<label for="percent"><input id="percent" name="type_discount" type="radio"
								value="{{ PromotionProductHelper::TYPE_PERCENT }}"
								{{ $currentItem->type_discount == PromotionProductHelper::TYPE_PERCENT ? 'checked' : '' }}>
							Phần trăm</label>
						<label for="money"><input id="money" name="type_discount" type="radio"
								value="{{ PromotionProductHelper::TYPE_MONEY }}"
								{{ $currentItem->type_discount == PromotionProductHelper::TYPE_MONEY ? 'checked' : '' }}>
							Tiền</label>
					</div>
					<label for="">Khuyến mãi</label>
					<input type="text" class="form-control mb-3"
						value="{{ number_format($currentItem->discount, 0, ',', '.') }}"
						placeholder="Nhập phần trăm khuyến mãi" rules="required"
						inputNeedFormat>
					<input type="hidden"
						name="discount"
						value="{{ $currentItem->discount }}">
					<label for="">Áp dụng cho</label>
					<select name="product_day_config_id"
						id=""
						class="w-full border p-3">
						@foreach ($day_configs as $item)
							<option value="{-item.id-}"
								{{ $currentItem->product_day_config_id == $item->id ? 'selected' : '' }}>
								{-item.name-}</option>
						@endforeach
					</select>
					<label for="">Độ ưu tiên</label>
					<input type="text"
						class="form-control mb-3"
						rules="required"
						name="ord"
						value="{{ $currentItem->ord }}"
						placeholder="Độ ưu tiên">
					<label for="" class="w-full">Kích hoạt</label>
					<label for="switch-1"
						class="switch ml-2">
						<input type="checkbox"
							name="act"
							{{ $currentItem->act == 1 ? 'checked' : '' }}
							id="switch-1">
						<span class="slider"></span>
					</label>
					<label for="" class="w-full">Áp dụng các chương tiếp theo</label>
					<label for="switch-2"
						class="switch ml-2">
						<input type="checkbox"
							name="next_apply_rules"
							{{ $currentItem->next_apply_rules == 1 ? 'checked' : '' }}
							id="switch-2">
						<span class="slider"></span>
					</label>
				</div>
				<div class="footer-form">
					<a class="btn bg-red-400 text-white"
						href="{{ base64_decode(request()->input('returnurl', base64_encode(url('esystem/view/vouchers')))) }}">
						Quay lại
					</a>
					<button class="btn bg-green-400 text-white"
						type="submit">Cập nhật chương trình</button>
				</div>
			</form>
		</div>
	</div>
@endsection

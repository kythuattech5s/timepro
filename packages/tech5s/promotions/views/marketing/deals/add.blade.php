@extends('tech5spromotion::marketing.view')
@section('css')
	<link rel="stylesheet" type="text/css"
		href="{{ asset('tech5sMarketing/css/marketing/deal.css') }}">
@endsection
@section('main')
	<div class="row">
		<div class="col-lg-12">
			<form action="/sys-promotion/deals/save" class="form-validate" method="POST"
				data-success="AJAX_PROMOTION.createSuccess" absolute parent=".group-input">
				<input type="hidden" name="type" value="create">
				<input type="hidden" name="returnurl"
					value="{{ request()->input('returnurl') }}">
				@csrf
				<div class="card">
					<div class="card-header d-flex justify-content-between mb-5">
						<h4 class="card-title list-link  text-[20px] mb-3">Thêm Deal</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="manager-deal">
									<div class="deal-group">
										<div class="deal-progress active">
											<span class="number"></span>
										</div>
										<div class="content">
											<h4>Thông tin cơ bản</h4>
											<div class="deal-group__form">
												<label>Loại Deal</label>
												<div class="deal-type">
													<div class="deal-type__item position-relative">
														<input class="form-control" type="radio" id="type_code_shop"
															name="type" value="{{ DealHelper::TYPE_DEAL }}" checked>
														<label for="type_code_shop" class="flex items-center">
															<img src="{{ asset('tech5sMarketing/images/shops.png') }}"
																alt="Shop" class="mr-2">
															Mua Kèm Deal Sốc
														</label>
													</div>
													<div class="deal-type__item position-relative">
														<input class="form-control" type="radio" id=type_code_product
															name="type" value="{{ DealHelper::TYPE_GIFT }}">
														<label for="type_code_product" class="flex items-center">
															<img
																src="{{ asset('tech5sMarketing/images/online-shopping.png') }}"
																alt="Shop" class="mr-2">
															Mua Để Nhận Quà
														</label>
													</div>
												</div>
											</div>
											<div class="deal-group__form">
												<label for="deal_name">Tên chương trình</label>
												<input class="form-control" type="text" rules="required"
													id="deal_name"
													name="name" placeholder="Tên chương trình">
											</div>
											<div class="deal-group__form">
												<label>Thời gian bắt đầu/ kết thúc</label>
												<div class="deal-datetime">
													<input class="form-control" type="datetime-local" name="start_at"
														rules="required" m-required="Vui lòng chọn thời gian bắt đầu"
														value="{{ date('Y-m-d\TH:i', time() + 60 * 10) }}">
													<input class="form-control" type="datetime-local"
														name="expired_at"
														value="{{ date('Y-m-d\TH:i', time() + 60 * 10 + 60 * 60) }}"
														rules="required" m-required="Vui lòng chọn thời gian kết thúc">
												</div>
											</div>
											<div class="deal-group__form align-items-baseline"
												data-type="{{ DealHelper::TYPE_DEAL }}">
												<label for="deal_name">Giới hạn mua kèm sản phẩm</label>
												<div class="flex-fill">
													<input class="form-control" type="text" rules="required"
														id="limit"
														name="limit" placeholder="Số lượng tối đa 100">
													<p class="mt-2">Số lượng tối đa sản phẩm deal sốc mỗi
														khách
														được phép mua kèm cho mỗi
														đơn
														hàng.
													</p>
												</div>
											</div>
											<div class="deal-group__form"
												data-type="{{ DealHelper::TYPE_GIFT }}"
												style="display:none">
												<label for="deal_name">Điều kiện nhận quà</label>
												<div class="form-gift d-flex align-items-center">
													<p>Mua</p>
													<div class="group-input">
														<span>₫</span>
														<input type="text" name="price" rules="required" disabled>
													</div>
													<p>để nhận</p>
													<input type="text" name="qty" rules="required"
														placeholder="Nhập số lượng ít hơn 50" disabled>
													<p>quà tặng</p>
												</div>
											</div>
											<div class="deal-group__form justify-content-end">
												<button type="button" class="btn bg-green-400 text-white save-deal"
													data-action="{{ $action }}">Lưu</button>
											</div>
										</div>
									</div>
									<div class="deal-group">
										<div class="deal-progress">
											<span class="number"></span>
										</div>
										<div class="content">
											<div class="item-product-main"
												m-checkbox="PRODUCT_CHOOSES_PRODUCT_MAIN"
												data-action="{{ $action }}">
												<h4>Sản phẩm chính</h4>
												<p>Số lượng tối đa mỗi khách được mua là 100 sản phẩm chính trong
													cùng 1
													chương trình Mua Kèm Deal Sốc
												</p>
											</div>
										</div>
									</div>
									<div class="deal-group">
										<div class="deal-progress">
											<span class="number"></span>
										</div>
										<div class="content">
											<div class="item-product-sub" m-checkbox="PRODUCT_CHOOSES_PRODUCT_SUB"
												data-action="{{ $action }}">
												<h4>Sản phẩm mua kèm</h4>
												<p>Người mua có thể tận hưởng các sản phẩm mua kèm giá khuyến mãi khi
													họ mua
													bất
													kỳ sản phẩm chính nào.
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="footer-form d-flex justify-content-end mt-4">
									<a
										href="{{ base64_decode(request()->input('returnurl', base64_encode(url('esystem/view/deals')))) }}"
										class="btn bg-red-400 text-white me-2">Quay lại</a>
									<button class="btn bg-green-400 text-white" type="submit" disabled>Xác nhận</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	@include(
	    'tech5spromotion::marketing.modalProduct'
	)
@endsection

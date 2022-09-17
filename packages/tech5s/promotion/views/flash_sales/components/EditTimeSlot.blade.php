@php
$start_at = $flash_sale->start_at instanceof DateTime ? $flash_sale->start_at : new DateTime($flash_sale->start_at);
$expired_at = $flash_sale->start_at instanceof DateTime ? $flash_sale->expired_at : new DateTime($flash_sale->expired_at);
@endphp
@if (FlashSaleHelper::CHOOSE_SLOT)
	<button type="button" class="btn btn bg-yellow-300 text-black transition hover:bg-yellow-400" data-toggle="modal"
		data-target="#flashSaleSlot">
		Chọn khung giờ FlashSale
	</button>
	<div class="modal fade" id="flashSaleSlot" tabindex="-1"
		aria-labelledby="flashSaleSlotLabel" aria-hidden="true">
		<div class="modal-dialog w-[920px]">
			<div class="modal-content p-[15px]">
				<div class="modal-header">
					<h2 class="text-md font-bold ">Chọn khung giờ Flash Sale</h2>
				</div>
				<div class="mb-4">
					<table class="table">
						<thead>
							<tr>
								<td>Ngày</td>
								<td>Khung giờ</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input name="datetime" hidden type="date"
										value="{{ $start_at->format('Y-m-d') }}">
									<div class="calendar">
									</div>
								</td>
								<td>
									<ul class="list-hour-prd-flash-check">
										<li>
											<span>Khung giờ</span>
											<span>Sản phẩm</span>
										</li>
										<li>
											<span>
												Chọn ngày cho sự kiện flash sale
											</span>
										</li>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="group-btn-modal-flashsale flex justify-end space-x-3">
					<button class="btn bg-gray-400" data-dismiss="modal">Hủy
						bỏ</button>
					<button class="btn btn-create-slot-time bg-green-400"
						type="button">Xác
						nhận</button>
				</div>
			</div>
		</div>
	</div>
@else
	<input class="form-control" type="datetime-local" name="start_at"
		rules="required"
		m-required="Vui lòng chọn thời gian bắt đầu"
		value="{{ date('Y-m-d\TH:i', strtotime($start_at->format('Y-m-d H:i:s'))) }}">
	<input class="form-control" type="datetime-local" name="expired_at"
		value="{{ date('Y-m-d\TH:i', strtotime($expired_at->format('Y-m-d H:i:s'))) }}"
		rules="required"
		m-required="Vui lòng chọn thời gian kết thúc">
	<button class="btn btn-sm saveTimeSlot bg-green-400 text-white"
		type="button">Lưu</button>
@endif

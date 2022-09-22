<div class="modal fade" id="flashSaleSlot" tabindex="-1"
	aria-labelledby="flashSaleSlotLabel" aria-hidden="true">
	<div class="modal-dialog !w-[920px]">
		<div class="modal-content p-[15px]">
			<div class="modal-header">
				<h2 class="text-md font-bold">Chọn khung giờ Flash Sale</h2>
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
							<td class="w-[500px]">
								<input name="datetime" hidden type="date"
									value="{{ date('Y-m-d') }}">
								<div class="calendar">
								</div>
							</td>
							<td class="w-[490px]">
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

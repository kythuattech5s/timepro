@if (count($listQuestion) == 0)
	Không tìm thấy câu hỏi nào
@else
	<div class="text-right mb-3">
		<button type="button" data-action="manage-question/insert-list-question" class="btn-accept-list-question">Xác nhận chọn câu hỏi</button>
	</div>
	@foreach ($listQuestion as $item)
		<label class="list-question-item smooth d-flex align-items-center cspoint">
			<div class="info d-flex flex-wrap">
				<div class="name">
					<span>Tên:</span> {{Support::show($item,'name')}}
				</div>
				<div class="code">
					<span>Mã:</span> {{Support::show($item,'code')}}
				</div>
				<div class="note w-100">
					<span>Ghi chú:</span> {{Support::show($item,'note')}}
				</div>
			</div>
			<div class="select">
				<input type="checkbox" value="{{Support::show($item,'id')}}">
			</div>
		</label>
	@endforeach
@endif
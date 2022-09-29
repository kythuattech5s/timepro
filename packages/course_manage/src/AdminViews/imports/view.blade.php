@php
    use App\Models\OrderStatus;
    use App\Models\OrderType;
	use Tech5s\Voucher\Helpers\VoucherHelper;
@endphp
@extends('vh::master')
@section('content')
<div class="header-top aclr">
	<div class="breadc pull-left">
		<ul class="aclr pull-left list-link">
			<li class="active"><a href="javascript:void(0)">Import câu hỏi trắc nghiệm</a></li>
		</ul>
	</div>
	<div>
		<a class="pull-right bgmain1 viewsite" href="esystem/view/questions">
			<i class="fa fa-backward" aria-hidden="true"></i>
			<span class="clfff">Back</span> 
		</a>
	</div>
</div>
<div id="maincontent">
	<div id="main_view_order">
		<a href="public/file_mau_import_trac_nghiem.xlsx" class="btn btn-info" title="File Mẫu">File Mẫu <i class="fa fa-download ms-1" aria-hidden="true"></i></a>
		<form class="form-import-question" action="esystem/do-import/questions" method="post" style="max-width: 600px;margin: auto;"> 
			@csrf
			<p>Ghi chú</p>
			<input type="text" name="note" placeholder="Ghi chú" style="width: 100%;height: 36px;">
			<p class="mt-3">Nhóm câu hỏi</p>
			<select name="question_group" style="width: 100%;height: 36px;">
				<option value="">Chọn nhóm câu hỏi</option>
				@foreach ($listQuestionGroup as $itemQuestionGroup)
					<option value="{{Support::show($itemQuestionGroup,'id')}}">{{Support::show($itemQuestionGroup,'name')}}</option>
				@endforeach
			</select>
			<p class="mt-3">File excel câu hỏi</p>
			<input type="file" name="file_excel">
			<button type="submit" class="mt-4 btn btn-info">Import</button>
		</form>
		<div style="max-width: 800px;margin: 30px auto;">
			<p class="title">Lịch sử Import</p>
			<table class="table-view-order-horizontal">
				<thead>
					<tr>
						<th style="text-align:center">Stt</th>
						<th>Ghi chú</th>
						<th>Nhóm câu hỏi</th>
						<th style="text-align:center!important">File</th>
						<th>Ngày Import</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($listQuestionImportLog as $key => $itemQuestionImportLog)
						<tr>
							<td style="text-align:center"><strong>{{$key + 1}}</strong></td>
							<td>{{Support::show($itemQuestionImportLog,'note')}}</td>
							<td>{{Support::show($itemQuestionImportLog->questionGroup,'name')}}</td>
							<td style="text-align:center">
								<a href="{%IMGV2.itemQuestionImportLog.excel_file.-1%}" class="btn btn-success py-1">Tải xuống</a>
							</td>
							<td>{{Support::showDateTime($itemQuestionImportLog->created_at,'d/m/Y H:i:s')}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="pagination">
				<span class="total">{{ trans('db::number_record') }}:<strong>
						{{ $listQuestionImportLog->total() }}</strong></span>
				{{ $listQuestionImportLog->withQueryString()->links('vh::base.pagination') }}
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('.form-import-question').submit(function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				data: new FormData(this),
				processData: false,
				contentType: false,
				dataType: 'json'
			})
			.done(function(data) {
				alert(data.message);
				if (data.code == 200) {
					window.location.reload();
				}
			})
		})
	});
</script>
@stop
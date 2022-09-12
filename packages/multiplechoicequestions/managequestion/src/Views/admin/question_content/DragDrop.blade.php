@php
	$questionAnswerInfo = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($value);
@endphp
<div class="box-drag-drop">
	<textarea id="content-drag-drop-question-info" class="hidden control" name="<?php echo $nameField; ?>">{{$value}}</textarea>
	<div class="form-group">
	  	<p class="form-title">Ô điền đáp án :</p>
		<div class="list-input">
			@if (isset($questionAnswerInfo['listInput']))
				@foreach ($questionAnswerInfo['listInput'] as $key => $itemInput)
					<div class="item-drag-drop d-flex mb-3">
						<div class="w-50 pr-2">
							<p class="form-title">Nội dung</p>
							<input type="text" value="{{$itemInput ?? ''}}" class="w-100 form-control content-input" placeholder="Nội dung">
						</div>
						<div class="w-50 pl-2">
							<p class="form-title">Id Input</p>
							<div class="d-flex justify-content-between">
								<input type="text" class="form-control id-input" disabled readonly value="{{$key ?? ''}}">
								<div class="id-input-value-copy d-none">[{{$key ?? ''}}]</div>
								<div class="copy-input-drag-drop d-flex justify-content-center align-items-center">
									Copy kèm dấu []
								</div>
							</div>
						</div>
						<div class="clear-item-input">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
					</div>
				@endforeach
			@endif
		</div>
		<div class="text-center">
			<button class="button-add-input-drag-drop-question" type="button">Thêm đáp án</button>
		</div>
	</div>
	<div class="form-group">
		<div class="mb-3 border-box">
	  		<p class="form-title">Ghi chú: </p> 
	  		<p>- Ô input có thể điền không theo theo vị trí đã tạo.</p>
	  	</div>
	</div>
	<div>
	  	<p class="form-title mb-1 mt-3">Khung điền nội dung input :</p>
		<textarea id="drag_drop_content_{{time()}}" class="drag_drop_content form-control editor_box" rows="5" >{{$questionAnswerInfo['contentArea'] ?? ''}}</textarea>
		<p class="form-title mb-1 mt-3">Khung hiện đáp án đúng</p>
		<textarea id="drag_drop_true_content_{{time()}}" class="drag_drop_true_content form-control editor_box" rows="5" >{{$questionAnswerInfo['contentTrueAnswer'] ?? ''}}</textarea>
	</div>
</div>
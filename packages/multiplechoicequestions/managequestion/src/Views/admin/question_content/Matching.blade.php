@php
	$questionAnswerInfo = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($value);
@endphp
<div class="box-matching">
	<textarea id="content-matching-question-info" class="hidden control" name="<?php echo $nameField; ?>">{{$value}}</textarea>
	<div class="form-group">
	  	<p class="form-title">Cặp đáp án :</p>
		<div class="list-input">
			@if (isset($questionAnswerInfo['listInput']))
				@foreach ($questionAnswerInfo['listInput'] as $key => $itemInput)
					<div class="item-matching d-flex mb-3">
						<div class="w-50 pr-2">
							<p class="form-title">Nội dung trái</p>
							<input type="text" value="{{$itemInput['left']['value'] ?? ''}}" class="w-100 form-control content-input content-input-left" placeholder="Nội dung trái">
						</div>
						<input type="hidden" class="hidden-id-item-left" value="{{$itemInput['left']['id'] ?? ''}}">
						<div class="w-50 pl-2">
							<p class="form-title">Nội dung phải</p>
							<input type="text" value="{{$itemInput['right']['value'] ?? ''}}" class="w-100 form-control content-input content-input-right" placeholder="Nội dung phải">
						</div>
						<input type="hidden" class="hidden-id-item-right" value="{{$itemInput['right']['id'] ?? ''}}">
						<div class="clear-item-input">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
					</div>
				@endforeach
			@endif
		</div>
		<div class="text-center">
			<button class="button-add-input-matching-question" type="button">Thêm cặp đáp án</button>
		</div>
	</div>
</div>
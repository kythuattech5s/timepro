@php
	$questionAnswerInfo = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($value);
@endphp
<div class="box-click-word">
	<textarea id="content-click-word-question-info" class="hidden control" name="<?php echo $nameField; ?>">{{$value}}</textarea>
	<div class="mb-3 border-box">
  		<p class="form-title">Đọc kĩ hướng dẫn trước khi sử dụng: </p> 
  		<p>- Có thể thêm nhiều dòng đáp án.</p>
  		<p>- Với từ <span style="font-family: 'robob'">có thể click</span>, từ nào tick vào sẽ là đáp án đúng trong dòng đó. Có thể tick một hoặc nhiều đáp án đúng.</p>
  		<p>- Những từ <span style="font-family: 'robob'">không thể click</span> thường là đánh stt dòng, dấu chấm, dấu phẩy...</p>
  		<p>- Nút <span style="font-family: 'robob'">xuống dòng</span> để cắt 1 dòng đáp án thành nhiều dòng dùng cho thơ các thứ...</p>
  	</div>
	<div class="form-group">
	  	<p class="form-title">Đáp án</p>
	  	<div class="list-item-click-word">
	  		@foreach ($questionAnswerInfo as $key => $item)
	  			<div class="item-click-word mb-3 position-relative">
					<input type="hidden" class="item-word-id" value="{{$key}}">
	  				<div class="list-item-word d-flex flex-wrap justify-content-center">
	  					@foreach ($item['listWords'] as $itemWord)
	  						@switch($itemWord['type'])
	  						    @case('clickable')
	  						    	<div class="item-word d-flex align-items-center position-relative" type="clickable">
										<input type="text" class="item-word-value input-auto-size" size="{{strlen($itemWord['value'] ?? '')+1}}" value="{{$itemWord['value'] ?? ''}}">
										<label class="module-checkbox mx-1">
											<input type="checkbox" class="item-word-check" {{$itemWord['isTrue'] == 1 ? 'checked':''}}>
											<span class="checkmark"></span>
										</label>
										<input type="hidden" class="item-word-id" value="{{$itemWord['id'] ?? ''}}">
										<div class="clear-item-word cspoint">
											<i class="fa fa-times" aria-hidden="true"></i>
										</div>
									</div>
	  						        @break
	  							@case('unclickable')
		  							<div class="item-word d-flex align-items-center position-relative" type="unclickable">
										<input type="text" class="item-word-value input-auto-size mr-1" size="{{strlen($itemWord['value'] ?? '')+1}}" value="{{$itemWord['value'] ?? ''}}">
										<div class="clear-item-word cspoint">
											<i class="fa fa-times" aria-hidden="true"></i>
										</div>
									</div>
	  						        @break
	  						    @case('downline')
	  						    	<div class="item-word d-flex justify-content-end" type="downline">
										<div class="clear-item-word cspoint">
											<i class="fa fa-times" aria-hidden="true"></i>
										</div>
									</div>
	  						        @break
	  						    @default
	  						@endswitch
	  					@endforeach
	  				</div>
	  				<div class="action-word d-flex justify-content-between">
	  					<select class="text-align-mode">
	  						<option value="1" {{$item['textAlign'] == 1 ? 'selected':''}}>Căn trái</option>
	  						<option value="2" {{$item['textAlign'] == 2 ? 'selected':''}}>Căn giữa</option>
	  						<option value="3" {{$item['textAlign'] == 3 ? 'selected':''}}>Căn phải</option>
	  					</select>
	  					<div>
	  						<button type="button" class="btn-add-word">Thêm từ có thể click</button>
	  						<button type="button" class="btn-add-word-noclick-able">Thêm từ không thể click</button>
	  						<button type="button" class="btn-down-line-word">Xuống dòng</button>
	  					</div>
	  				</div>
		  			<div class="clear-item-click-word cspoint">
		  				<i class="fa fa-times" aria-hidden="true"></i>
		  			</div>
		  		</div>
	  		@endforeach
	  	</div>
	  	<div class="action-item-word text-center">
	  		<button type="button" class="btn-add-item-click-word">Thêm đáp án</button>
	  	</div>
	</div>
</div>
@php
	$questionAnswerInfo = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($value);

@endphp
<div class="box-fill-answer">
	<textarea id="content-fill-answer-question-info" class="hidden control" name="<?php echo $nameField; ?>">{{$value}}</textarea>
	<div class="form-group">
	  	<p class="form-title">Ô điền đáp án :</p>
		<div class="list-input">
			@if (isset($questionAnswerInfo['listInput']))
				@foreach ($questionAnswerInfo['listInput'] as $key => $itemInput)
					<div class="item-fill-answer d-flex mb-3">
						<div class="w-50 pr-2">
							<p class="form-title">Nội dung</p>
							<input type="text" value="{{$itemInput ?? ''}}" class="w-100 form-control content-input" placeholder="Nội dung">
						</div>
						<div class="w-50 pl-2">
							<p class="form-title">Id Input</p>
							<div class="d-flex justify-content-between">
								<input type="text" class="form-control id-input" disabled readonly value="{{$key ?? ''}}">
								<div class="id-input-value-copy d-none">[{{$key ?? ''}}]</div>
								<div class="copy-input-fill-answer d-flex justify-content-center align-items-center">
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
			<button class="button-add-input-fill-question" type="button">Thêm Ô điền đáp án</button>
		</div>
	</div>
	
	<div class="form-group">
	  	<div class="mb-3 border-box">
	  		<p class="form-title">Lưu ý: </p> 
	  		<p>- Để thêm ô điền đáp án vào nội dung vui lòng điền theo định dạng [id_input]. Vd: [input_fill_answer_123456]</p>
	  		<p>- Để thêm phân số: *phanso[input_fill_answer_123456][input_fill_answer_654321]*</p>
	  		<p>Với trường hợp muốn chèn nội dung mặc định vào phân số thì copy nội dung này và chèn vào vị trí trong đoạn mã phân số: </p> <span class="hight-light-copy-text mt-2">&lt;span class=&quot;input-content-box&quot;&gt;&lt;span class=&quot;fill_answer_resutl_box&quot;&gt; xxx &lt;/span&gt;&lt;/span&gt;</span>
	  	</div>
	  	<div class="mb-3 border-box">
	  		<div class="build-math-addition-subtraction-multiplication">
				<button class="btn-show-module-build btn btn-info" type="button">Xây dựng phép tính</button>
				<div class="content-build mt-3" style="display:none">
					<p class="mb-2">- Mỗi số hoặc input đều cần ngăn cách nhau bằng dấu '|'. Ví dụ dòng 1: <span class="hight-light-copy-text ml-3">1|2|3|[input_fill_answer_123456]|[input_fill_answer_654321]</span></p>
					<div class="line my-3 w-100" style="border-bottom:solid 1px #aaa"></div>
					<div class="row">
						<div class="col-xs-7">
							<div class="main-build">
								<div class="the-upper-part mb-3">
									<p class="form-title mb-1">Phần bên trên</p>
									<input type="text" class="line-part line-part-1 mb-2 w-100" placeholder="Dòng 1">
									<div class="d-flex justify-content-between align-items-center mb-2">
										<p class="form-title">Phép toán:</p>
										<input type="text" class="item-operator" placeholder="Phép toán ( + , - , x , : )">
									</div>
									<input type="text" class="line-part line-part-2 mb-2 w-100" placeholder="Dòng 2">
								</div>
								<div class="line my-3 w-100" style="border-bottom:solid 1px #aaa"></div>
								<div class="the-upper-below">
									<input type="text" class="line-part line-part-3 mb-2 w-100" placeholder="Kết quả">
								</div>
								<div class="text-right">
									<button class="btn-rendder btn btn-info mb-3" type="button">Render</button>
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<p class="form-title">Xem trước</p> 
							<div class="preview text-center">
								<div class="html-preview mb-3">
									
								</div>
								<button class="btn-copy-html btn btn-info d-none" type="button">Copy code và chèn vào source content</button>
								<div id="html-copy-addition-subtraction-multiplication" class="d-none my-3 border-box">
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	  	</div>
  		<div class="mb-3 border-box">
	  		<div class="build-math-number-concatenation">
		  		<button class="btn-show-module-build btn btn-info" type="button">Xây dựng dạng nối số</button>
	  			<div class="content-build mt-3" style="display:none">
		  			<p class="mb-2">- Nội dung có thế là số, chữ hoặc [input_fill_answer_123456]</p>
					<div class="line my-3 w-100" style="border-bottom:solid 1px #aaa"></div>
					<div class="row">
						<div class="col-xs-7">
							<div class="main-build">
								<div class="list-item-number-concatenation">

								</div>
								<div class="text-center">
									<button class="btn btn-success button-add-item" type="button">Thêm Item</button>
								</div>
								<div class="line my-3 w-100" style="border-bottom:solid 1px #aaa"></div>
								<div class="text-right">
									<button class="btn-rendder btn btn-info mb-3" type="button">Render</button>
								</div>
							</div>
						</div>
						<div class="col-xs-5">
							<p class="form-title">Xem trước</p> 
							<div class="preview text-center">
								<div class="html-preview mb-3">
									
								</div>
								<button class="btn-copy-html btn btn-info d-none" type="button">Copy code và chèn vào source content</button>
								<div id="html-copy-number-concatenation" class="d-none my-3 border-box">
									
								</div>
							</div>
						</div>
					</div>
				</div>
	  		</div>
	  	</div>
	  	<p class="form-title mb-1 mt-3">Khung điền nội dung input :</p>
		<textarea id="fill_answer_content_{{time()}}" class="fill_answer_content form-control editor_box" rows="5" >{{$questionAnswerInfo['contentArea'] ?? ''}}</textarea>
		<p class="form-title mb-1 mt-3">Khung hiện đáp án đúng</p>
		<textarea id="fill_answer_true_content_{{time()}}" class="fill_answer_true_content form-control editor_box" rows="5" >{{$questionAnswerInfo['contentTrueAnswer'] ?? ''}}</textarea>
	</div>
</div>
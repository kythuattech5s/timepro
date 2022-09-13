@if ($actionType=='insert'||$actionType=='copy')
	<div class="form-group">
	  	<p class="form-title" for="">{{FCHelper::er($table,'note')}}<span class="count"></span></p>
	  	<p style="font-size:18px"><i class="fa fa-info-circle text-info" style="margin-right:6px" aria-hidden="true"></i>Vui lòng lưu dữ liệu để chọn danh sách câu hỏi</p>
	</div>
@else
	<?php 
		$name = FCHelper::er($table,'name');
		$default_data = FCHelper::er($table,'default_data');
		$defaultDataInfo = json_decode($default_data,true);
		$defaultDataInfo = @$defaultDataInfo ?? array();
		$listDefaultItemQuestion = \DB::table($defaultDataInfo['pivot_table'])->where($defaultDataInfo['origin_field'],$dataItem->id)->orderBy('ord','asc')->get()->all();
		$listDefaultItemQuestionId = \DB::table($defaultDataInfo['pivot_table'])->where($defaultDataInfo['origin_field'],$dataItem->id)->orderBy('ord','asc')->pluck($defaultDataInfo['target_field'])->all();
		$idsOrder = implode(',', $listDefaultItemQuestionId);
		$idsOrder = $idsOrder == '' ? '-1':$idsOrder;
		$listQuestion = multiplechoicequestions\managequestion\Models\Question::whereIn('id',$listDefaultItemQuestionId)->orderByRaw("FIELD(id, $idsOrder)")->get();
	?>
	<link rel="stylesheet" href="managequestion/admin/base.css"/>
	<div class="form-group">
	  	<p class="form-title" for="">{{FCHelper::er($table,'note')}}<span class="count"></span></p>
	  	<div class="row">
	  		<div class="col-xs-7">
	  			<div class="form-load-list-question" data-action="manage-question/load-list-question-admin">
			  		<div class="row">
			  			<div class="col-xs-12 col-lg-6">
			  				<div class="item-fillter-box">
			  					<input type="text" class="name-search form-control" placeholder="Tìm Tên, Mã hoặc Ghi chú câu hỏi trắc nghiệm">
			  				</div>
			  			</div>
			  			<div class="col-xs-8 col-lg-3">
			  				<div class="item-fillter-box form-control form-reset flex">
			  					<select class="select2">
			  						<option value="0">Chọn loại câu hỏi</option>
			  						@foreach (multiplechoicequestions\managequestion\Models\QuestionType::act()->get() as $itemQuestionType)
			  							<option value="{{Support::show($itemQuestionType,'id')}}">{{Support::show($itemQuestionType,'name')}}</option>
			  						@endforeach
			  					</select>
			  				</div>
			  			</div>
			  			<div class="col-xs-4 col-lg-3">
			  				<div class="item-fillter-box">
			  					<button class="btn-fill-list-question" type="button">Tìm câu hỏi</button>
			  				</div>
			  			</div>
			  		</div>
			  	</div>
			  	<input type="hidden" class="default-data" value="{{$default_data}}">
			  	<input type="hidden" class="current-item" value="{{$dataItem->id}}">
			  	<div id="list-question-result"></div>
	  		</div>
	  		<div class="col-xs-5 pt-3">
	  			<p class="form-title" for="">Danh sách câu hỏi</p>
	  			@if (count($listQuestion) > 0)
	  				@foreach ($listQuestion as $key => $item)
		  				<div class="list-item-question-default position-relative" data-id="{{$listDefaultItemQuestion[$key]->{$defaultDataInfo['target_field']} }}">
		  					<div class="info d-flex flex-wrap pb-2">
			  					<div class="w-50">
									<div class="name mb-1">
										<span>Tên:</span>
										<strong>{{Support::show($item,'name')}}</strong>
									</div>
									<div class="code">
										<span>Mã:</span>
										<strong>{{Support::show($item,'code')}}</strong>
									</div>
								</div>
								<div class="w-50 text-right">
									<div class="note">
										<span>Ghi chú:</span> {{Support::show($item,'note')}}
									</div>
									<a href="{{$admincp}}/edit/questions/{{Support::show($item,'id')}}" class="btn btn-info py-1" target="_blank">Đi đến câu hỏi</a>
								</div>
		  					</div>
		  					<div class="d-flex flex-wrap text-nowrap border-top pt-2">
								<div class="d-flex align-items-center mr-4">
									<span class="mr-2">Điểm:</span>
									<input type="number" style="height: 25px;width: 100px;" class="point px-2" value="{{$listDefaultItemQuestion[$key]->point}}">
								</div>
								<div class="d-flex align-items-center select pl-2">
									<span class="d-block mr-2">Sắp xếp:</span>
									<input type="number" style="height: 25px;width: 100px;" class="ord px-2" value="{{$listDefaultItemQuestion[$key]->ord}}">
								</div>
								<div class="clear-item cspoint" data-action="manage-question/delete-item-question-pivot" data-target="{{$listDefaultItemQuestion[$key]->{$defaultDataInfo['target_field']} }}">
									<i class="fa fa-trash-o" aria-hidden="true"></i>
								</div>
							</div>
		  				</div>
		  			@endforeach
		  			<div class="text-right">
		  				<button class="btn-save-default-question-info" type="button" data-action="manage-question/update-item-question-pivot">Lưu thông tin câu hỏi</button>
		  			</div>
		  		@else
		  			Chưa có câu hỏi nào
	  			@endif
	  		</div>
	  	</div>
	</div>
	<script type="text/javascript" src="managequestion/admin/base.js" defer></script>
@endif
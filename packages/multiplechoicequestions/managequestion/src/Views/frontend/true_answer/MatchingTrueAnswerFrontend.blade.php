@php

    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;

    $answerContent = QuestionHelper::extractJson($questionFactory->question->content);

    $listInput = $answerContent['listInput'] ?? [];

@endphp

@if (!QuestionHelper::isMobile())

	<div class="basic_ques_matching basic_ques_matching_true_answer" match_ridx="{{$questionFactory->question->id ?? 0}}">

	    <div class="basic_mt_drop" style="height:{{count($listInput)*120}}px">

	    	@foreach ($listInput as $key => $item)

	    		<div class="basic_mt_drp no_drag" style="top:{{$key*120}}px" drop="{{$item['left']['id'] ?? ''}}">

		       		<div class="basic_mt_drp_top"></div>

		        	<div class="basic_mt_index bs_elm_mc_index">{{$key+1}}</div>

			        <div class="basic_mt_drp_center" style="height:85px">

			            <center>

			                <span class="stt_mat_center" style="height:85px">{{$item['left']['value'] ?? ''}}</span>

			            </center>

			        </div>

		        	<div class="basic_mt_drp_bottom"></div>

		    	</div>

	    	@endforeach

	    </div>

	   <div class="basic_mt_drag">

	   		@foreach ($listInput as $key => $item)

		        <div class="basic_mt_drg no_drag" drag="{{$item['right']['id'] ?? ''}}" style="inset: {{$key*120}}px auto auto -23px; z-index: 10; width: 345px; height: 81px;">

		            <div class="basic_mt_drg_top"></div>

		            <div class="basic_mt_drg_center" style="height:85px">

		                <center>

		                    <span class="stt_mat_center" style="height:85px">{{$item['right']['value'] ?? ''}}</span>

		                </center>

		            </div>

		            <div class="basic_mt_index bs_elm_mc_drg basic_matching_hidden"></div>

		            <div class="basic_mt_drg_bottom"></div>

		        </div>

	        @endforeach

	    </div>

	</div>

@else

	<div class="m_qzmatching_top">

		@foreach ($listInput as $key => $item)

			<div class="mqz_mat_drop basic_elm_matching">

				<div class="m_qzmatching_titem no_drag">

					<div class="m_qzmatch_titem_left">

						<div class="m_qzmatch_numl">{{$key+1}}</div>

					</div>

					<div class="m_qzmatching_titem_ct">{{$item['left']['value'] ?? ''}}</div>

				</div>

				<div class="m_qzmatching_bitem no_drag" style="margin-top: -22px;">

					<div class="m_qzmatch_bitem_left">

						<div class="m_qzmatch_bnumr"></div>

					</div>

					<div class="m_qzmatching_bitem_ct">{{$item['right']['value'] ?? ''}}</div>

				</div>

			</div>

		@endforeach

	</div>

@endif
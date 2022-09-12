@php

    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;

    $answerContent = QuestionHelper::extractJson($question->content);

    $listInput = $answerContent['listInput'] ?? [];

@endphp

<div class="Matching list-question-answer">

    @if (!QuestionHelper::isMobile())

        <div class="basic_ques_matching" match_idx="{{$question->id ?? 0}}">

           <div class="basic_mt_drop" inx="{{$question->id ?? 0}}" style="height:{{count($listInput)*120}}px">

                @foreach ($listInput as $key => $item)

                    <div class="basic_mt_drp basic_elm_matching mt_drp_{{$question->id ?? 0}} ui-droppable" tpl="matching" inx="{{$question->id ?? 0}}" top_drop="{{$key*120}}px" style="top:{{$key*120}}px" drop="{{$item['left']['id'] ?? ''}}">

                        <div class="basic_mt_drp_top"></div>

                        <div class="basic_mt_index bs_elm_mc_index">{{$key+1}}</div>

                        <div class="basic_mt_drp_center" style="ht:85pxheig">

                            <center>

                                <span class="stt_mat_center" style="height:85px">{{$item['left']['value'] ?? ''}}</span>

                            </center>

                        </div>

                        <div class="basic_mt_drp_bottom"></div>

                    </div>

                @endforeach

            </div>

            @php

                shuffle($listInput);

            @endphp

            <div class="basic_mt_drag" inx="{{$question->id ?? 0}}">

                @foreach ($listInput as $key => $item)

                    <div class="basic_mt_drg mt_drg_{{$question->id ?? 0}} ui-draggable ui-draggable-handle" inx="{{$question->id ?? 0}}" top_drag="{{$key*120}}px" style="top:{{$key*120}}px" drag="{{$item['right']['id'] ?? ''}}">

                        <div class="basic_mt_drg_top"></div>

                        <div class="basic_mt_drg_center" style="height:85px">

                            <center>

                                <span class="stt_mat_center" style="height:85px">{{$item['right']['value'] ?? ''}}</span>

                            </center>

                        </div>

                        <div class="basic_mt_index bs_elm_mc_drg basic_matching_hidden">{{$key+1}}</div>

                        <div class="basic_mt_drg_bottom"></div>

                    </div>

                @endforeach

            </div>

        </div>

    @else

        <div class="m_qzmatching_top">

            @foreach ($listInput as $key => $item)

                <div class="mqz_mat_drop basic_elm_matching" tpl="matching" inx="{{$question->id ?? 0}}" drop="{{$item['left']['id'] ?? ''}}">

                    <div class="m_qzmatching_titem" inx="{{$question->id ?? 0}}" drop="{{$item['left']['id'] ?? ''}}">

                        <div class="m_qzmatch_titem_left">

                            <div class="m_qzmatch_numl">{{$key+1}}</div>

                        </div>

                        <div class="m_qzmatching_titem_ct">{{$item['left']['value'] ?? ''}}</div>

                    </div>

                </div>

            @endforeach

        </div>

        @php

            shuffle($listInput);

        @endphp

        <div class="m_qzmatching_bottom" inx="{{$question->id ?? 0}}">

            @foreach ($listInput as $key => $item)

                <div class="m_qzmatching_bitem" drag="{{$item['right']['id'] ?? ''}}" inx="{{$question->id ?? 0}}">

                    <div class="m_qzmatch_bitem_left">

                        <div class="m_qzmatch_bnumr"></div>

                    </div>

                    <div class="m_qzmatching_bitem_ct">{{$item['right']['value'] ?? ''}}</div>

                </div>

            @endforeach

        </div>

    @endif

</div>
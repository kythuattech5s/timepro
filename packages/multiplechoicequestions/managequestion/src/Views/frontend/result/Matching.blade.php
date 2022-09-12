@php

    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;

    $answerContent = QuestionHelper::extractJson($question->content);

    $listInput = $answerContent['listInput'] ?? [];

    $statusQuestion = $question->check($answer);

    $arrInputSp = $listInput;

@endphp

<div class="Matching list-question-answer">

    @if (!QuestionHelper::isMobile())

        <div class="basic_ques_matching" match_idx="{{$question->id ?? 0}}">

            <div class="basic_mt_drop" style="height:{{count($listInput)*120}}px">

                @foreach ($listInput as $key => $item)

                    <div class="basic_mt_drp no_drag {{isset($answer[$item['left']['id']]) && $answer[$item['left']['id']] == $item['right']['id'] ? 'success':'false'}}" style="top:{{$key*120}}px" drop="{{$item['left']['id'] ?? ''}}">

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

                    @if (isset($answer[$item['left']['id']]))

                        @foreach ($listInput as $keyIn => $itemIn)

                            @if ($answer[$item['left']['id']] == $itemIn['right']['id'])

                                <div class="basic_mt_drg mt_drg_{{$question->id ?? 0}} no_drag {{$answer[$item['left']['id']] == $item['right']['id'] ? 'success':'false'}}" drag="{{$answer[$item['left']['id']] ?? ''}}" style="inset: {{$key*120}}px auto auto -23px; z-index: 10; width: 345px; height: 81px;">

                                    <div class="basic_mt_drg_top"></div>

                                    <div class="basic_mt_drg_center" style="height:85px">

                                        <center>

                                            <span class="stt_mat_center" style="height:85px">{{$itemIn['right']['value'] ?? ''}}</span>

                                        </center>

                                    </div>

                                    <div class="basic_mt_index bs_elm_mc_drg basic_matching_hidden">{{$key+1}}</div>

                                    <div class="basic_mt_drg_bottom"></div>

                                </div>

                                @php

                                    unset($arrInputSp[$keyIn]);

                                @endphp

                            @endif

                        @endforeach

                    @endif

                @endforeach

                @php

                    $listKey = array_keys($arrInputSp);

                    shuffle($listKey);

                @endphp

                @foreach ($listInput as $key => $item)

                    @if (!isset($answer[$item['left']['id']]))

                        @php

                            $itemBlank = $listInput[array_shift($listKey)];

                        @endphp

                        <div class="basic_mt_drg mt_drg_{{$question->id ?? 0}} no_drag false" drag="{{$itemBlank['right']['id'] ?? ''}}" style="inset: {{$key*120}}px auto auto -0px; z-index: 10; width: 345px; height: 81px;">

                            <div class="basic_mt_drg_top"></div>

                            <div class="basic_mt_drg_center" style="height:85px">

                                <center>

                                    <span class="stt_mat_center" style="height:85px">{{$itemBlank['right']['value'] ?? ''}}</span>

                                </center>

                            </div>

                            <div class="basic_mt_index bs_elm_mc_drg basic_matching_hidden">{{$key+1}}</div>

                            <div class="basic_mt_drg_bottom"></div>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    @else

        <div class="m_qzmatching_top">

            @foreach ($listInput as $key => $item)

                <div class="mqz_mat_drop basic_elm_matching {{isset($answer[$item['left']['id']]) && $answer[$item['left']['id']] == $item['right']['id'] ? 'success':'false'}}">

                    <div class="m_qzmatching_titem no_drag">

                        <div class="m_qzmatch_titem_left">

                            <div class="m_qzmatch_numl">{{$key+1}}</div>

                        </div>

                        <div class="m_qzmatching_titem_ct">{{$item['left']['value'] ?? ''}}</div>

                    </div>

                    @if (isset($answer[$item['left']['id']]))

                        @foreach ($listInput as $keyIn => $itemIn)

                            @if ($answer[$item['left']['id']] == $itemIn['right']['id'])

                                <div class="m_qzmatching_bitem no_drag" style="margin-top: -22px;">

                                    <div class="m_qzmatch_bitem_left">

                                        <div class="m_qzmatch_bnumr"></div>

                                    </div>

                                    <div class="m_qzmatching_bitem_ct">{{$itemIn['right']['value'] ?? ''}}</div>

                                </div>

                                @php

                                    unset($arrInputSp[$keyIn]);

                                @endphp

                            @endif

                        @endforeach

                    @endif

                </div>

            @endforeach

        </div>

        @php

            $listKey = array_keys($arrInputSp);

            shuffle($listKey);

        @endphp

        @if (count($listKey) > 0)

            <div class="m_qzmatching_bottom">

                @foreach ($listInput as $key => $item)

                    @if (!isset($answer[$item['left']['id']]))

                        @php

                            $itemBlank = $listInput[array_shift($listKey)];

                        @endphp

                        <div class="m_qzmatching_bitem no_drag">

                            <div class="m_qzmatch_bitem_left">

                                <div class="m_qzmatch_bnumr"></div>

                            </div>

                            <div class="m_qzmatching_bitem_ct">{{$itemBlank['right']['value'] ?? ''}}</div>

                        </div>

                    @endif

                @endforeach

            </div>

        @endif

    @endif

</div>
@php
    $listAnswer = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($question->content,false,null);
    $arrTrueAnswer = explode(',',$question->getTrueAnswer());
    $arrAnswer = explode(',',$answer);
@endphp
@if (isset($listAnswer))
    <div class="list-question-answer ChooseManyAnswer ChooseManyAnswer-{{count((array)$listAnswer)}} d-flex flex-wrap align-items-center question-finished justify-content-center mb-4">
        @foreach ($listAnswer as $key => $item)
            @if ($item->file_audio != '')
                <div class="item-answer basic_checkbox audio_ques {{in_array($key, $arrAnswer) ? 'checked':''}} {{in_array($key, $arrAnswer) ? in_array($key, $arrTrueAnswer) ? 'success':'false':''}}" value="{{$key}}" media="{%IMGV2.item.file_audio.-1%}">
            @else
                <div class="item-answer basic_checkbox {{in_array($key, $arrAnswer) ? 'checked':''}} {{in_array($key, $arrAnswer) ? in_array($key, $arrTrueAnswer) ? 'success':'false':''}}">
            @endif
                {!!Support::show($item,'content_question')!!}
            </div>
        @endforeach
    </div>
@endif
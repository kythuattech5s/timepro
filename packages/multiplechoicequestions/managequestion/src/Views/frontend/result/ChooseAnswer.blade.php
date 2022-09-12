@php
    $listAnswer = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($question->content,false,null);
    $statusQuestion = $question->check($answer);
@endphp
@if (isset($listAnswer))
    <div class="list-question-answer ChooseAnswer ChooseAnswer-{{count((array)$listAnswer)}} d-flex flex-wrap align-items-center justify-content-center question-finished mb-4">
        @foreach ($listAnswer as $key => $item)
            @if ($item->file_audio != '')
                <div class="item-answer basic_radio audio_ques {{$answer != '' && $key == $answer ? 'checked':''}} {{$answer != '' && $key == $answer ? $statusQuestion ? 'success':'false':''}}" value="{{$key}}" media="{%IMGV2.item.file_audio.-1%}">
            @else
                <div class="item-answer basic_radio {{$answer != '' && $key == $answer ? 'checked':''}} {{$answer != '' && $key == $answer ? $statusQuestion ? 'success':'false':''}}">
            @endif
                {!!Support::show($item,'content_question')!!}
            </div>
        @endforeach
    </div>
@endif
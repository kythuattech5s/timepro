@php
    $listAnswer = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($question->content,false,null);
    shuffle($listAnswer);
@endphp
@if (isset($listAnswer))
    <div class="list-question-answer ChooseAnswer ChooseAnswer-{{count((array)$listAnswer)}} d-flex flex-wrap align-items-center justify-content-center">
        @foreach ($listAnswer as $key => $item)
            @if ($item->file_audio != '')
                <div class="item-answer basic_radio audio_ques" value="{{$key}}" media="{%IMGV2.item.file_audio.-1%}">
            @else
                <div class="item-answer basic_radio" value="{{$key}}">
            @endif
                {!!Support::show($item,'content_question')!!}
            </div>
        @endforeach
    </div>
@endif
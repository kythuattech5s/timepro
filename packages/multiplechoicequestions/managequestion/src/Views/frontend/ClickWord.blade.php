@php
    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;
    $answerContent = QuestionHelper::extractJson($question->content);
@endphp
<div class="ClickWord list-question-answer basic_que_click_word">
	@foreach ($answerContent as $key => $item)
        @php
            $classText = 'text-left';
            switch ($item['textAlign']) {
                case 1:
                    $classText = 'text-left';
                    break;
                case 2:
                    $classText = 'text-center';
                    break;
                case 3:
                    $classText = 'text-right';
                    break;
                default:
                    $classText = 'text-left';
                    break;
            }
        @endphp
        <div class="basesic-click-word basesic-click-word-content {{$classText}}" data-idx="{{$key}}">
            @foreach ($item['listWords'] as $itemWord)
                @switch($itemWord['type'])
                    @case('clickable')
                        <span class="clickable" data-clword="{{$itemWord['id']}}">{{$itemWord['value']}}</span>
                        @break
                    @case('unclickable')
                        <span class="unclickable">{{$itemWord['value']}}</span>
                        @break
                    @case('downline')
                        <br>
                        @break
                    @default
                        @break
                @endswitch
            @endforeach
        </div>
    @endforeach
</div>
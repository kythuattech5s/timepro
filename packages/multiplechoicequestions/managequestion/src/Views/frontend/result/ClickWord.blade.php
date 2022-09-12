@php
    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;
    $answerContent = QuestionHelper::extractJson($question->content);
@endphp
<div class="ClickWord list-question-answer">
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
        <div class="basesic-click-word {{$classText}}" data-idx="{{$key}}">
            @foreach ($item['listWords'] as $itemWord)
                @switch($itemWord['type'])
                    @case('clickable')
                        @if (isset($answer[$key]) && in_array($itemWord['id'],$answer[$key]))
                            <span class="clickable no-click selected-item-word {{$itemWord['isTrue'] == 1 ? 'success':'false'}} " data-clword="{{$itemWord['id']}}">{{$itemWord['value']}}</span>
                        @else
                            <span class="clickable no-click">{{$itemWord['value']}}</span>
                        @endif
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
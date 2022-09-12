@php
    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;
    $answerContent = QuestionHelper::extractJson($questionFactory->question->content);
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
                        <span class="clickable no-click {{$itemWord['isTrue'] == 1 ? 'selected-item-word result':''}}" data-clword="{{$itemWord['id']}}">{{$itemWord['value']}}</span>
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
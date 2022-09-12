@php
    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;
    $answerContent = QuestionHelper::extractJson($question->content);
    $contentArea = $answerContent['contentArea'] ?? '';
    $listInput = $answerContent['listInput'] ?? [];
    $contentArea = QuestionHelper::replaceFillAnswerContent($contentArea,$listInput);
@endphp
<div class="s-content FillAnswer list-question-answer">
	{!!html_entity_decode($contentArea)!!}
</div>
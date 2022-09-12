@php
    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;
    $answerContent = QuestionHelper::extractJson($question->content);
    $contentArea = $answerContent['contentArea'] ?? '';
    $listInput = $answerContent['listInput'] ?? [];
    $statusQuestion = $question->check($answer);
    $contentArea = QuestionHelper::replaceFillAnswerResult($contentArea,$listInput,$answer);
@endphp
<div class="s-content FillAnswer list-question-answer">
	{!!html_entity_decode($contentArea)!!}
</div>
@php
    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;
    $answerContent = QuestionHelper::extractJson($question->content);
    $contentArea = $answerContent['contentArea'] ?? '';
    $listInput = $answerContent['listInput'] ?? [];
    $statusQuestion = $question->check($answer);
    $contentArea = QuestionHelper::replaceDragDropResult($contentArea,$listInput,$answer,$question->id);
@endphp
<div class="s-content DragDrop list-question-answer">
	{!!html_entity_decode($contentArea)!!}
</div>
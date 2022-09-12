@php
    use \multiplechoicequestions\managequestion\Helpers\QuestionHelper;
    $answerContent = QuestionHelper::extractJson($question->content);
    $contentArea = $answerContent['contentArea'] ?? '';
    $listInput = $answerContent['listInput'] ?? [];
    $contentArea = QuestionHelper::replaceDragDropContent($contentArea,$listInput,$question->id);
@endphp
<div class="s-content DragDrop list-question-answer">
	{!!html_entity_decode($contentArea)!!}
</div>
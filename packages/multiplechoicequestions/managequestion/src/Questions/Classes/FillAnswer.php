<?php
namespace multiplechoicequestions\managequestion\Questions\Classes;
use multiplechoicequestions\managequestion\Questions\Question;
use multiplechoicequestions\managequestion\Helpers\QuestionHelper;
class FillAnswer extends Question
{
	public function getTrueAnswer(){
    	if (!isset($this->question)) return '';
		$answerContent = QuestionHelper::extractJson($this->question->content);
		$listInput = $answerContent['listInput'] ?? [];
		return $listInput;
    }
    public function getTrueAnswerFrontend(){
    	if (!isset($this->question)) return '';
		$answerContent = QuestionHelper::extractJson($this->question->content);
		$content = $answerContent['contentTrueAnswer'] ?? '';
		$listInput = $answerContent['listInput'] ?? [];
    	return QuestionHelper::replaceFillAnswerResultTrueAnswer($content,$listInput);
    }
}
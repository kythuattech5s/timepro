<?php
namespace multiplechoicequestions\managequestion\Questions\Classes;
use multiplechoicequestions\managequestion\Questions\Question;
class ChooseAnswer extends Question
{
    public function getTrueAnswer(){
    	if (!isset($this->question)) return '';
		$listAnswer = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($this->question->content,false,null);
		foreach ($listAnswer as $key => $value) {
			if ((int)$value->is_true == 1) {
				return $key;
			}
		}
    	return '';
    }
    public function getTrueAnswerFrontend(){
    	if (!isset($this->question)) return '';
		$listAnswer = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($this->question->content,false,null);
		foreach ($listAnswer as $key => $value) {
			if ((int)$value->is_true == 1) {
				return $value->content_question;
			}
		}
    	return '';
    }
}
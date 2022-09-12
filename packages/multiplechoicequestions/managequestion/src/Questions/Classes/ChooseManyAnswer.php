<?php
namespace multiplechoicequestions\managequestion\Questions\Classes;
use multiplechoicequestions\managequestion\Questions\Question;
class ChooseManyAnswer extends Question
{
    public function getTrueAnswer(){
    	if (!isset($this->question)) return '';
		$listAnswer = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($this->question->content,false,null);
		$ret = '';
		foreach ($listAnswer as $key => $value) {
			if ((int)$value->is_true == 1) {
				$ret.=','.$key;
			}
		}
    	return trim($ret,',');
    }
    public function getTrueAnswerFrontend(){
    	if (!isset($this->question)) return '';
		$listAnswer = \multiplechoicequestions\managequestion\Helpers\QuestionHelper::extractJson($this->question->content,false,null);
		$ret = '';
		foreach ($listAnswer as $key => $value) {
			if ((int)$value->is_true == 1) {
				$ret.=',&nbsp;'.$value->content_question;
			}
		}
    	return '<div class="d-flex flex-wrap justify-content-center">'.trim($ret,',').'</div>';
    }
}
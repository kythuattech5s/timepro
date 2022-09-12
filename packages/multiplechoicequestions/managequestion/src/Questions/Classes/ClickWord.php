<?php
namespace multiplechoicequestions\managequestion\Questions\Classes;
use multiplechoicequestions\managequestion\Questions\Question;
use multiplechoicequestions\managequestion\Helpers\QuestionHelper;
class ClickWord extends Question
{
    public function getTrueAnswer(){
    	if (!isset($this->question)) return '';
        $answerContent = QuestionHelper::extractJson($this->question->content);
        $ret = [];
        foreach ($answerContent as $key => $item) {
            $ret[$key] = [];
            foreach ($item['listWords'] as $itemWord) {
                if (isset($itemWord['isTrue']) && $itemWord['isTrue'] == 1) {
                    array_push($ret[$key], $itemWord['id']);
                }
            }
        }
        return $ret;
    }
    public function getTrueAnswerFrontend(){
        $questionFactory = $this;
        return view('mtc::frontend.true_answer.ClickWordTrueAnswerFrontend',compact('questionFactory'))->render();
    }
}
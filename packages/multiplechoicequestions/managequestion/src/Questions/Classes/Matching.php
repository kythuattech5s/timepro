<?php
namespace multiplechoicequestions\managequestion\Questions\Classes;
use multiplechoicequestions\managequestion\Questions\Question;
use multiplechoicequestions\managequestion\Helpers\QuestionHelper;
class Matching extends Question
{
    public function getTrueAnswer(){
    	if (!isset($this->question)) return '';
        $answerContent = QuestionHelper::extractJson($this->question->content);
        $listInput = $answerContent['listInput'] ?? [];
        $ret = [];
        try {
            foreach ($listInput as $item) {
                $ret[$item['left']['id']] = $item['right']['id'];
            }
        } catch (\Exception $e) {
            
        }
        return $ret;
    }
    public function getTrueAnswerFrontend(){
        $questionFactory = $this;
    	return view('mtc::frontend.true_answer.MatchingTrueAnswerFrontend',compact('questionFactory'))->render();
    }
}
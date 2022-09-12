<?php
namespace multiplechoicequestions\managequestion\Questions;
use multiplechoicequestions\managequestion\Questions\Contracts\QuestionInterface;
class Question implements QuestionInterface
{
    public $questionType;
    public $question;
    public function __construct($questionType)
    {
        $this->questionType = $questionType;
    }
    public function getQuestionContentAdmin($value,$nameField){
        $currentItem = $this;
        $admincp = \Config::get('manager.admincp');
        return view('mtc::admin.question_content.'.$this->questionType->type,compact('value','currentItem','admincp','nameField'));
    }
    public function setQuestion($question)
    {
        $this->question = $question;
    }
    public function getTrueAnswer(){}
    public function getTrueAnswerFrontend(){}
    public function check($answer){
        return $answer == $this->getTrueAnswer();
    }
}
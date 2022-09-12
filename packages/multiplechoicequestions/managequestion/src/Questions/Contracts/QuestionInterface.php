<?php
namespace multiplechoicequestions\managequestion\Questions\Contracts;
interface QuestionInterface{
    public function getQuestionContentAdmin($value,$nameField);
    public function getTrueAnswer();
    public function getTrueAnswerFrontend();
    public function check($answer);
}
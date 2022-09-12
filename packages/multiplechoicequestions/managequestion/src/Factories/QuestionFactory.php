<?php
namespace multiplechoicequestions\managequestion\Factories;
use multiplechoicequestions\managequestion\Models\QuestionType;
class QuestionFactory
{
    public static function get($type){
        $questionType = QuestionType::find($type);
        if (!isset($questionType)) {
        }
        $classTarget = vsprintf('multiplechoicequestions\managequestion\Questions\Classes\\%s',[$questionType->type]);
        return new $classTarget($questionType);
    }
}
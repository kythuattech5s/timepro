<?php
namespace App\Models;
use \multiplechoicequestions\managequestion\Models\Question;
class ObligatoryExamResult extends BaseModel
{
    public function exam(){
        return $this->belongsTo(ObligatoryExam::class,'obligatory_exam_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function getQuestionResult()
    {
        $ret = [];
        $questionInfo = \Support::extractJson($this->question_info);
        foreach ($questionInfo as $item) {
            $dataAdd = [];
            $dataAdd['question'] = Question::with('questionType')->find($item['idx']);
            $dataAdd['answer'] = $item['answer'];
            if (isset($dataAdd['question'])) {
                $ret[$dataAdd['question']->id] = $dataAdd;
            }
        }
        return $ret;
    }
}
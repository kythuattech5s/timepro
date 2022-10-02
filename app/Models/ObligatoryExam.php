<?php
namespace App\Models;
class ObligatoryExam extends BaseModel
{
    const FORMAT_START_TIME = 'Y-m-d H:i:s';
    public function pivotQuestion(){
        return $this->hasMany(ObligatoryExamQuestion::class);
    }
    public function examResult(){
        return $this->hasMany(ObligatoryExamResult::class);
    }
    public function builDataFrontend($mapId){
        $ret = [];
        $ret['exam'] = [];
        $ret['exam']['map_id'] = $mapId;
        $ret['exam']['idx'] = $this->id;
        $ret['exam']['total_question'] = 0;
        $ret['exam']['start_time'] = '';
        $ret['exam']['type'] = 'obligatory_exam';
        $ret['exam']['status'] = 0;
        $ret['exam']['time'] = (int)$this->time;
        $ret['exam']['has_time'] = (int)$this->time > 0 ? 1:0;
        foreach ($this->pivotQuestion as $itemPivotQuestion) {
            $ret['exam']['total_question']++;
            $question = $itemPivotQuestion->question;
            if (isset($question)) {
                $dataQuestion = [];
                $dataQuestion['answer'] = '';
                $dataQuestion['type'] = $question->questionType->type;
                $dataQuestion['idx'] = $question->id;
                $ret[$question->id] = $dataQuestion;
            }
        }
        return json_encode($ret);
    }
}
<?php
namespace multiplechoicequestions\managequestion\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use multiplechoicequestions\managequestion\Factories\QuestionFactory;
use App\Models\BaseModel;
class Question extends BaseModel
{
    use HasFactory;
    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }
    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }
    public function getQuestionFactory()
    {
        $questionFactory = QuestionFactory::get($this->question_type_id);
        $questionFactory->setQuestion($this);
        return $questionFactory;
    }
    public function getTrueAnswerFrontend()
    {
        $questionFactory = $this->getQuestionFactory();
        return $questionFactory->getTrueAnswerFrontend();
    }
    public function getTrueAnswer()
    {
        $questionFactory = $this->getQuestionFactory();
        return $questionFactory->getTrueAnswer();
    }
    public function builDataFrontend()
    {
        $ret = [];
        $ret['correct'] = $this->getTrueAnswer();
        $ret['answer'] = '';
        $ret['status'] = 0;
        $ret['type'] = $this->questionType->type;
        $ret['idx'] = $this->id;
        return $ret;
    }
    public function check($answer)
    {
        $questionFactory = $this->getQuestionFactory();
        return $questionFactory->check($answer);
    }
}
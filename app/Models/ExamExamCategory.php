<?php
namespace App\Models;
class ExamExamCategory extends BaseModel
{
    protected $table = 'exam_exam_category';
    public function examCategory()
    {
    	return $this->belongsTo(ExamCategory::class, 'exam_category_id', 'id');
    }
}
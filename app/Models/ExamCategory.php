<?php
namespace App\Models;
class ExamCategory extends BaseModel
{
    public function exam(){
    	return $this->belongsToMany(Exam::class, 'exam_exam_category', 'exam_category_id', 'exam_id');
    }
    public function getParent(){
        return $this->belongsTo(static::class,'parent','id');
    }
}
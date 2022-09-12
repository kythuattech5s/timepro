<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CourseCategory extends BaseModel
{
    use HasFactory;
    public function getParent(){
        return $this->belongsTo(static::class,'parent','id');
    }
}
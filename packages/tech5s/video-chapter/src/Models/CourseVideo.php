<?php

namespace Tech5s\VideoChapter\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function getDurationView()
    {
        return sprintf('%02d giờ %02d phút',($this->duration/3600),$this->duration/60%60);
    }
    public function isFree()
    {
        return $this->type == 0;
    }
}

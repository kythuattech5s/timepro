<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseTimePackage extends BaseModel
{
    use HasFactory;

    public function getPrice()
    {
        $course = $this->course;
        $price = $this->price;
        $flashSale = $course->flashSale->first(fn ($q) => $q->start_at < now() && $q->expired_at > now() );
        if ($flashSale != null) {
            $currentCourse = $flashSale->courses->first(fn ($q) => $q->id == $course->id && $q->pivot->act == 1);
            if ($currentCourse != null) {
                $discount = $currentCourse->pivot->discount;
                $price = $price - ($price * $discount / 100);
            }
        }
        return $price;
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}

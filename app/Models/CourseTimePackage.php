<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use stdClass;

class CourseTimePackage extends BaseModel
{
    use HasFactory;

    public function getPrice()
    {
        $course = $this->course;
        $price = $this->price;
        $flashSale = $course->flashSale->first(fn ($q) => $q->act == 1 && $q->start_at < now() && $q->expired_at > now());
        if ($flashSale != null) {
            $currentCourse = $flashSale->courses->first(fn ($q) => $q->id == $course->id && $q->pivot->act == 1);
            if ($currentCourse != null) {
                $discount = $currentCourse->pivot->discount;
                $price = $price - ($price * $discount / 100);
            }
        }
        return $price;
    }
    public function getPriceInfo()
    {
        $priceInfo = new stdClass;
        $priceInfo->price = $this->price;
        $priceInfo->price_old = $this->price_old;
        $flashSalePrice = $this->getPrice();
        if ($priceInfo->price > $flashSalePrice) {
            $priceInfo->price = $flashSalePrice;
            $priceInfo->price_old = $this->price;
        }
        return $priceInfo;
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}

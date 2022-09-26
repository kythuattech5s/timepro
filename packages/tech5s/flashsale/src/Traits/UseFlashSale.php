<?php

namespace Tech5s\FlashSale\Traits;

use DateTime;
use Tech5s\FlashSale\Models\FlashSale;

trait UseFlashSale
{
    public function flashSale()
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_course', 'course_id', 'flash_sale_id')->withPivot([
            'act',
            'discount',
        ]);
    }
}

<?php

namespace Tech5s\Promotion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromotionSlotTime extends BaseModel
{
    use HasFactory;

    public function FlashSales()
    {
        return $this->belongsToMany(FlashSale::class);
    }
}

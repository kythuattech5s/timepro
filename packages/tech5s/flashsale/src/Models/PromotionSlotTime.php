<?php

namespace Tech5s\FlashSale\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromotionSlotTime extends BaseModel
{
    use HasFactory;

    public function FlashSales()
    {
        return $this->belongsToMany(FlashSale::class);
    }
}

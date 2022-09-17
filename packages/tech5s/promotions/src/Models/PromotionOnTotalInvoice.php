<?php

namespace Tech5s\Promotion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
class PromotionOnTotalInvoice extends BaseModel
{
    use HasFactory;

    const TYPE_PERCENT = 1;
    const TYPE_MONEY = 2;
}
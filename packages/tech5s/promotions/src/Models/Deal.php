<?php

namespace Tech5s\Promotion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Deal extends BaseModel
{
    use HasFactory;
    public function productMain()
    {
        return $this->belongsToMany(Product::class, 'deal_product_mains', 'deal_id', 'product_id')->withPivot('act');
    }

    public function productSub()
    {
        return $this->belongsToMany(Product::class, 'deal_product_subs', 'deal_id', 'product_id')
        ->orderByRaw('(CASE WHEN deal_product_subs.ord is not null then deal_product_subs.ord end) DESC')
        ->withPivot('price', 'percent', 'limit', 'act', 'ord');
    }
}

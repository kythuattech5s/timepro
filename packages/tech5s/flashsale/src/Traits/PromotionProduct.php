<?php

namespace Tech5s\FlashSale\Traits;

use DateTime;
use Tech5s\FlashSale\Models\FlashSale;

trait PromotionProduct
{
    public function flash_sale()
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_products', 'product_id', 'flash_sale_id')->withPivot([
            'qty',
            'price',
            'percent',
            'limit',
            'act',
        ]);
    }

    public function flashSaleCurrent()
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_products', 'product_id', 'flash_sale_id')->where('flash_sales.act', 1)->where('start_at', '<=', new \DateTime())->where('expired_at', '>=', new DateTime())->withPivot([
            'qty',
            'price',
            'percent',
            'limit',
            'act',
        ]);
    }
}

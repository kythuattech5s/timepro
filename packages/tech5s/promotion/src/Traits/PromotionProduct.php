<?php

namespace Tech5s\Promotion\Traits;

use DateTime;
use Tech5s\Promotion\Models\Combo;
use Tech5s\Promotion\Models\Deal;
use Tech5s\Promotion\Models\FlashSale;
use Tech5s\Promotion\Models\Voucher;

trait PromotionProduct
{
    public function voucher()
    {
        return $this->belongsToMany(Voucher::class, 'voucher_products', 'product_id', 'voucher_id');
    }
    public function dealMain()
    {
        return $this->belongsToMany(Deal::class, 'deal_product_mains', 'product_id', 'deal_id')->withPivot(['act']);
    }

    public function dealSub()
    {
        return $this->belongsToMany(Deal::class, 'deal_product_subs', 'product_id', 'deal_id')->withPivot([
            'percent',
            'price',
            'limit',
            'act',
            'ord',
        ]);
    }

    public function combo()
    {
        return $this->belongsToMany(Combo::class, 'combo_products', 'product_id', 'combo_id')->withPivot(['act']);
    }

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

    public function comboCurrent()
    {
        return $this->belongsToMany(Combo::class, 'combo_products', 'product_id', 'combo_id')->where('combos.act', 1)->where('start_at', '<=', new \DateTime())->where('expired_at', '>=', new DateTime())->withPivot(['act']);
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
    public function DealMainCurrent()
    {
        return $this->belongsToMany(Deal::class, 'deal_product_mains', 'product_id', 'deal_id')->where('deals.act', 1)->where('start_at', '<=', new \DateTime())->where('expired_at', '>=', new DateTime())->withPivot(['act']);
    }
    public function DealSubCurrent()
    {
        return $this->belongsToMany(Deal::class, 'deal_product_subs', 'product_id', 'deal_id')->where('deals.act', 1)->where('start_at', '<=', new \DateTime())->where('expired_at', '>=', new DateTime())->withPivot([
            'percent',
            'price',
            'limit',
            'act',
            'ord',
        ]);
    }

    public function getPrice()
    {
        $listPrice = collect();
        if ($this->variants->count() > 0) {
            foreach ($this->variants as $product) {
                $listPrice[] = $product->price;
            }
        } else {
            $listPrice[] = $this->price;
        }
        return $listPrice;
    }
}

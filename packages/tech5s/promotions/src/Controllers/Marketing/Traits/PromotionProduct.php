<?php

namespace Tech5s\Promotion\Controllers\Marketing\Traits;

use DateTime;
use Tech5s\Promotion\Models\CatalogPriceRule;
use Tech5s\Promotion\Models\Combo;
use Tech5s\Promotion\Models\Deal;
use Tech5s\Promotion\Models\FlashSale;
use Tech5s\Promotion\Models\ProductDayConfig;
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

    public function catalog_price_rules()
    {
        return $this->belongsToMany(CatalogPriceRule::class, 'catalog_price_rule_products', 'product_id', 'catalog_price_rule_id');
    }

    public function catelog_price_rules_current()
    {
        return $this->belongsToMany(CatalogPriceRule::class, 'catalog_price_rule_products', 'product_id', 'catalog_price_rule_id')->where('start', '<=', new \DateTime())->where('end', '>=', new \DateTime())->withPivot('qty_apply');
    }
    public function getTypeProductByTime(){
        $product_days = \Cache::rememberForever('product_day', function () {
            return ProductDayConfig::all();
        });
        $type = null;
        foreach($product_days as $day){
            $dateModify = $day->from;
            if((new DateTime($this->created_at))->modify("+ {$dateModify} days") < new DateTime()){
                $type = $day;
            }
        }
        return $type;
    }
}

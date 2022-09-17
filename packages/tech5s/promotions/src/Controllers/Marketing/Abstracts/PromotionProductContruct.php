<?php

namespace Tech5s\Promotion\Controllers\Marketing\Abstracts;

use Tech5s\Promotion\Controllers\Marketing\Condition\PromotionProductCondition;
use Tech5s\Promotion\Models\PromotionProduct;

class PromotionProductContruct extends PromotionProductCondition
{
    public $promotionProduct;
    public $promotionProductOld;
    public $products;
    const PREFIX_SESSION_PRODUCT = 'PROMOTION_PRODUCT';

    public function __construct(int $id = null)
    {
        $this->promotionProduct = is_null($id) ? new PromotionProduct : PromotionProduct::find($id);
        $this->promotionProductOld = clone $this->promotionProduct;
    }

    public function setName(string $name)
    {
        $this->promotionProduct->name = $name;
    }

    public function setDiscount(int $discount)
    {
        $this->promotionProduct->discount = $discount;
    }

    public function setTypeDiscount(int $type_discount)
    {
        $this->promotionProduct->type_discount = $type_discount;
    }

    public function setStartAt(\DateTime $start_at)
    {
        $this->promotionProduct->start_at = $start_at;
    }
    public function setExpiredAt(\DateTime $expired_at)
    {
        $this->promotionProduct->expired_at = $expired_at;
    }

    public function setAct(int $act = 1)
    {
        return $this->promotionProduct->act = $act;
    }

    public function setOrd(int $ord = null)
    {
        return $this->promotionProduct->ord = $ord;
    }

    public function setNextApplyRules(int $next_apply_rules)
    {
        return $this->promotionProduct->next_apply_rules = $next_apply_rules;
    }

    public function setProductDayConfig(int $product_day_config_id)
    {
        return $this->promotionProduct->product_day_config_id = $product_day_config_id;
    }
    public function setDataPromotion()
    {
        $request = request();
        $this->setName($request->input('name'));
        $this->setStartAt(new \DateTime($request->input('start_at')));
        $this->setExpiredAt(new \DateTime($request->input('expired_at')));
        $this->setDiscount($request->input('discount'));
        $this->setTypeDiscount((int) $request->input('type_discount'));
        $this->setOrd((int) $request->input('ord', 0));
        $this->setNextApplyRules(is_null($request->input('next_apply_rules')) ? 0 : 1);
        $this->setProductDayConfig($request->input('product_day_config_id'));
        $this->setAct(is_null(($request->input('act', 0))) ? 0 : 1);
    }

    public function save()
    {
        $this->promotionProduct->save();
    }

    public function flush()
    {
        session()->forget(static::PREFIX_SESSION_PRODUCT);
    }
}

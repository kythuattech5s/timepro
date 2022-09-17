<?php

namespace Tech5s\Promotion\Helpers;

use App\Models\Property;
use Illuminate\Support\Collection;
use ProductHelper;
use Tech5sPromotion\Models\PromotionProduct;

class PromotionItem
{
    public $promotions;
    public $price;
    public $qty;
    public $properties;
    public $discount;
    public $product;
    public $rowId;
    public $price_old;
    const RULES_METHOD_PERCENT = 1;
    const RULES_METHOD_MONEY = 2;
    
    const NO_ACCEPT_NEXT_RULES = 0;
    const ACCEPT_NEXT_RULES = 1;

    public function __construct($item)
    {
        $this->setQty($item['qty']);
        $this->setProduct($item['item']);
        $this->setProperty($item['item']->productPropertyCategories());
        $this->setPromotion($item['item']);
        $this->setRowId($item['rowId']);
        $price = $this->getPriceCurrent($item['item']);
        $this->setPrice($price);
        if (!is_null($item['item']->price_old)) {
            $this->setPriceOld($item['item']->price_old);
        }
    }

    public function getPriceCurrent($item)
    {
        //Lấy giá hiện tại của sản phẩm
        /**
         * Bao gồm:
         * Chiết khấu trực tiếp cố định
         * chiết khấu theo thời gian của sản phẩm
         * chiết khấu theo quy tắc danh mục
         * */
        
        $discount = collect();
        // $discount['normal'] = collect([
        //     'name' => 'Chiết khấu cố định',
        //     'discount' => $item->price_origin > $item->price ? ($item->price_origin - $item->price) * $this->qty  : 0,
        // ]);
        $price = $item->price;
        $type = $item->getTypeProductByTime();
        $promotions = PromotionProduct::where('start_at', '<=', new \DateTime())->where('expired_at', '>=', new \DateTime())->orderBy('ord', 'DESC')->where('product_day_config_id', $type->id)->where('act', 1)->get();

        foreach ($promotions as $promotion) {
            if (!isset($discount['by_time'])) {
                $discount['by_time'] = collect([
                    'name' => 'Chiết khấu cố định theo loại sản phẩm',
                    'discount' => 0,
                ]);
            }

            if ($promotion->next_apply_rules !== static::ACCEPT_NEXT_RULES || ($promotion->type_discount == static::RULES_METHOD_MONEY && $promotion->price < $promotion->discount)) {
                break;
            }
            $discountPromotion = $promotion->type_discount == static::RULES_METHOD_PERCENT ? $price * $promotion->discount / 100 : $promotion->discount;
            $price -= $discountPromotion;
            $discount['by_time']['discount'] += $discountPromotion * $this->qty;
        }

        $this->setDiscount($discount);
        return $price;
    }

    public function setRowId(string $rowId)
    {
        $this->rowId = $rowId;
    }

    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    public function setPriceOld(int $price)
    {
        $this->price_old = $price;
    }

    public function setDiscount(Collection $discount)
    {
        $this->discount = $discount;
    }

    public function setProduct($item)
    {
        $this->product = $item;
    }

    public function setProperty($hash_properties)
    {
        $this->properties = Property::with('propertyCategory')->find(explode('-', $hash_properties));
    }

    public function setQty(int $qty)
    {
        $this->qty = $qty;
    }

    public function setPromotion($item)
    {

        $this->promotions = $this->allPromotionOfProduct($item);
    }

    //Lấy tất cả các chương trình khuyến mãi của sản phẩm
    public function allPromotionOfProduct($item)
    {
        $promotions = collect();
        $data = [
            'combos' => $item->comboCurrent->count() > 0 ? $item->comboCurrent : null,
            'flash_sales' => $item->flashSaleCurrent->count() > 0 ? $item->flashSaleCurrent : null,
        ];
        if ($item->dealMainCurrent->count() > 0) {
            $data['deals'] = $item->dealMainCurrent;
        }

        if (($productParent = $item->getParent) !== null) {
            if ($productParent->comboCurrent->count() > 0) {
                $data['combos'] = $data['combos'] instanceof Collection ? $data['combos']->merge($productParent->comboCurrent) : $productParent->comboCurrent;
            }
        }

        $promotions = collect(array_filter($data));
        return $promotions;
    }
}

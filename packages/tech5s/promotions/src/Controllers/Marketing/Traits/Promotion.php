<?php

namespace Tech5s\Promotion\Controllers\Marketing\Traits;

trait Promotion
{

    public function allProduct()
    {
        if ($this instanceof \Tech5s\Promotion\Models\Voucher) {
            return $this->getProductVoucher();
        } elseif ($this instanceof \Tech5s\Promotion\Models\Combo) {
            return $this->getProductCombo();
        }
    }

    public function getProductVoucher()
    {
        $products = collect();
        foreach ($this->products as $product) {
            if ($product->variants->count() > 0) {
                foreach ($product->variants as $item_variant) {
                    $products[] = $item_variant;
                }
            } else {
                $products[] = $product;
            }
        }
        return $products;
    }

    public function getProductCombo()
    {
        $products = collect();
        foreach ($this->products as $product) {
            if ($product->variants->count() > 0) {
                foreach ($product->variants as $item_variant) {
                    $products[] = $item_variant;
                }
            } else {
                $products[] = $product;
            }
        }
        return $products;
    }
}

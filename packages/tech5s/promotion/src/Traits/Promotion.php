<?php

namespace Tech5s\Promotion\Traits;

use Tech5s\Promotion\Models\Combo;
use Tech5s\Promotion\Models\Voucher;
use VoucherHelper;

trait Promotion
{
    public function allProduct()
    {
        if ($this instanceof Voucher) {
            return $this->getProductVoucher();
        } elseif ($this instanceof Combo) {
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

    public function getNameShowUser()
    {
        if ($this->voucher_type == VoucherHelper::VOUCHER_TYPE_PROMOTION) {
            if ($this->type_discount == VoucherHelper::DISCOUNT_MONEY) {
                return 'Giảm ' . ($this->discount > 0 ? $this->discount / 1000 : 0) . 'k';
            }
            if ($this->type_discount == VoucherHelper::DISCOUNT_PERCENT) {
                return 'Giảm ' . $this->discount . '%';
            }
        }
        if ($this->voucher_type == VoucherHelper::VOUCHER_TYPE_COIN) {
            if ($this->type_discount == VoucherHelper::DISCOUNT_PERCENT) {
                return "Hoàn lại $this->discount% point";
            }
        }
        return '';
    }
}

<?php

namespace Tech5s\Promotion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Tech5s\Promotion\Controllers\Marketing\Traits\Promotion;
use VoucherHelper;
use App\Models\User;

class Voucher extends BaseModel
{
    use HasFactory, Promotion;
    public function products()
    {
        return $this->belongsToMany(Product::class, 'voucher_product', 'voucher_id', 'product_id');
    }

    public function isHasLimitDiscount()
    {
        return !is_null($this->max_discount);
    }
    public function getNameShowUser()
    {
        if ($this->voucher_type == VoucherHelper::VOUCHER_TYPE_PROMOTION) {
            if ($this->type_discount == VoucherHelper::DISCOUNT_MONEY) {
                return 'Giảm ' . $this->getDiscountVoucher();
            }
            if ($this->type_discount == VoucherHelper::DISCOUNT_PERCENT) {
                return 'Giảm ' . $this->getDiscountVoucher();
            }
        }
        if ($this->voucher_type == VoucherHelper::VOUCHER_TYPE_COIN) {
            if ($this->type_discount == VoucherHelper::DISCOUNT_PERCENT) {
                return 'Hoàn lại ' . $this->getDiscountVoucher() . CoinWallet::getCoinUnit();
            }
        }
        return '';
    }

    public function getDiscountVoucher()
    {
        if ($this->type_discount == VoucherHelper::DISCOUNT_MONEY) {
            return ($this->discount > 0 ? $this->discount / 1000 : 0) . 'k';
        }
        if ($this->type_discount == VoucherHelper::DISCOUNT_PERCENT) {
            return $this->discount . '%';
        }
        return '';
    }

    public function getLimitDiscountText()
    {
        if ($this->voucher_type == VoucherHelper::VOUCHER_TYPE_PROMOTION) {
            return ($this->max_discount > 0 ? $this->max_discount / 1000 : 0) . 'k';
        }
        if ($this->voucher_type == VoucherHelper::VOUCHER_TYPE_COIN) {
            return ($this->max_discount > 0 ? $this->max_discount / 1000 : 0) . 'k ' . CoinWallet::getCoinUnit();
        }
    }

    public function countUsage()
    {
        return $this->users->count();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'voucher_users', 'user_id', 'voucher_id');
    }
}

<?php

namespace Tech5s\Promotion\Models;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tech5s\Promotion\Helpers\VoucherHelper;
use Tech5s\Promotion\Traits\Promotion;

class Voucher extends Model
{
    use HasFactory, Promotion;
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'voucher_course', 'voucher_id', 'course_id');
    }

    public function course_categories()
    {
        return $this->belongsToMany(CourseCategory::class, 'voucher_course_category', 'voucher_id', 'course_category_id');
    }

    public function isHasLimitDiscount()
    {
        return !is_null($this->max_discount);
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
                // return 'Hoàn lại ' . $this->discount . '% ' . CoinWallet::getCoinUnit();
            }
        }
        return '';
    }
    public function getLimitDiscountText()
    {
        if ($this->voucher_type == VoucherHelper::VOUCHER_TYPE_PROMOTION) {
            return ($this->max_discount > 0 ? $this->max_discount / 1000 : 0) . 'k';
        }
        if ($this->voucher_type == VoucherHelper::VOUCHER_TYPE_COIN) {
            // return ($this->max_discount > 0 ? $this->max_discount / 1000 : 0) . 'k ' . CoinWallet::getCoinUnit();
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

    public function userSaves()
    {
        return $this->morphToMany(User::class, 'voucherable');
    }
}

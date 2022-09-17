<?php

namespace Tech5s\Promotion\Models;

use App\Models\CourseCategory;
use Currency;
use DateTime;
use FlashSaleHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tech5s\Promotion\Traits\FlashSaleTrait;
use Tech5s\Promotion\Traits\ScopeStatus;

class FlashSale extends BaseModel
{
    use HasFactory, ScopeStatus, FlashSaleTrait;

    public function promotionTypeComparison()
    {
        return $this->belongsTo(PromotionTypeComparison::class);
    }

    public function course_categories()
    {
        return $this->belongsToMany(CourseCategory::class, 'flash_sale_course_category', 'flash_sale_id', 'course_category_id');
    }

    public function scopeAct($query)
    {
        return $query->where('act', 1);
    }

    public function getTimeRegister()
    {
        $time_start = strtotime($this->start_at);
        $time_end = strtotime($this->expired_at);
        $now = time();

        $timeStamp = $time_start - $now;
        if ($timeStamp < 0) {
            return false;
        }

        $day = floor($timeStamp / (24 * 60 * 60));
        $hour = floor($timeStamp / (60 * 60));
        $minutes = floor($timeStamp / 60);
        $minutes = $minutes >= 60 ? $minutes - $hour * 60 : $minutes;
        $hour = $hour >= 24 ? $hour - $day * 24 : $hour;
        if ($day > 0) {
            return $day . ' ngày' . $hour . 'h';
        } elseif ($hour > 0) {
            return $hour . 'h ' . $minutes . 'p';
        } elseif ($minutes > 0) {
            return $minutes . 'phút';
        }
    }

    public function isRunning()
    {
        return new DateTime($this->start_at) <= new DateTime() && new DateTime($this->expired_at) >= new DateTime();
    }

    public function getCondition()
    {
        if ($this->promotion_type_comparison_id == FlashSaleHelper::COMPARE_BIGGER) {
            return 'Các sản phẩm sau khi giảm giá phải lớn hơn ' . Currency::showMoney($this->discount);
        } elseif ($this->promotion_type_comparison_id == FlashSaleHelper::COMPARE_SMALLER) {
            return 'Các sản phẩm sau khi giảm giá phải nhỏ hơn ' . Currency::showMoney($this->discount);
        } elseif ($this->promotion_type_comparison_id == FlashSaleHelper::COMPARE_SAME) {
            return 'Các sản phẩm sau khi giảm giá phải bằng ' . Currency::showMoney($this->discount);
        }
    }
}

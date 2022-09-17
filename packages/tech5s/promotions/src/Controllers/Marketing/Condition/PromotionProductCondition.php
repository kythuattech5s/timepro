<?php
namespace Tech5s\Promotion\Controllers\Marketing\Condition;

use DateTime;

class PromotionProductCondition
{
    public function checkTimeCreate()
    {
        $start_at = clone $this->promotionProduct->start_at;
        $expired_at = clone $this->promotionProduct->expired_at;
        $now = new DateTime();
        if ($start_at < $now) {
            return 'Thời gian bắt đầu không thể nhỏ hơn thời gian hiện tại';
        }
        if ($start_at > $expired_at) {
            return 'Thời gian bắt đầu không thể lớn hơn thời gian kết thúc';
        }

        if ($expired_at->modify("-1 hour") < $start_at) {
            return 'Thời gian diễn ra sự kiện phải ít nhất 1 giờ';
        }
        return false;
    }

    public function checkTimeUpdate()
    {
        $voucher_start_at = clone new DateTime($this->promotionProductOld->start_at);
        $voucher_expired_at = clone new DateTime($this->promotionProductOld->expired_at);
        $start_at = clone $this->promotionProduct->start_at;
        $expired_at = clone $this->promotionProduct->expired_at;
        $now = new DateTime();

        if ($voucher_expired_at < $now) {
            return 'Voucher đã kết thúc không được chỉnh sửa';
        }

        if ($voucher_start_at < $now) {
            return 'Không thể chỉnh sửa voucher đang chạy';
        }

        if ($start_at < $now && $voucher_start_at > $now) {
            return 'Thời gian bắt đầu không thể nhỏ hơn thời gian hiện tại';
        }

        if ($start_at > $expired_at) {
            return 'Thời gian bắt đầu không thể lớn hơn thời gian kết thúc';
        }

        if ($expired_at->modify("-1 hour") < $start_at) {
            return 'Thời gian diễn ra sự kiện phải ít nhất 1 giờ';
        }
        return false;
    }
}

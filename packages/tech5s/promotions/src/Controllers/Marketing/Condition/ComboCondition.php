<?php
namespace Tech5s\Promotion\Controllers\Marketing\Condition;
use DateTime;

class ComboCondition{
    public function checkTimeCreate()
    {
        if($this->combo->start_at == null){
            return 'Vui lòng chọn khung giờ FlashSale';
        }
        if($this->combo->expired_at == null){
            return 'Vui lòng chọn khung giờ FlashSale';
        }
        $start_at = clone $this->combo->start_at;
        $expired_at = clone $this->combo->expired_at;
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

    public function checkTimeUpdate(){
        $voucher_start_at = clone new DateTime($this->combo_old->start_at);
        $voucher_expired_at = clone new DateTime($this->combo_old->expired_at);
        $start_at = clone $this->combo->start_at;
        $expired_at = clone $this->combo->expired_at;
        $now = new DateTime();

        if($voucher_expired_at < $now) {
            return 'Combo đã kết thúc không được chỉnh sửa';
        }

        if ($voucher_start_at < $now) {
            return 'Không thể chỉnh sửa combo đang chạy';
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

    public function checkProduct(){
        if($this->products->count() == 0){
            return 'Vui lòng chọn sản phẩm cho combo khuyến mãi';
        }
    }
}

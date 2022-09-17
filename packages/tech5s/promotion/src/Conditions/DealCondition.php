<?php
namespace Tech5s\Promotion\Conditions;

use DateTime;
use Tech5s\Promotion\Helpers\DealHelper;

class DealCondition
{
    public function checkTimeCurrent()
    {
        $start_at = $this->deal->start_at instanceof DateTime ? $this->deal->start_at : new DateTime($this->deal->start_at);
        $expired_at = $this->deal->expired_at instanceof DateTime ? $this->deal->expired_at : new DateTime($this->deal->expired_at);
        $now = new DateTime();
        if ($start_at < $now && $expired_at > $now) {
            return 'Không thể thay đổi chương trình đang diễn ra';
        }

        if ($expired_at < $now) {
            return 'Không thể thay đổi chương trình đã diễn ra';
        }

        return false;
    }

    public function checkTimeCreate()
    {
        if ($this->deal->start_at == null) {
            return 'Vui lòng chọn khung giờ FlashSale';
        }
        if ($this->deal->expired_at == null) {
            return 'Vui lòng chọn khung giờ FlashSale';
        }
        $start_at = clone $this->deal->start_at;
        $expired_at = clone $this->deal->expired_at;
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
        $deal_start_at = clone new DateTime($this->deal_old->start_at);
        $deal_expired_at = clone new DateTime($this->deal_old->expired_at);
        $start_at = clone $this->deal->start_at;
        $expired_at = clone $this->deal->expired_at;
        $now = new DateTime();

        if ($deal_expired_at < $now) {
            return 'deal đã kết thúc không được chỉnh sửa';
        }

        if ($deal_start_at < $now) {
            return 'Không thể chỉnh sửa deal đang chạy';
        }

        if ($start_at < $now && $deal_start_at > $now) {
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

    public function checkTimeEditNow()
    {
        $request = request();
        $deal_start_at = $this->deal->start_at instanceof DateTime ? $this->deal->start_at : new DateTime($this->deal->start_at);
        $deal_expired_at = $this->deal->expired_at instanceof DateTime ? $this->deal->expired_at : new DateTime($this->deal->expired_at);
        $start_at = new DateTime($request->start_at);
        $expired_at = new DateTime($request->expired_at);
        $now = new DateTime();

        if ($deal_expired_at < $now) {
            return 'Deal đã kết thúc không được chỉnh sửa';
        }

        if ($deal_expired_at < $now) {
            return 'Không thể chỉnh sửa deal đang chạy';
        }

        if ($start_at < $now && $deal_start_at > $now) {
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

    public function checkProduct()
    {
        if ($this->products->count() == 0) {
            return 'Vui lòng chọn sản phẩm cho deal khuyến mãi';
        }
    }

    public function checkProductSub()
    {
        $request = request();
        if ($request->type == 'sub' && $this->deal->type == DealHelper::TYPE_DEAL && $this->deal->limit < count($request->product_id)) {
            return 'Số lượng sản phẩm mua kèm phải nhỏ hơn hoặc bằng ' . $this->deal->limit;
        }
    }
}

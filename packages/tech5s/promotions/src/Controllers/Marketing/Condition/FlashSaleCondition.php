<?php
namespace Tech5s\Promotion\Controllers\Marketing\Condition;

use Tech5s\Promotion\Models\FlashSale;
use DateTime;
class FlashSaleCondition{

    public function checkTimeCreate()
    {
        if($this->flash_sale->start_at == null){
            return 'Vui lòng chọn khung giờ FlashSale';
        }
        if($this->flash_sale->expired_at == null){
            return 'Vui lòng chọn khung giờ FlashSale';
        }
        $start_at = clone $this->flash_sale->start_at;
        $expired_at = clone $this->flash_sale->expired_at;
        $now = new DateTime();
        if ($start_at < $now) {
            return 'Thời gian bắt đầu không thể nhỏ hơn thời gian hiện tại';
        }
        if ($start_at > $expired_at) {
            return 'Thời gian bắt đầu không thể lớn hơn thời gian kết thúc';
        }

        if ($expired_at->modify("-2 hour") < $start_at) {
            return 'Thời gian diễn ra sự kiện phải ít nhất 2 giờ';
        }
        return false;
    }

    public function checkTimeActiveOrCreateSatisfy(){

        //Lấy thời gian bắt đầu của phiên hiện tại hoặc thời gian của chương trình flash sale
        $start_at = $this->flash_sale->start_at instanceof DateTime ? $this->flash_sale->start_at : clone new DateTime($this->flash_sale->start_at);
        //Lấy thời gian bắt đầu của phiên kết thúc hoặc thời gian của chương trình flash sale
        $expired_at =  $this->flash_sale->expired_at instanceof DateTime ? $this->flash_sale->expired_at  : clone new DateTime
        ($this->flash_sale->expired_at);

        /**
         * Lấy số lượng flashsale trùng với phiên hiện tại
         * Điều kiện:
         *      act = 1
         *      start < start_current && start > end_current
         *      expired < start_current && expired > end_current
         */
        $flashsales =  FlashSale::where('act',1)->where(function($q) use($start_at,$expired_at){
            $q->whereBetween('start_at',[$start_at,$expired_at])->orWhereBetween('expired_at',[$start_at,$expired_at]);
        })->orWhere(function($q)  use($start_at,$expired_at){
            $q->where('start_at','<=',$start_at)->where('expired_at','>=',$expired_at);
        })->count();

        if($flashsales > 0){
            return 'Trong khung giờ này đã có flashsale';
        }

        return false;
    }

    public function checkTimeEdit(){
        $start_at = $this->flash_sale->start_at instanceof DateTime ? $this->flash_sale->start_at : clone new DateTime($this->flash_sale->start_at);
        $expired_at =  $this->flash_sale->expired_at instanceof DateTime ? $this->flash_sale->expired_at  : clone new DateTime($this->flash_sale->expired_at);
        $now = new DateTime();
        if($expired_at < $now){
            return 'Chương trình Flash sale đã kết thúc không thể cập nhật';
        }

        if ($start_at < $now) {
            return 'Chương trình Flash sale đang diễn ra nên không thể cập nhật';
        }

        if ($start_at > $expired_at) {
            return 'Thời gian bắt đầu không thể lớn hơn thời gian kết thúc';
        }

        if ($expired_at->modify("-2 hour") < $start_at) {
            return 'Thời gian diễn ra sự kiện phải ít nhất 2 giờ';
        }

        return false;
    }

    public function checkProductItem()
    {
        if($this->product_real->count() == 0){
            return 'Chưa có sản phẩm nào được bật';
        }
        return false;
    }
}

<?php
namespace Tech5s\Promotion\Controllers\Marketing\Condition;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\VoucherContruct;
class VoucherCondition{
    public function checkTimeCreate()
    {
        $start_at = clone $this->voucher->start_at;
        $expired_at = clone $this->voucher->expired_at;
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

    public function checkDiscountVoucher()
    {
        $message = false;
        // switch ($this->getCodeType()) {
        //     case VoucherHelper::CODE_TYPE_SHOP:
        //         switch ($this->getVoucherType()) {
        //             case VoucherHelper::VOUCHER_TYPE_PROMOTION:
        //                 if ($this->getTypeDiscount() == VoucherHelper::DISCOUNT_MONEY) {
        //                     $message = $this->checkDiscountMoney();
        //                 }
        //                 if ($this->getTypeDiscount() == VoucherHelper::DISCOUNT_PERCENT) {
        //                     $message = $this->checkDiscountPercentPromotion();
        //                 }
        //                 break;
        //             default:
        //                 $message = $this->checkDiscountPercentCoin();
        //                 break;
        //         }

        //         break;
        //     default:
                switch ($this->getVoucherType()) {
                    case VoucherHelper::VOUCHER_TYPE_PROMOTION:
                        if ($this->getTypeDiscount() == VoucherHelper::DISCOUNT_MONEY) {
                            $message = $this->checkDiscountMoney();
                        }

                        if ($this->getTypeDiscount() == VoucherHelper::DISCOUNT_PERCENT) {
                            $message = $this->checkDiscountPercentPromotion();
                        }
                        break;
                    default:
                        $message = $this->checkDiscountPercentCoin();
                        break;
                }
                // break;
        // }
        return $message;
    }

    public function checkCodeType(){
        if($this->getCodeType() == VoucherHelper::CODE_TYPE_PRODUCT && $this->products->count() == 0){
            return 'Vui lòng chọn sản phẩm';
        }
        return false;
    }

    public function createProductVoucher()
    {
        $message = false;
        switch ($this->getCodeType()) {
            case VoucherHelper::CODE_TYPE_PRODUCT:
                $this->voucher->products()->sync([]);
                $this->voucher->products()->sync($this->products->toArray());
                break;
        }
        session()->forget(VoucherContruct::PREFIX_SESSION_PRODUCT);
        return $message;
    }

    //Giảm giá theo tiền của shop
    public function checkDiscountMoney()
    {
        $discount = $this->voucher->discount;
        $minimum_apply_voucher = $this->voucher->minimum_apply_voucher;
        if($discount < 0 || $discount % 500 !== 0){
            return 'Giá giảm không hợp lệ';
        }
        if($discount > $minimum_apply_voucher){
            return 'Giá trị đơn hàng tối thiểu phải lơn hơn giá giảm';
        }

        if ($discount / $minimum_apply_voucher * 100 > VoucherHelper::DEFAULT_PERCENT_MAX) {
            return 'Giá giảm không thể vượt quá '.VoucherHelper::DEFAULT_PERCENT_MAX.'% giá trị đơn hàng tối thiểu';
        }

        if ($discount / $minimum_apply_voucher * 100 < VoucherHelper::DEFAULT_PERCENT_MIN){
            return 'Giá giảm không thể nhỏ hơn '.VoucherHelper::DEFAULT_PERCENT_MIN.'% so với giá trị đơn hàng tối thiểu';
        }
    }

    //Giảm giá theo tiền của shop
    public function checkDiscountMoneyOfProduct()
    {
        $discount = $this->voucher->discount;
        $minimum_apply_voucher = $this->voucher->minimum_apply_voucher;
        $products = $this->getProdcutOfVoucher();
        $product = $products->sortBy('price',SORT_NUMERIC)->first();
        if($discount < 0 || $discount % 500 !== 0){
            return 'Giá giảm không hợp lệ';
        }
        if($discount > $minimum_apply_voucher){
            return 'Giá trị đơn hàng tối thiểu phải lơn hơn giá giảm';
        }

        if ($discount / $minimum_apply_voucher * 100 > VoucherHelper::DEFAULT_PERCENT_MAX) {
            return 'Giá giảm không thể vượt quá '.VoucherHelper::DEFAULT_PERCENT_MAX.'% giá trị đơn hàng tối thiểu';
        }

        if ($discount / $minimum_apply_voucher * 100 < VoucherHelper::DEFAULT_PERCENT_MIN){
            return 'Giá giảm không thể nhỏ hơn '.VoucherHelper::DEFAULT_PERCENT_MIN.'% so với giá trị đơn hàng tối thiểu';
        }
        return false;
    }

    //Giảm giá theo phần trăm loại tiền của shop
    public function checkDiscountPercentPromotion()
    {
        $discount = $this->voucher->discount;
        $max_discount = $this->voucher->max_discount;

        if ($discount > VoucherHelper::DEFAULT_PERCENT_MAX ||$discount < VoucherHelper::DEFAULT_PERCENT_MIN) {
            return 'Phần trăm giảm giá không hợp lệ!';
        }

        if(!is_null($max_discount) && $max_discount % 500 !== 0){
            return 'Mức giảm tối đa không hợp lệ!';
        }

        return false;
    }

    //Giảm giá theo phần trăm kiểu coin của shop
    public function checkDiscountPercentCoin()
    {
        $discount = $this->voucher->discount;
        $max_discount = $this->voucher->max_discount;

        if ($discount > VoucherHelper::DEFAULT_PERCENT_MAX ||$discount < VoucherHelper::DEFAULT_PERCENT_MIN) {
            return 'Phần trăm giảm giá không hợp lệ!';
        }

        if(!is_null($max_discount) && $max_discount % 500 !== 0){
            return 'Mức giảm tối đa không hợp lệ!';
        }

        return false;
    }
}

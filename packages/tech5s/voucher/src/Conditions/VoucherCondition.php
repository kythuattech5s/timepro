<?php

namespace Tech5s\Voucher\Conditions;

use DateTime;
use DB;
use Tech5s\Voucher\Helpers\VoucherHelper;
use Tech5s\Voucher\Services\VoucherService;

class VoucherCondition
{
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

    public function checkTimeUpdate()
    {
        $voucher_start_at = clone new DateTime($this->voucherOld->start_at);
        $voucher_expired_at = clone new DateTime($this->voucherOld->expired_at);
        $start_at = clone $this->voucher->start_at;
        $expired_at = clone $this->voucher->expired_at;
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

    public function checkCodeType()
    {
        if ($this->getCodeType() == VoucherHelper::CODE_TYPE_PRODUCT && $this->items->count() == 0 && $this->categories->count() == 0) {
            return 'Vui lòng chọn ít nhất 1 sản phẩm hoặc 1 danh mục sản phẩm';
        }
        return false;
    }

    public function createProductVoucher()
    {
        $message = false;

        if ($this->getCodeType() == VoucherHelper::CODE_TYPE_PRODUCT) {
            $data = [];
            foreach ($this->items as $item) {
                $data[] = [
                    config('tpvc_setting.pivot_field_table') => $item['id'],
                    'voucher_id' => $this->voucher->id,
                ];
            }
            if ($message) {
                return $message;
            }
            $pivotMethod = config('tpvc_setting.pivot_method');
            $this->voucher->$pivotMethod()->sync([]);
            $this->voucher->$pivotMethod()->sync($data);
        }
        session()->forget(VoucherService::PREFIX_SESSION_PRODUCT);
        return $message;
    }

    public function checkProductInVoucherSafity()
    {
        $message = false;
        if ($this->getCodeType() == VoucherHelper::CODE_TYPE_PRODUCT) {
            foreach ($this->items as $item) {
                $item = DB::table(config('tpvc_setting.table'))->where('id', $item['id'])->first();
                $priceFirst = VoucherHelper::getPriceOfItem($item);
                $priceFirst = $priceFirst['min'];

                if ($this->voucher->type_discount == VoucherHelper::DISCOUNT_MONEY && $priceFirst * 90 / 100 <= $this->voucher->discount) {
                    $message = 'Sản phẩm ' . $item->name . ' không thể áp dụng cho voucher này';
                    break;
                }

                if ($this->voucher->type_discount == VoucherHelper::DISCOUNT_MONEY && $priceFirst < $this->voucher->minimum_apply_voucher) {
                    $message = 'Sản phẩm ' . $item->name . ' không thể áp dụng cho voucher này';
                    break;
                }
            }
            if ($message) {
                return $message;
            }
        }
        return $message;
    }

    public function createProductCategoryVoucher()
    {
        $message = false;
        switch ($this->getCodeType()) {
            case VoucherHelper::CODE_TYPE_PRODUCT:
                $data = [];
                foreach ($this->categories as $item) {
                    if ($item != "") {
                        $data[] = [
                            config('tpvc_setting.pivot_field_category_table') => $item['id'],
                            'voucher_id' => $this->voucher->id,
                        ];
                    }
                }
                $pivotMethodCategory = config('tpvc_setting.pivot_method_categories');
                $this->voucher->$pivotMethodCategory()->sync([]);
                $this->voucher->$pivotMethodCategory()->sync($data);
                break;
        }
        session()->forget(VoucherService::PREFIX_SESSION_PRODUCT);
        return $message;
    }
    //Giảm giá theo tiền của shop
    public function checkDiscountMoney()
    {
        $discount = $this->voucher->discount;
        // $minimum_apply_voucher = $this->voucher->minimum_apply_voucher;
        if ($discount < 0 || $discount % 500 !== 0) {
            return 'Giá giảm không hợp lệ';
        }
        // if ($discount > $minimum_apply_voucher) {
        //     return 'Giá trị đơn hàng tối thiểu phải lớn hơn giá giảm';
        // }

        // if ($discount / $minimum_apply_voucher * 100 > VoucherHelper::DEFAULT_PERCENT_MAX) {
        //     return 'Giá giảm không thể vượt quá ' . VoucherHelper::DEFAULT_PERCENT_MAX . '% giá trị đơn hàng tối thiểu';
        // }

        // if ($discount / $minimum_apply_voucher * 100 < VoucherHelper::DEFAULT_PERCENT_MIN) {
        //     return 'Giá giảm không thể nhỏ hơn ' . VoucherHelper::DEFAULT_PERCENT_MIN . '% so với giá trị đơn hàng tối thiểu';
        // }
    }

    //Giảm giá theo tiền của shop
    public function checkDiscountMoneyOfProduct()
    {
        $discount = $this->voucher->discount;
        $minimum_apply_voucher = $this->voucher->minimum_apply_voucher;
        if ($discount < 0 || $discount % 500 !== 0) {
            return 'Giá giảm không hợp lệ';
        }
        if ($discount > $minimum_apply_voucher) {
            return 'Giá trị đơn hàng tối thiểu phải lơn hơn giá giảm';
        }

        if ($discount / $minimum_apply_voucher * 100 > VoucherHelper::DEFAULT_PERCENT_MAX) {
            return 'Giá giảm không thể vượt quá ' . VoucherHelper::DEFAULT_PERCENT_MAX . '% giá trị đơn hàng tối thiểu';
        }

        if ($discount / $minimum_apply_voucher * 100 < VoucherHelper::DEFAULT_PERCENT_MIN) {
            return 'Giá giảm không thể nhỏ hơn ' . VoucherHelper::DEFAULT_PERCENT_MIN . '% so với giá trị đơn hàng tối thiểu';
        }
        return false;
    }

    //Giảm giá theo phần trăm loại tiền của shop
    public function checkDiscountPercentPromotion()
    {
        $discount = $this->voucher->discount;
        $max_discount = $this->voucher->max_discount;

        if ($discount > VoucherHelper::DEFAULT_PERCENT_MAX || $discount < VoucherHelper::DEFAULT_PERCENT_MIN) {
            return 'Phần trăm giảm giá không hợp lệ!';
        }

        if (!is_null($max_discount) && $max_discount % 500 !== 0) {
            return 'Mức giảm tối đa không hợp lệ!';
        }

        return false;
    }

    //Giảm giá theo phần trăm kiểu coin của shop
    public function checkDiscountPercentCoin()
    {
        $discount = $this->voucher->discount;
        $max_discount = $this->voucher->max_discount;

        if ($discount > VoucherHelper::DEFAULT_PERCENT_MAX || $discount < VoucherHelper::DEFAULT_PERCENT_MIN) {
            return 'Phần trăm giảm giá không hợp lệ!';
        }

        if (!is_null($max_discount) && $max_discount % 500 !== 0) {
            return 'Mức giảm tối đa không hợp lệ!';
        }

        return false;
    }

    public function getProdcutOfVoucher()
    {
        return DB::table(config('tpvc_setting.table'))->whereIn('in', $this->items->toArray())->get();
    }

    public function getVoucherType()
    {
        return $this->voucher->voucher_type;
    }

    public function getTypeDiscount()
    {
        return $this->voucher->type_discount;
    }

    public function getCodeType()
    {
        return $this->voucher->code_type;
    }
}

<?php

namespace Tech5s\Voucher\Helpers;

class VoucherHelper
{
    const HAS_COIN = false;
    const HAS_FOR_PRODUCT = true;
    const PREFIX_CODE = '';
    const CONDITION_RECEIVE = false;
    const CONDITION_APPLY = false;
    // Loại mã (ví dụ all sp, sp cụ thể)
    const CODE_TYPE_SHOP = 1;
    const CODE_TYPE_PRODUCT = 2;

    // Loại voucher (ví dụ giảm giá, hoàn xu)
    const VOUCHER_TYPE_PROMOTION = 1;
    const VOUCHER_TYPE_COIN = 2;

    // Loại giảm giá (ví dụ số tiền or %)
    const DISCOUNT_MONEY = 1;
    const DISCOUNT_PERCENT = 2;

    const TYPE_PUBLIC = 1;
    const TYPE_PRIVATE = 0;

    const VOUCHER_LIMIT = 1;
    const VOUCHER_NO_LIMIT = 2;

    const DEFAULT_PERCENT_MAX = 90;
    const DEFAULT_PERCENT_MIN = 5;

    const TYPE_USED_NULL = 0;
    const TYPE_USED_AFTER_BUY_ORDER = 1;

    public static function getMethodTypeCode(int $type)
    {
        switch ($type) {
            case self::CODE_TYPE_SHOP:
                return 'voucher_shop';
                break;
            case self::CODE_TYPE_PRODUCT:
                return 'voucher_product';
                break;
        }
    }

    public static function getPriceOfItem($item)
    {
        $ret = [];
        $ret['min'] = 0;
        $ret['max'] = 0;
        $ret['sale_percent'] = 0;
        $listData = \DB::table('course_time_packages')->where('course_id', $item->id)->get();
        foreach ($listData as $data) {
            if ($ret['min'] >= 0 && ($data->price < $ret['min'] || $ret['min'] == 0)) {
                $ret['min'] = $data->price;
            }
            if ($ret['max'] != 0 && $data->price_old > $ret['max']) {
                $ret['max'] = $data->price_old;
            }
        }
        return $ret;
    }
}

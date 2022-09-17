<?php

namespace Tech5s\Promotion\Helpers;

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
}

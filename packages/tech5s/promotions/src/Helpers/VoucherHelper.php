<?php

namespace Tech5s\Promotion\Helpers;

use Tech5s\Promotion\Models\Voucher;

class VoucherHelper
{
    const HAS_COIN = false;
    const HAS_FOR_PRODUCT = false;
    const PREFIX_CODE = '';
    // Loại mã
    const CODE_TYPE_SHOP = 1;
    const CODE_TYPE_PRODUCT = 2;

    // Loại voucher
    const VOUCHER_TYPE_PROMOTION = 1;
    const VOUCHER_TYPE_COIN = 2;

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

    public static function getVouchers()
    {
        $vouchers = Voucher::where('start_at', '<=', now())->where('expired_at', '>=', now())->limit(3)->get();
        return $vouchers;
    }
}

<?php

namespace Tech5s\Promotion\Helpers;

class PromotionProductHelper
{
    const TYPE_PERCENT = 1;
    const TYPE_MONEY = 2;

    public static function getNameType(int $type)
    {
        switch ($type) {
            case static::TYPE_PERCENT:
                return 'Giám giá theo phần trăm';
                break;

            case static::TYPE_MONEY:
                return 'Giám giá theo tiền';
                break;
        }
    }
}

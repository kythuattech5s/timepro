<?php

namespace Tech5s\FlashSale\Helpers;

class FlashSaleHelper
{
    const CHOOSE_SLOT = true;
    const COMPARE_SAME = 1;
    const COMPARE_BIGGER = 2;
    const COMPARE_SMALLER = 3;
    const SESSION_PRODUCT_CURRENT = 'SESSION_PRODUCT_FLASHSALE_SHOP';
    const SESSION_PRODUCT_REAL = 'SESSION_PRODUCT_FLASHSALE_REAL';
    const SESSION_PRODUCT_REMOVE = 'SESSION_PRODUCT_FLASHSALE_DELETE';

    public static function checkPriceCondition($flash_sale, $item)
    {
        if ($flash_sale->promotion_type_comparison_id == FlashSaleHelper::COMPARE_BIGGER && $item['price'] < $flash_sale->discount) {
            return 'Giá trị sau giảm giá phải lớn hơn ' . $flash_sale->discount;
        } elseif ($flash_sale->promotion_type_comparison_id == FlashSaleHelper::COMPARE_SMALLER && $item['price'] > $flash_sale->discount) {
            return 'Giá trị sau giảm giá phải nhỏ hơn ' . $flash_sale->discount;
        } elseif ($flash_sale->promotion_type_comparison_id == FlashSaleHelper::COMPARE_SAME && $item['price'] != $flash_sale->discount) {
            return 'Giá trị sau giảm giá bằng ' . $flash_sale->discount;
        }
        return false;
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

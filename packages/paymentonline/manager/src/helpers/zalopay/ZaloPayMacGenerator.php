<?php
namespace paymentonline\manager\helpers\zalopay;
use SettingHelper;
class ZaloPayMacGenerator
{
    public static function compute(string $params, string $key = null)
    {
        if (is_null($key))
        {
            $key = SettingHelper::getSetting('zalopay_key1');
        }
        return hash_hmac("sha256", $params, $key);
    }

    private static function createOrderMacData(Array $order)
    {
        return $order["appid"] . "|" . $order["apptransid"] . "|" . $order["appuser"] . "|" . $order["amount"] . "|" . $order["apptime"] . "|" . $order["embeddata"] . "|" . $order["item"];
    }

    public static function createOrder(Array $order)
    {
        return self::compute(self::createOrderMacData($order));
    }

    public static function quickPay(Array $order, String $paymentcodeRaw)
    {
        return self::compute(self::createOrderMacData($order) . "|" . $paymentcodeRaw);
    }

    public static function refund(Array $params)
    {
        return self::compute($params['appid'] . "|" . $params['zptransid'] . "|" . $params['amount'] . "|" . $params['description'] . "|" . $params['timestamp']);
    }

    public static function getOrderStatus(Array $params)
    {
        return self::compute($params['appid'] . "|" . $params['apptransid'] . "|" . Config::get() ['key1']);
    }

    public static function getRefundStatus(Array $params)
    {
        return self::compute($params['appid'] . "|" . $params['mrefundid'] . "|" . $params['timestamp']);
    }

    public static function getBankList(Array $params)
    {
        return self::compute($params['appid'] . "|" . $params['reqtime']);
    }

    public static function redirect(Array $params, string $key2)
    {
        return self::compute($params['appid'] . "|" . $params['apptransid'] . "|" . $params['pmcid'] . "|" . $params['bankcode'] . "|" . $params['amount'] . "|" . $params['discountamount'] . "|" . $params["status"], $key2);
    }
}
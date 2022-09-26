<?php
namespace paymentonline\manager\helpers\zalopay;
use paymentonline\manager\helpers\zalopay\ZaloPayMacGenerator;
use paymentonline\manager\helpers\PaymentHelper;
use SettingHelper;
class ZalopayHelper{
	const API_SANBOX_CREATEORDER = "https://sandbox.zalopay.com.vn/v001/tpe/createorder";
	const API_SANBOX_GATEWAY = "https://sbgateway.zalopay.vn/pay?order=";
	const API_SANBOX_QUICKPAY = "https://sandbox.zalopay.com.vn/v001/tpe/submitqrcodepay";
    const API_SANBOX_REFUND = "https://sandbox.zalopay.com.vn/v001/tpe/partialrefund";
    const API_SANBOX_REFUNDSTATUS = "https://sandbox.zalopay.com.vn/v001/tpe/getpartialrefundstatus";
    const API_SANBOX_GETSTATUSBYAPPTRANSID = "https://sandbox.zalopay.com.vn/v001/tpe/getstatusbyapptransid";
    const API_SANBOX_GETLISTMERCHATBANK = "https://sbgateway.zalopay.vn/api/getlistmerchantbanks";
    private static $PUBLIC_KEY;
    private static $UID;

    public static function init()
    {
        self::$PUBLIC_KEY = file_get_contents('publickey.pem');
        self::$UID = self::getTimestamp();
    }

    public static function getTimestamp() {
        return round(microtime(true) * 1000);
    }

    public static function verifyCallback(Array $params)
    {
        $data = $params["data"];
        $requestMac = $params["mac"];

        $result = [];
        $mac = ZaloPayMacGenerator::compute($data, SettingHelper::getSetting('zalopay_key2'));

        if ($mac != $requestMac)
        {
            $result['returncode'] = - 1;
            $result['returnmessage'] = 'mac not equal';
        }
        else
        {
            $result['returncode'] = 1;
            $result['returnmessage'] = 'success';
        }

        return $result;
    }

    public static function verifyRedirect(Array $data)
    {
        $reqChecksum = $data["checksum"];
        $checksum = ZaloPayMacGenerator::redirect($data);

        return $reqChecksum === $checksum;
    }

    public static function genTransID()
    {
        return date("ymd") . "_" . SettingHelper::getSetting('zalopay_appid') . "_" . (++self::$UID);
    }

    public static function newCreateOrderData(Array $params)
    {
        $embeddata = [];

        if (array_key_exists("embeddata", $params))
        {
            $embeddata = $params["embeddata"];
        }

        $order = ["appid" => SettingHelper::getSetting('zalopay_appid'), "apptime" => self::getTimestamp() , "apptransid" => self::GenTransID() , "appuser" => array_key_exists("appuser", $params) ? $params["appuser"] : "demo", "item" => json_encode(array_key_exists("item", $params) ? $params["item"] : [],JSON_UNESCAPED_UNICODE) , "embeddata" => json_encode($embeddata,JSON_UNESCAPED_UNICODE) , "bankcode" => array_key_exists("bankcode", $params) ? $params["bankcode"] : "zalopayapp", "description" => array_key_exists("description", $params) ? $params['description'] : "", "amount" => $params['amount'], ];

        return $order;
    }

    
    public static function createOrder(Array $order)
    {
        $order['mac'] = ZaloPayMacGenerator::createOrder($order);
        $header = "Content-type: application/x-www-form-urlencoded\r\n";
        $result = PaymentHelper::curl(self::API_SANBOX_CREATEORDER,$header,'POST',http_build_query($order));
        return $result;
    }

    
    public static function newQuickPayOrderData(Array $params)
    {
        $order = self::newCreateOrderData($params);
        $order['userip'] = array_key_exists('userip', $params) ? $params['userip'] : "127.0.0.1";
        openssl_public_encrypt($params['paymentcodeRaw'], $encrypted, self::$PUBLIC_KEY);
        $order['paymentcode'] = base64_encode($encrypted);
        $order['mac'] = ZaloPayMacGenerator::quickPay($order, $params['paymentcodeRaw']);
        return $order;
    }

    
    public static function quickPay(Array $order)
    {
        $header = "Content-type: application/x-www-form-urlencoded\r\n";
        $result = PaymentHelper::curl(self::API_SANBOX_QUICKPAY,$header,'POST',http_build_query($order));
        return $result;
    }

  
    public static function getOrderStatus(string $apptransid)
    {
        $params = ["appid" => SettingHelper::getSetting('zalopay_appid'), "apptransid" => $apptransid];
        $params["mac"] = ZaloPayMacGenerator::getOrderStatus($params);
        $header = "Content-type: application/x-www-form-urlencoded\r\n";
        $result = PaymentHelper::curl(self::API_SANBOX_GETORDERSTATUS,$header,'POST',http_build_query($params));
        return $result;
    }

    
    public static function newRefundData(Array $params)
    {
        $refundData = ["appid" => SettingHelper::getSetting('zalopay_appid'), "timestamp" => getTimestamp() , "mrefundid" => self::genTransID() , "zptransid" => $params['zptransid'], "amount" => $params['amount'], "description" => $params['description']];

        $refundData['mac'] = ZaloPayMacGenerator::refund($refundData);
        return $refundData;
    }

    
    public static function refund(Array $refundData)
    {
        $header = "Content-type: application/x-www-form-urlencoded\r\n";
        $result = PaymentHelper::curl(self::API_SANBOX_REFUND,$header,'POST',http_build_query($refundData)); 
        $result['mrefundid'] = $refundData['mrefundid'];
        return $result;
    }

    public static function getRefundStatus(String $mrefundid)
    {
        $params = ["appid" => SettingHelper::getSetting('zalopay_appid'), "mrefundid" => $mrefundid, "timestamp" => self::getTimestamp() ];

        $params['mac'] = ZaloPayMacGenerator::getRefundStatus($params);
        $header = "Content-type: application/x-www-form-urlencoded\r\n";
        $result = PaymentHelper::curl(self::API_SANBOX_GETREFUNDSTATUS,$header,'POST',http_build_query($params)); 
        return $result;
    }

    public static function getBankList()
    {
        $params = ["appid" => SettingHelper::getSetting('zalopay_appid'), "reqtime" => self::getTimestamp() ];

        $params['mac'] = ZaloPayMacGenerator::getBankList($params);
        $header = "Content-type: application/x-www-form-urlencoded\r\n";
        $result = PaymentHelper::curl(self::API_SANBOX_GETLISTMERCHATBANK,$header,'POST',http_build_query($params)); 
        return $result;
    }
}

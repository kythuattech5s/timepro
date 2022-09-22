<?php
namespace App\Helpers;
use App\Helpers\Media;
use App\Models\Menu;
use Carbon\Carbon;
use Currency;
use SettingHelper;
class SmsHelper{
    const API_SEND_SMS = 'http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get';
    const SMS_TYPE_BRAND_NAME = 2;
    const SMS_TYPE_PHONE_NUMBER = 8;
    const SMS_TYPE_ZALO_PRIORITY = 24;
    const SMS_TYPE_ZALO_NORMAL = 25;

    public static function send($phone,$content){
        $headers = ['Content-Type: application/x-www-form-urlencoded'];
        $body = [
			'ApiKey' => SettingHelper::getSetting('esms_api_key'),
			'SecretKey' => SettingHelper::getSetting('esms_secret_key'),
			'Phone' => $phone,
            'Content' => $content,
            'SmsType' => self::SMS_TYPE_BRAND_NAME,
            'Brandname' => 'Baotrixemay'
		];
        return \Support::exeCurl(self::API_SEND_SMS,'GET',$body,$headers);
    }
}
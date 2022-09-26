<?php
namespace paymentonline\manager\helpers;
class VnpayHelper{
	public static $constants = [
		'PAYMENT_QRCODE' => 1,
		'PAYMENT_ATM' => 2,
		'API_PAYMENT_SANBOX' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
		'API_PAYMENT_LIVE' => 'https://pay.vnpay.vn/vpcpay.html'
	];
	

	public static function getValueConstant($constant){
		return self::$constants[$constant];
	}
}
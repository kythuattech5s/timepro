<?php

namespace paymentonline\manager\methods;

use paymentonline\manager\methods\AbstractPayment;

use paymentonline\manager\models\Transaction;

use paymentonline\manager\helpers\PaymentHelper;

use paymentonline\manager\helpers\MomoHelper;

use SettingHelper;

use Support;

class Momo extends AbstractPayment{

	protected $momoPartnerCode;

	protected $momoAccessKey;

	protected $momoSecretKey;

	protected $env;

	protected $urlReturnIpn;

	protected $transaction;



	public function __construct(Transaction $transaction){

		parent::__construct($transaction);

		$this->momoPartnerCode = SettingHelper::getSetting('momo_partner_code', 'VV7US7JD');

        $this->momoAccessKey = SettingHelper::getSetting('momo_access_key','HZIZTNITITIPNJNHBUEAEGLMKMZRKISJ');

        $this->momoSecretKey = SettingHelper::getSetting('momo_secret_key','HZIZTNITITIPNJNHBUEAEGLMKMZRKISJ');

        $this->transaction = $transaction;

        $this->amount = Support::show($this->transaction,'amount',0);

        $this->urlReturnIpn = url('/callback-payment-online/'.Support::show($this->transaction,'id',0));

        $this->urlReturn = url('/');

	}



    public function getUrlReturn(){

        return $this->urlReturn;

    }



    public function setUrlReturnIpn($url){

    	$this->urlReturnIpn = $url;

    }

    

    public function getUrlReturnIpn(){

        return $this->urlReturnIpn;

    }



	public function doTransfer(){

		if($this->amount < 1000){

			return response()->json(['code'=>100,'message'=>'Số dư cần lớn 1000 đ']);

		}

		$orderCode = Support::show($this->transaction,'order_code');

		$orderInfo = 'Thanh toán đơn hàng với với mã đơn hàng: '.$orderCode;

		$amount = (string)$this->amount;

		$notifyurl = $this->getUrlReturnIpn();

		$returnUrl = $this->getUrlReturn();

		$extraData = 'email=nqanh.tech5s@gmail.com';

	 

		$requestId = $orderCode;

		$requestType = "captureMoMoWallet";



        // Tạo chữ ký

		$rawHash = "partnerCode=" . $this->momoPartnerCode;

        $rawHash .= "&accessKey=" . $this->momoAccessKey;

        $rawHash .= "&requestId=" . $requestId;

        $rawHash .= "&amount=" . $amount;

        $rawHash .= "&orderId=" . $orderCode;

        $rawHash .= "&orderInfo=" . $orderInfo;

        $rawHash .= "&returnUrl=" . $returnUrl;

        $rawHash .= "&notifyUrl=" . $notifyurl;

        $rawHash .= "&extraData=" . $extraData;

		$signature = hash_hmac("sha256", $rawHash, $this->momoSecretKey);

		$data = array(

			'accessKey' => $this->momoPartnerCode,

			'partnerCode' => $this->momoAccessKey,

			'requestType' => $requestType,

			'notifyUrl' => $notifyurl,

			'returnUrl' => $returnUrl,

			'orderId' => $orderCode,

			'amount' => $amount,

			'orderInfo' => $orderInfo,

			'requestId' => $requestId,

			'extraData' => $extraData,

			'signature' => $signature

		);

		$header = [

			'Content-Type: application/json',

			'Content-Length: ' . strlen(json_encode($data))

		];

		$result = PaymentHelper::curl(MomoHelper::API_PAYMENT_SANBOX.'gw_payment/transactionProcessor',$header,'POST',$data);

		$jsonResult = Support::jsonDecode($result['response'] ?? '');

		if(count($jsonResult) > 0 && $jsonResult['errorCode'] === 0){



			$jsonResult = json_decode($result, true);

			return response()->json(['code'=>200,'message'=>'Lấy thông tin thành công','redirect_url'=>$jsonResult['payUrl']]);

		}

		else{

			return response()->json(['code'=>100,'message'=>$jsonResult['message'] ?? 'Yêu cầu không thành công']);

		}

	}

}
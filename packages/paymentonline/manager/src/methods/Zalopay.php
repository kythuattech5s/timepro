<?php
namespace paymentonline\manager\methods;
use paymentonline\manager\methods\AbstractPayment;
use paymentonline\manager\models\Transaction;
use paymentonline\manager\helpers\zalopay\ZaloPayMacGenerator;
use paymentonline\manager\helpers\zalopay\ZalopayHelper;
use SettingHelper;
use Support;
class Zalopay extends AbstractPayment{
	protected $appId;
	protected $key1;
	protected $key2;
	protected $amount;

	public function __construct(Transaction $transaction){
		$this->appId = SettingHelper::getSetting('zalopay_appid');
		$this->key1 = SettingHelper::getSetting('zalopay_key1');
		$this->key2 = SettingHelper::getSetting('zalopay_key2');
		$this->amount = \Support::show($transaction,'amount');
	}

	public function doTransfer(){
		$embeddata = [];
		$params = [];
		if (array_key_exists("embeddata", $params)) {
		    $embeddata = $params["embeddata"];
		}
	    $dataOrder = [
	      	"appid" => SettingHelper::getSetting('zalopay_appid'),
	      	"apptime" => ZaloPayHelper::getTimeStamp(),
	      	"apptransid" => ZaloPayHelper::GenTransID(),
	      	"appuser" => array_key_exists("appuser", $params) ? $params["appuser"] : "demo",
	      	"item" => json_encode(array_key_exists("item", $params) ? $params["item"] : []),
	      	"embeddata" => json_encode($embeddata),      
	      	"description" => array_key_exists("description", $params) ? $params['description'] : "",
	      	"amount" => $this->amount,
	    ];
	    $order = ZaloPayHelper::createOrder($dataOrder);
	    $response = $order['response'] ?? [];
	    $response = Support::jsonDecode($response);
	    if(isset($response['returncode']) && $response['returncode'] != 1){
	    	return response()->json(['code'=>100,'message'=>$response['returnmessage'] ?? 'Yêu cầu không hợp lệ']);
	    }
	    return response()->json(['code'=>200,'message'=>'Lấy thông tin thành công','redirect_url'=>$response['orderurl']]);
	}
}
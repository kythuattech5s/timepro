<?php
namespace paymentonline\manager\methods;
use paymentonline\manager\methods\AbstractPayment;
use paymentonline\manager\models\Transaction;
use paymentonline\manager\helpers\VnpayHelper;
use vanhenry\helpers\helpers\SettingHelper;
use Support;
class Vnpay extends AbstractPayment{
	protected $method;
	protected $env = 'SANBOX';
    protected $vnp_TmnCode; //Mã website tại VNPAY 
    protected $vnp_HashSecret; //Chuỗi bí mật
    protected $vnp_Url;
    protected $vnp_Returnurl;
    protected $transaction;
	public function __construct(Transaction $transaction){
		parent::__construct($transaction);
        $this->transaction = $transaction;
		$this->method = VnpayHelper::getValueConstant('PAYMENT_ATM');
		$this->vnp_TmnCode = SettingHelper::getSetting('vnp_tmncode', 'VV7US7JD');
        $this->vnp_HashSecret = SettingHelper::getSetting('vnp_hashsecret','HZIZTNITITIPNJNHBUEAEGLMKMZRKISJ');
        $this->env = SettingHelper::getSetting('vnp_env', 'SANBOX');
        $this->vnp_Url = VnpayHelper::getValueConstant('API_PAYMENT_'.$this->env);
        $this->vnp_Returnurl = url('callback-payment-online/'.Support::show($this->transaction,'id'));
        
	}
	public function setMethod($method){
		$this->method = $method;
	}	
	public function doTransfer(){
		$lang = \App::getLocale();
        $lang = $lang == 'vi' ? 'vn' : $lang;
        $tableOrder = Support::show($this->transaction,'table_map');
        $mapId = Support::show($this->transaction,'map_id');
        $orders = \DB::table($tableOrder)->where('id',$mapId)->first();
        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $this->amount * 1000,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => $lang,
            "vnp_OrderInfo" => 'Thanh toán đơn hàng travel gold',
            "vnp_OrderType" => 'billpayment',
            "vnp_ReturnUrl" => $this->vnp_Returnurl,
            "vnp_TxnRef" => Support::show($this->transaction,'order_code','TRAVELGOLD_'.Support::show($this->transaction,'id')),
        );
        if($this->method == VnpayHelper::getValueConstant('PAYMENT_QRCODE')){
        	$inputData['vnp_BankCode'] = 'VNPAYQA';
        }
        $query = $this->buildQuery($inputData);
        $vnpSecureHash = $this->hashData($inputData);
        return response()->json(['code'=>200,'message'=>'Lấy thông tin thành công','redirect_url'=>$this->vnp_Url . "?" . $query . 'vnp_SecureHashType=SHA256&vnp_SecureHash='.$vnpSecureHash]);
	}
	public function hashData($inputData)
    {
        ksort($inputData);
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
        }
        return hash('sha256', $this->vnp_HashSecret . $hashdata);
    }
    private function buildQuery($inputData){
        ksort($inputData);
        $query = "";
        foreach ($inputData as $key => $value) {
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        return $query;
    }
    public function ipn($request){
        if (!file_exists('vnpaylogs')) {
            mkdir('vnpaylogs', 0755, true);
        }
        file_put_contents('vnpaylogs/pay.txt', json_encode($request), true);
        $inputData = $this->getInputData($request);
        $secureHash = $this->hashData($inputData);
        $vnp_SecureHash = $request['vnp_SecureHash'];
        $vnpTranId = $inputData['vnp_TransactionNo'];
        $vnp_BankCode = $inputData['vnp_BankCode'];
        $Status = 0;
        try {
            if ($secureHash == $vnp_SecureHash) {
                if (isset($this->transaction)) {
                    if ((int)Support::show($this->transaction,'amount') === ($inputData['vnp_Amount'] / 100)) {
                        if ((int)Support::show($this->transaction,'status') === 0) {
                            if ($inputData['vnp_ResponseCode'] == '00') {
                                $this->transaction->status = 1;
                            } else {
                                $this->transaction->status = 2;
                            }
                            $this->transaction->save();
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        }
                        else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    }
                    else{
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'Invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        }
        catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        echo json_encode($returnData);
    }
    public function getInputData($request)
    {
        $inputData = [];
        foreach ($request as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        return $inputData;
    }
}
<?php
namespace paymentonline\manager\processors;
use paymentonline\manager\models\Transaction;
use paymentonline\manager\models\PaymentMethod;
use Support;
class Processor{
	protected $transactionId;
	protected $transaction;
	protected $amount;
	public function __construct($transactionId){
		$this->transactionId = $transactionId;
		$this->transaction = Transaction::find($transactionId);
		$this->amount = Support::show($this->transaction,'amount');
	}
	public function setAmount($amount){
		$this->amount = $amount;
	}
	public function getAmount(){
		return $amount;
	}
	public function paymentonline(){
		if(!isset($this->transaction)){
			return response()->json(['code'=>100,'message'=>'Yêu cầu thanh toán không hợp lệ. Không tìm thấy đơn thanh toán']);
		}
		if($this->amount == 0){
			return response()->json(['code'=>100,'message'=>'Số dư phải lớn hơn không']);
		}
		$medthodId = Support::show($this->transaction,'payment_method_id');
		
		if($medthodId == ''){
			return response()->json(['code'=>100,'message'=>'Không tìm thấy phương thức thanh toán']);
		}
		$paymentMethod = PaymentMethod::find($medthodId);
		$medthod = Support::show($paymentMethod,'method');
		if($medthod == ''){
			return response()->json(['code'=>100,'message'=>'Phương thức thanh toán không hợp lệ']);
		}
		$infoTranfer = (new $medthod($this->transaction))->doTransfer();
		return $infoTranfer;
	}
}
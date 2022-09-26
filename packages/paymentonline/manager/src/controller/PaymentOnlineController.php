<?php 
namespace paymentonline\manager\controller;
use App\Http\Controllers\Controller;
use App\Events\CallbackPaymentOnline;
use paymentonline\manager\processors\Processor;
use paymentonline\manager\models\Transaction;
use paymentonline\manager\methods\Vnpay;
use Support;
class PaymentOnlineController extends Controller{
	public function paymentOnline(){
		$payment = new Processor(3);
		return $payment->paymentonline();
	}
	public function ipnVnpay(){
		$request = request();
		$data = $request->all();
		$vnp_TxnRef =  $request->input('vnp_TxnRef','');
		$transaction = Transaction::where('code',$vnp_TxnRef)->first();
		if(isset($transaction)) return response()->json(['RspCode'=>'01','Message'=>'Order not found']);
       	$vnpay = new Vnpay($transaction);
		return $vnpay->ipn($data);
	}
	public function callbackPaymentOnline(){
		$request = request();
		$transactionId = $request->segment(2);
		$transaction = Transaction::find($transactionId);
		$transaction->load('paymentMethod');
		$paymentMethod = $transaction->paymentMethod;
		$data = $request->all();
		switch (Support::show($paymentMethod,'method')) {
			case 'paymentonline\manager\methods\Momo':
				
				$this->callBackPaymentMomo($data,$transaction);
				break;
			case 'paymentonline\manager\methods\Vnpay':
				$this->callBackPaymentVnpay($data,$transaction);
				break;
			case 'paymentonline\manager\methods\Zalopay':
				$this->callBackPaymentZalopay($data,$transaction);
				break;
			default:
				break;
		}
	}
	private function callBackPaymentMomo(array $data,Transaction $transaction){

	}
	private function callBackPaymentVnpay(array $data,Transaction $transaction){
		if(isset($data['vnp_ResponseCode']) && $data['vnp_ResponseCode']=="00"){
			
		}
	}
	private function callBackPaymentZalopay(array $data,Transaction $transaction){
		$result = [];
		try {
		  	$key2 = "eG4r0GcoNtRGbO8";
		  	$postdata = file_get_contents('php://input');
		  	$postdatajson = json_decode($postdata, true);
		  	$mac = hash_hmac("sha256", $postdatajson["data"], $key2);
		  	$requestmac = $postdatajson["mac"];
		  	// kiểm tra callback hợp lệ (đến từ ZaloPay server)
		  	if (strcmp($mac, $requestmac) != 0) {
		    // callback không hợp lệ
		    	$result["returncode"] = -1;
		    	$result["returnmessage"] = "mac not equal";
		  	} 
		  	else {
		    	// thanh toán thành công
		    	// merchant cập nhật trạng thái cho đơn hàng
		    	$datajson = json_decode($postdatajson["data"], true);
		    	// echo "update order's status = success where apptransid = ". $dataJson["apptransid"];
		    	$result["returncode"] = 1;
		    	$result["returnmessage"] = "success";
		  	}
		}
		catch (Exception $e) {
		  	$result["returncode"] = 0;
		  	$result["returnmessage"] = $e->getMessage();
		}
		echo json_encode($result);
	}
}

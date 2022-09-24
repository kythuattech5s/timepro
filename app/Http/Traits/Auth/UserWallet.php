<?php
namespace App\Http\Traits\Auth;
use App\Helpers\UserWallet\WalletExport;
use App\Helpers\UserWallet\WalletHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\{PaymentMethod,UserWalletTransactionType,Order,OrderStatus,OrderType};
use SettingHelper;
use Support;
use Excel;
use Auth;
trait UserWallet{

	public function exportWallet()
    {
        return Excel::download(new WalletExport, 'history_wallet_'.date('d-m-Y',strtotime(now())).'.xlsx');
    }

	public function wallet(){
		if(!Auth::check()){
			$this->goLogin();
		}
		$user = Auth::user();
		if(\Support::show($user,'user_type_id') != 1){
			return \Redirect::to(url('/'))->with('typeNotify','error')->with('messageNotify','Tài khoản của bạn không có quyền truy cập');
		}
		$wallet = $user->wallet()->first();
		$walletTransactions = $wallet != null?$wallet->walletTransactions()->orderBy('created_at','desc')->get():[];
		return view('auth.account.wallet',compact('wallet','walletTransactions'));
	}
	
	public function deposit($request){
		if(!Auth::check()){
			$this->goLogin();
		}
		$user = Auth::user();
		if(\Support::show($user,'user_type_id') != 1){
			if($request->ajax()){
				return response()->json(['code'=>100,'message'=>'Tài khoản của bạn không có quyền truy cập tính năng này']);
			}
			else{
				return \Redirect::to(url('/'))->with('typeNotify','error')->with('messageNotify','Tài khoản của bạn không có quyền truy cập tính năng này');
			}
		}
		if($request->isMethod('POST')){
			return $this->__deposit($request);
		}
		$listPaymentMethod = PaymentMethod::act()->orderBy('ord','asc')->get();
		return view('auth.account.deposit_wallet',compact('listPaymentMethod','user'));
	}
	
	public function __deposit($request){
		$validator = $this->validatorDeposit($request->all());
        if ($validator->fails()) {
            return response()->json(['code'=>100,'message'=>$validator->errors()->first()]);
        }
		$amount = (int) $request->input('amount');
		if($amount == 0){
			return response()->json(['code'=>100,'message'=>'Số tiền cần nạp cần lớn hơn 0']);
		}
		$userOrerData = $request->all();
		$user = Auth::user();
		$order = $this->createOrderDeposit($amount,$userOrerData,$user);
		$wallet = $user->wallet()->first();
		WalletHelper::insertTransaction($wallet,UserWalletTransactionType::DEPOSIT_MONEY_INTO_WALLET,$amount,'Nạp tiền vào ví',WalletHelper::TRANSACTION_CALCULATION_PLUS,WalletHelper::TRANSACTION_STATUS_TRADING,Support::show($order,'id'));
		if ($userOrerData['payment_method'] == PaymentMethod::PAY_VN_PAY) {
			$transactionId = \paymentonline\manager\models\Transaction::insertTransaction($order,\VRoute::get("paymentSucess"));
			$paymentonlineProcesser = new \paymentonline\manager\processors\Processor($transactionId);
			return $paymentonlineProcesser->paymentonline();
		}
		return response()->json(['code'=>200,'message'=>'Gửi Yêu Cầu Nạp Tiền Thành Công']);
	}

	private function createOrderDeposit($totalMoney,$userOrerData,$user){
		$order = new Order;
        $order->user_id = Support::show($user,'id');
        $order->name = $userOrerData['name'] ?? '';
        $order->phone = $userOrerData['phone'] ?? '';
        $order->email = $userOrerData['email'] ?? '';
        $order->content = $userOrerData['note'] ?? '';
        $order->order_status_id = OrderStatus::WAIT_PAYMENT;
        $order->payment_method_id = $userOrerData['payment_method'];
        $order->total = $totalMoney;
        $order->total_final = $totalMoney;
        $order->order_type_id = OrderType::ORDER_DEPOSIT_WALLET;
        $order->save();
        $order->code = 'TPORD_'.$order->id;
        $order->save();
		return $order;
	}

	protected function validatorDeposit(array $data)
    {
        return Validator::make($data, [
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required'],
            'amount' => ['required'],
            'payment_method' => ['required']
        ], [
            'required' => ':attribute không được để trống'
        ], [
            'name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'amount' => 'Số tiền muốn nạp',
            'payment_method' => 'Phương thức thanh toán',
        ]);
    }
}
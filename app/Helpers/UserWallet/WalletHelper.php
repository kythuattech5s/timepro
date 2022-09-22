<?php
namespace App\Helpers\UserWallet;
use Illuminate\Support\Facades\Hash;
use App\Models\{UserWallet,UserWalletTransaction,UserWalletTransactionType};
use SettingHelper;
use Support;

class WalletHelper{
	const TRANSACTION_CALCULATION_PLUS = 1;
	const TRANSACTION_CALCULATION_MINUS = 2;

	const TRANSACTION_STATUS_TRADING = 0;
	const TRANSACTION_STATUS_SUCCESS = 1;
	const TRANSACTION_STATUS_CANCEL  = 2;

	public static function create($user){
		if($user==null) return;
		$wallet = UserWallet::where(['act'=>1,'user_id'=>Support::show($user,'id')])->first();
		if($wallet!=null) return;
		$wallet = new UserWallet;
		$wallet->name = Support::show($user,'name');
		$wallet->amount = 0;
		$wallet->amount_available = 0;
		$wallet->amount_frozen = 0;
		$wallet->amount_spent = 0;
		$wallet->user_id = Support::show($user,'id');
		$wallet->token = Hash::make(Support::show($user,'uslug'));
		$wallet->act = 1;
		$wallet->ord = 1;
		$wallet->save();
		return $wallet;
	}
	public static function setTokenWallet($userId,$token){
		$wallet = UserWallet::where('user_id',$userId);
		if($wallet!=null) return;
		$wallet->token = $token;
		$wallet->save();
	}

	public static function creatPassword($id,$password){
		return UserWallet::where(['id'=>$id])->update(['password'=>Hash::make($password)]);
	}

	public static function checkHasPassword($password){
		return $password != null || $password !== '';
	}
	
	public static function insertTransaction($wallet, int $type, int $amount, string $reason,int $transactionCalculation,int $status = 0,$orderId = 0)
	{
		$trans = UserWalletTransaction::where(['order_id'=>$orderId,'user_id'=>Support::show($wallet,'user_id'),'wallet_id'=>Support::show($wallet,'id')])->first();
		if(isset($trans)){
			$trans->status = $status;
			$trans->save();
			return $trans;
		}
		else{
			$trans = new UserWalletTransaction;
		}
		$trans->wallet_id = Support::show($wallet,'id');
		$trans->user_id = Support::show($wallet,'user_id');
		$trans->amount = $amount;
		$trans->type = $type;
		$trans->reason = $reason;
		if($status == self::TRANSACTION_STATUS_TRADING){
			$trans->before_amount = Support::show($wallet,'amount');
			$trans->before_amount_available = Support::show($wallet,'amount_available');
			if($transactionCalculation == self::TRANSACTION_CALCULATION_PLUS){
				$trans->after_amount = Support::show($wallet,'amount')+$amount;
				$trans->after_amount_available =  Support::show($wallet,'amount_available')+$amount;
			}
			else{
				$trans->after_amount = Support::show($wallet,'amount')-$amount;
				$trans->after_amount_available = Support::show($wallet,'amount_available')-$amount;
			}
		}
		elseif($status == self::TRANSACTION_STATUS_SUCCESS){
			if($transactionCalculation == self::TRANSACTION_CALCULATION_PLUS){
				$trans->before_amount = Support::show($wallet,'amount')-$amount;
				$trans->before_amount_available = Support::show($wallet,'amount_available')-$amount;
			}
			else{
				$trans->before_amount = Support::show($wallet,'amount')+$amount;
				$trans->before_amount_available = Support::show($wallet,'amount_available')+$amount;
			}
			$trans->after_amount = Support::show($wallet,'amount');
			$trans->after_amount_available =  Support::show($wallet,'amount_available');
		}
		$trans->status = $status;
		$trans->content = $reason;
		$trans->order_id = $orderId;
		$trans->save();
		$trans->code = '1000'.$trans->id;
		$trans->save();
		return $trans;
	}
}
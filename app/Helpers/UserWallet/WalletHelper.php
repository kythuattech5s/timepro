<?php
namespace App\Helpers\UserWallet;
use Illuminate\Support\Facades\Hash;
use App\Models\{UserWallet,UserWalletTransaction};
use SettingHelper;
use Support;

class WalletHelper{

	const PERFIX_CODE_WALLET_TRANSACTION = 'WALLET-TIMES-PRO-';
	const TRANSACTION_DEPOSIT = 1;
	const KEY_SESSION_PASSWORD_SUCCESS = '__confirm_key_session_success__';
	public static function getTransaction($trans){	
		switch ($trans) {
			case self::TRANSACTION_DEPOSIT:
				return 'Nạp tiền';
			default:
				throw new Exception("Không tồn tại loại giao dịch");
		}
	}
	public static function create($user){
		if($user==null) return;
		$wallet = UserWallet::where(['act'=>1,'user_id'=>Support::show($user,'id')])->first();
		if($wallet!=null) return;
		$wallet = new UserWallet;
		$wallet->name = Support::show($user,'name');
		$wallet->amount = 0;
		$wallet->amount_frozen = 0;
		$wallet->amount_spent = 0;
		$wallet->agency_id = Support::show($user,'id');
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

	public static function getTypeTransaction($type){
		switch ($type) {
			case self::TRANSACTION_DEPOSIT:
				return 1;
				break;
			case self::TRANSACTION_UNFROZEN:
				return 0;
				break;
		}
		return $type;
	}
	
	public static function insertTransaction($wallet, int $type, int $amount, string $reason,string $content)
	{
		$walletBeforeTransaction = clone $wallet;
		switch ($type) {
			case self::TRANSACTION_DEPOSIT:
				$wallet->amount_available += $amount;
				$wallet->amount_spent -= $amount;
				break;
		}
		$wallet->save();
		$trans = new UserWalletTransaction;
		$trans->wallet_id = $wallet->id;
		$trans->user_id = $wallet->user_id;
		$trans->amount = $amount;
		$trans->type = $type;
		$trans->reason = $reason;
		$trans->before_amount = $wallet->amount;
		$trans->before_amount_frozen = $wallet->amount_frozen;
		$trans->before_amount_available = $wallet->amount + $wallet->amount_frozen;
		$trans->after_amount_frozen = $wallet->amount_frozen;
		if($type !== self::TRANSACTION_WITHDRAWAL){
			$trans->after_amount = $wallet->amount;
			$trans->after_amount_available = $wallet->amount + $wallet->amount_frozen;
		}
		else{
			$trans->after_amount = $wallet->amount - $amount;
			$trans->after_amount_available = $wallet->amount + $wallet->amount_frozen - $amount;
		}
		$trans->before_amount_spent = $wallet->amount_spent;
		$trans->after_amount_spent = $wallet->amount_spent;
		$trans->status = 0;
		$trans->content = $content;
		$trans->save();
		
		$trans->code = static::PERFIX_CODE_WALLET_TRANSACTION.$trans->id;
		$trans->save();
		return $trans;
	}
}
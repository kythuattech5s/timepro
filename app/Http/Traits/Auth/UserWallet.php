<?php
namespace App\Http\Traits\Auth;
use Auth;
use SettingHelper;
trait UserWallet{
	public function wallet(){
		if(!Auth::check()){
			$this->goLogin();
		}
		$user = Auth::user();
		if(\Support::show($user,'user_type_id') != 1){
			return \Redirect::to(url('/'))->with('typeNotify','error')->with('messageNotify','Tài khoản của bạn không có quyền truy cập');
		}
		$wallet = $user->wallet()->first();
		$walletTransactions = $wallet != null?$wallet->walletTransactions()->get():[];
		return view('auth.account.wallet',compact('wallet','walletTransactions'));
	}
	public function deposit(){
		if(!Auth::check()){
			$this->goLogin();
		}
		$user = Auth::user();
		if(\Support::show($user,'user_type_id') != 1){
			if(request()->ajax()){
				return response()->json(['code'=>100,'message'=>'Tài khoản của bạn không có quyền truy cập']);
			}
			else{
				return \Redirect::to(url('/'))->with('typeNotify','error')->with('messageNotify','Tài khoản của bạn không có quyền truy cập');
			}
		}
		return view('auth.account.deposit_wallet');
	}
}
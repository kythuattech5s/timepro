<?php
namespace App\Http\Traits\Auth;
use Auth;
use SettingHelper;
trait UpgradeVip{
	public function upgrade(){
		if(!Auth::check()){
			$this->goLogin();
		}
		return view('auth.account.upgrade_vip');
	}
}
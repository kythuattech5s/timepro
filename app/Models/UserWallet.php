<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserWallet extends BaseModel
{
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function walletTransactions(){
        return $this->hasMany(UserWalletTransaction::class,'wallet_id','id');
    }
}
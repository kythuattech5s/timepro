<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserWallet extends BaseModel
{
    use HasFactory;

    public function walletTransactions(){
        return $this->hasMany(UserWalletTransaction::class,'wallet_id','id');
    }
}
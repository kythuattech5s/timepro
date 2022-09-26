<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserWalletTransactionType extends BaseModel
{
    use HasFactory;
    const DEPOSIT_MONEY_INTO_WALLET = 1;
    const PAYMENT_ORDER = 2;
}
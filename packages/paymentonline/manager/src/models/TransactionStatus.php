<?php
namespace paymentonline\manager\models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
class TransactionStatus extends BaseModel
{
    use HasFactory;
	protected $table = 'transaction_status';
}
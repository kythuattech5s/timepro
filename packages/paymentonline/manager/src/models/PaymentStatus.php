<?php
namespace paymentonline\manager\models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
class PaymentStatus extends BaseModel
{
    use HasFactory;
	protected $table = 'payment_status';
}
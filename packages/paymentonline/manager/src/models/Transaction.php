<?php
namespace paymentonline\manager\models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
class Transaction extends BaseModel
{
    use HasFactory;
    public function paymentMethod(){
        return $this->hasOne(PaymentMethod::class,'id','payment_method_id');
    }
    public function insertTransaction($order,$urlBackSuccess){
        
        $dataTransaction = [];
        $dataTransaction['order_code'] = $order->code;
        $dataTransaction['payment_method_id'] = $order->payment_method_id;
        $dataTransaction['status'] = 0;
        $dataTransaction['amount'] = $order->total_final;
        $dataTransaction['table_map'] = $order->getTable();
        $dataTransaction['map_id'] = $order->id;
        $dataTransaction['created_at'] = new \DateTime;
        $dataTransaction['updated_at'] = new \DateTime;
        $dataTransaction['call_back_success_link'] = $urlBackSuccess.'?code_order='.\Support::show($order,'code');
        $id = self::insertGetId($dataTransaction);
        return $id;
    }
}
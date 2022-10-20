<?php 
namespace Tech5s\ManagerUser\Helpers;
use App\Models\{Order,OrderStatus,User,UserType};
use App\Helpers\Currency;
class AdminStatical
{
    public static function getOrderToDay()
    {
        $ret = [];
        $startTime   = now()->firstOfMonth()->format('Y-m-d').' '.'00:00:00';
        $endTime     = now()->endOfMonth()->format('Y-m-d').' '.'23:59:59';
        $orderToDay  = Order::where('created_at','>',$startTime)->where('created_at','<',$endTime)->get()->all();
        $arrOrderId  = [];
        $arrOrderId['orderToDayPass'] = [];
        $arrOrderId['orderToDayWait'] = [];
        $arrOrderId['orderToDayFail'] = [];
        foreach ($orderToDay as $itemOrder) {
            if ($itemOrder->order_status_id == OrderStatus::PAID) {
                array_push($arrOrderId['orderToDayPass'], $itemOrder->id);
            }
            if ($itemOrder->order_status_id == OrderStatus::WAIT_PAYMENT) {
                array_push($arrOrderId['orderToDayWait'], $itemOrder->id);
            }
            if ($itemOrder->order_status_id == OrderStatus::CANCEL) {
                array_push($arrOrderId['orderToDayFail'], $itemOrder->id);
            }
        }
        $baseFillterOrderStr = 'esystem/search/%s?%s&orderkey=id&ordervalue=desc&custome_search=1&limit=10';
        $ret['orderToDayPass']['total'] = count($arrOrderId['orderToDayPass']);
        if ($ret['orderToDayPass']['total'] > 0) {
            $paramOrder = 'raw_id%5B%5D='.implode('&raw_id%5B%5D=', $arrOrderId['orderToDayPass']);
            $ret['orderToDayPass']['link'] = vsprintf($baseFillterOrderStr,['orders',$paramOrder]);
        }
        $ret['orderToDayWait']['total'] = count($arrOrderId['orderToDayWait']);
        if ($ret['orderToDayWait']['total'] > 0) {
            $paramOrder = 'raw_id%5B%5D='.implode('&raw_id%5B%5D=', $arrOrderId['orderToDayWait']);
            $ret['orderToDayWait']['link'] = vsprintf($baseFillterOrderStr,['orders',$paramOrder]);
        }
        $ret['orderToDayFail']['total'] = count($arrOrderId['orderToDayFail']);
        if ($ret['orderToDayFail']['total'] > 0) {
            $paramOrder = 'raw_id%5B%5D='.implode('&raw_id%5B%5D=', $arrOrderId['orderToDayFail']);
            $ret['orderToDayFail']['link'] = vsprintf($baseFillterOrderStr,['orders',$paramOrder]);
        }
        return $ret;
    }

    public function getRevenueMonth(){
        $ret = [];
        $startTime   = now()->firstOfMonth()->format('Y-m-d').' '.'00:00:00';
        $endTime     = now()->endOfMonth()->format('Y-m-d').' '.'23:59:59';
        $totalRevenuePaid = Order::where('updated_at','>',$startTime)->where('updated_at','<',$endTime)->where('order_status_id',OrderStatus::PAID)->get()->sum('total_final');
        $totalRevenueWait = Order::where('updated_at','>',$startTime)->where('updated_at','<',$endTime)->where('order_status_id',OrderStatus::WAIT_PAYMENT)->get()->sum('total_final');
        $totalRevenueCancel = Order::where('updated_at','>',$startTime)->where('updated_at','<',$endTime)->where('order_status_id',OrderStatus::CANCEL)->get()->sum('total_final');
        $ret['totalRevenuePaid'] = Currency::showMoney($totalRevenuePaid);
        $ret['totalRevenueWait'] = Currency::showMoney($totalRevenueWait);
        $ret['totalRevenueCancel'] = Currency::showMoney($totalRevenueCancel);
        return $ret;
    }
    public static function staticalUserInfo()
    {
        $ret = [];
        $listUser = User::all();
        $totalUserNormal = $listUser->filter(function($q){
            return $q->user_type_id == UserType::NORMAL_ACCOUNT;
        });
        $totalUserTeacher = $listUser->filter(function($q){
            return $q->user_type_id == UserType::TEACHER_ACCOUNT;
        });
        $totalUserInternal = $listUser->filter(function($q){
            return $q->user_type_id == UserType::INTERNAL_STUDENT_ACCOUNT;
        });
        $ret['totalUser'] = count($listUser);
        $ret['totalUserNormal'] = count($totalUserNormal);
        $ret['totalUserTeacher'] = count($totalUserTeacher);
        $ret['totalUserInternal'] = count($totalUserInternal);
        return $ret;
    }
    public function getUserVip(){
        return User::whereHas('userCourseCombo',function($q){
            $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
        })->with(['userCourseCombo'=>function($q){
            $q->where('expired_time','>',now());
        }])->get();
    }
}
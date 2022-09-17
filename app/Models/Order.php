<?php
namespace App\Models;
class Order extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function changeStatusAble()
    {
        return $this->order_status_id == OrderStatus::WAIT_PAYMENT;
    }
    public function orderSuccess()
    {
        if (!isset($this->user)) {
            return;
        }
        $user = $this->user;
        foreach ($this->orderDetail()->get() as $itemOrderCourseDetail) {
            switch ($itemOrderCourseDetail->type) {
                case 'course':
                    $this->activeItemCourse($itemOrderCourseDetail,$user);
                    break;
                case 'vip':
                    $this->activeItemCourseCombo($itemOrderCourseDetail,$user);
                    break;
                default:
                    break;
            }
        }
    }
    private function activeItemCourse($itemOrderCourseDetail,$user){
        $userCourse = UserCourse::where('user_id',$user->id)
                                    ->where('course_id',$itemOrderCourseDetail->map_id)
                                    ->first();
        if (!isset($userCourse)) {
            $newUserCourse = new UserCourse;
            $newUserCourse->user_id = $user->id;
            $newUserCourse->course_id = $itemOrderCourseDetail->map_id;
            $newUserCourse->expired_time = now()->addDays($itemOrderCourseDetail->number_day);
            $newUserCourse->is_forever = $itemOrderCourseDetail->is_forever;
            $newUserCourse->save();
        }else{
            if ($itemOrderCourseDetail->is_forever == 1) {
                $userCourse->is_forever = 1;
            }
            $expiredTime = now()->createFromTimeString($userCourse->expired_time);
            if ($expiredTime->gt(now())) {
                $userCourse->expired_time = $expiredTime->addDays($itemOrderCourseDetail->number_day);
            } else {
                $userCourse->expired_time = now()->addDays($itemOrderCourseDetail->number_day);
            }
            $userCourse->save();
        }
    }
    private function activeItemCourseCombo($itemOrderCourseComboDetail,$user){
        $userCourseCombo = UserCourseCombo::where('user_id',$user->id)
                                ->where('course_combo_id',$itemOrderCourseComboDetail->map_id)
                                ->first();
        if (!isset($userCourseCombo)) {
            $newUserCourse = new UserCourseCombo;
            $newUserCourse->user_id = $user->id;
            $newUserCourse->course_combo_id = $itemOrderCourseComboDetail->map_id;
            $newUserCourse->expired_time = now()->addDays($itemOrderCourseComboDetail->number_day);
            $newUserCourse->is_forever = $itemOrderCourseComboDetail->is_forever;
            $newUserCourse->save();
        }else{
            if ($itemOrderCourseComboDetail->is_forever == 1) {
                $userCourseCombo->is_forever = 1;
            }
            $expiredTime = now()->createFromTimeString($userCourseCombo->expired_time);
            if ($expiredTime->gt(now())) {
                $userCourseCombo->expired_time = $expiredTime->addDays($itemOrderCourseComboDetail->number_day);
            } else {
                $userCourseCombo->expired_time = now()->addDays($itemOrderCourseComboDetail->number_day);
            }
            $userCourseCombo->save();
        }
    }
}
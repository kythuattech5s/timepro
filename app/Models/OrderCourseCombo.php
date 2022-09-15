<?php
namespace App\Models;
class OrderCourseCombo extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderCourseComboDetail()
    {
        return $this->hasMany(OrderCourseComboDetail::class);
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
        foreach ($this->orderCourseComboDetail()->get() as $itemOrderCourseComboDetail) {
            $userCourseCombo = UserCourseCombo::where('user_id',$this->user_id)
                                    ->where('course_combo_id',$itemOrderCourseComboDetail->course_combo_id)
                                    ->first();
            if (!isset($userCourseCombo)) {
                $newUserCourse = new UserCourseCombo;
                $newUserCourse->user_id = $user->id;
                $newUserCourse->course_combo_id = $itemOrderCourseComboDetail->course_combo_id;
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
}
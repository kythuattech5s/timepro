<?php
namespace App\Models;
class OrderCourse extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderCourseDetail()
    {
        return $this->hasMany(OrderCourseDetail::class);
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
        foreach ($this->orderCourseDetail()->get() as $itemOrderCourseDetail) {
            $userCourse = UserCourse::where('user_id',$this->user_id)
                                    ->where('course_id',$itemOrderCourseDetail->course_id)
                                    ->first();
            if (!isset($userCourse)) {
                $newUserCourse = new UserCourse;
                $newUserCourse->user_id = $user->id;
                $newUserCourse->course_id = $itemOrderCourseDetail->course_id;
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
    }
}
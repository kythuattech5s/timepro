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
        $listItemOrderDetail = $this->orderDetail()->get();
        $orderTypeId = $this->order_type_id;
        $emaiOrderSuccessContent = view('mail_templates.order_success',[
            'order' => $this,
            'listItemOrderDetail' => $listItemOrderDetail,
            'mainName'=> $user->name
        ])->render();
        $queueEmail = new QueueEmail;
        $queueEmail->title = request()->getHttpHost().($orderTypeId==OrderType::ORDER_DEPOSIT_WALLET?' Đặt hàng thành công':' Nạp tiền thành công');
        $queueEmail->content = $emaiOrderSuccessContent;
        $queueEmail->to = $this->email;
        $queueEmail->status = 0;
        $queueEmail->save();
        foreach ($listItemOrderDetail as $itemOrderDetail) {
            switch ($itemOrderDetail->type) {
                case 'course':
                    $this->activeItemCourse($itemOrderDetail,$user);
                    break;
                case 'vip':
                    $this->activeItemCourseCombo($itemOrderDetail,$user);
                    break;
                default:
                    break;
            }
        }
        if($orderTypeId == OrderType::ORDER_DEPOSIT_WALLET){
            $amount = $this->total_final;
            $user->plusAmountAvailable($amount,UserWalletTransactionType::DEPOSIT_MONEY_INTO_WALLET,'Nạp tiền vào ví',$this->id);
        }
    }
    private function activeItemCourse($itemOrderCourseDetail,$user){
        $userCourse = UserCourse::where('user_id',$user->id)
                                    ->where('course_id',$itemOrderCourseDetail->map_id)
                                    ->first();
        $course = Course::find($itemOrderCourseDetail->map_id);
        if (isset($course)) {
            $course->number_student = $course->number_student + 1;
            $course->save();
        }
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
        $courseCombo = CourseCombo::find($itemOrderCourseComboDetail->map_id);
        if (isset($courseCombo) && $courseCombo->all_course != 1) {
            $listCourse = $courseCombo->course()->get();
            foreach ($listCourse as $itemCourse) {
                $itemCourse->number_student = $itemCourse->number_student + 1;
                $itemCourse->save();
            }
        }
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
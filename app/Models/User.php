<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\User as UserNotify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Roniejisa\Comment\Traits\GetDataComment;
use Tech5s\Notify\Traits\NotificationUserTrait;
use App\Helpers\UserWallet\WalletHelper;
class User extends Authenticatable
{
    use HasFactory, NotificationUserTrait, GetDataComment;
    const IS_TYPE_ACCOUT = 1;
    protected $listUserCourseId = null;
    protected $hidden = ['remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function teacherCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id', 'id');
    }

    // public function totalDuration()
    // {
    //     $second = $this->teacherCourses->sum(function ($q) {
    //         return $q->videos->sum(function ($q) {
    //             return (int) $q->duration > 0 ? $q->duration : 0;
    //         });
    //     });
    //     return (int)($second/3600);
    // }
    public function totalDuration()
    {
        $minute = $this->teacherCourses->sum('duration');
        return (int)($minute/60);
    }

    public function getRatingScore()
    {
        $comments = $this->getRating('main');
        return $comments['scoreAll'];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendNotification(array $data, int $type)
    {
        $this->notify(new UserNotify($data, $type, $this));
    }
    public function pivot()
    {
        return $this->hasMany(UserTeacherSkill::class, 'user_id', 'id');
    }
    public function skills()
    {
        return $this->belongsToMany(TeacherSkill::class, 'user_teacher_skill', 'user_id', 'teacher_skill_id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
    public function scopeTeacher($q)
    {
        return $q->where('user_type_id', UserType::TEACHER_ACCOUNT);
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    public function examResult()
    {
        return $this->hasMany(ExamResult::class);
    }
    public function obligatoryExamResult()
    {
        return $this->hasMany(ObligatoryExamResult::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }
    public function userCourse()
    {
        return $this->hasMany(UserCourse::class);
    }
    public function scopeStudent($q,$listTeacherCourseId)
    {
        return $q->where('act',1)->where('banned',0)->whereIn('user_type_id',[UserType::NORMAL_ACCOUNT,UserType::INTERNAL_STUDENT_ACCOUNT])->where(function($q) use ($listTeacherCourseId){
            $q->whereHas('userCourse',function($q) use ($listTeacherCourseId){
                $q->whereIn('course_id',$listTeacherCourseId)->where(function($q){
                    $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
                });
            })
            ->orWhereHas('userCourseCombo',function($q){
                $q->whereHas('courseCombo', function ($q) {
                    $q->where('all_course', 1);
                })
                ->where(function ($q) {
                    $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
                });
            })
            ->orWhereHas('userCourseCombo',function($q) use ($listTeacherCourseId) {
                $q->whereHas('courseCombo', function ($q) use ($listTeacherCourseId) {
                    $q->where('all_course', 0)->whereHas('course',function($q) use ($listTeacherCourseId) {
                        $q->whereIn('id',$listTeacherCourseId);
                    });
                })
                ->where(function ($q) {
                    $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
                });
            });
        });
    }
    public function userCourseCombo()
    {
        return $this->hasMany(UserCourseCombo::class);
    }
    public function buildHrefTeacher()
    {
        return $this->uslug != '' ? 'thong-tin-giang-vien/' . $this->uslug : 'javascript:void(0)';
    }
    public function getCountNeedDoneExam()
    {
        $user = $this;
        $listUserCourseId = $user->userAllCourseId();
        $strIdCourseUser = trim(implode(',', $listUserCourseId->toArray()) . ',-1', ',');
        return Course::baseView()->whereIn('id', $listUserCourseId)
            ->whereRaw(vsprintf("id in (select id from (select id,case when count_video = 0 then 0 else (100*count_video_done/count_video) end as percent_done from (SELECT *,(SELECT count(*) from course_videos WHERE course_videos.course_id = courses.id) as count_video,(SELECT count(*) from course_video_user WHERE course_video_user.course_id = courses.id and course_video_user.user_id = %s) as count_video_done from courses where id in (%s)) as course_videos_statical having percent_done = 100) as base)", [$user->id, $strIdCourseUser]))
            ->whereHas('exam')
            ->whereDoesntHave('examResult', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->count();
    }
    public function getCountNeedDoneObligatoryExam()
    {
        $user = $this;
        return ObligatoryExam::act()->where('open_time','<',now())
                                    ->where('close_time','>',now())
                                    ->whereDoesntHave('examResult',function($q) use ($user){
                                        $q->where('user_id',$user->id);
                                    })
                                    ->count();
    }
    public function userAllCourseId()
    {
        if (isset($this->listUserCourseId)) {
            return $this->listUserCourseId;
        }
        $userCourseComboAllCount = $this->userCourseCombo()->whereHas('courseCombo', function ($q) {
                                                                $q->where('all_course', 1);
                                                            })
                                                            ->where(function ($q) {
                                                                $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
                                                            })
                                                            ->first();
        if (isset($userCourseComboAllCount)) {
            return Course::act()->get()->pluck('id');
        }
        $userCourseComboSpecialCourse = $this->userCourseCombo()->whereHas('courseCombo', function ($q) {
                                                                    $q->act()->where('all_course', '!=', 1);
                                                                })
                                                                ->with(['courseCombo' => function ($q) {
                                                                    $q->act()->where('all_course', '!=', 1)->with('course');
                                                                }])
                                                                ->where(function ($q) {
                                                                    $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
                                                                })
                                                                ->get();
        $listCourseId = collect();
        foreach ($userCourseComboSpecialCourse as $item) {
            $listCourseId = $listCourseId->merge($item->courseCombo->course->pluck('id'));
        }
        $listUserCourseId = $this->userCourse()->whereHas('course', function ($q) {
                                                    $q->act();
                                                })
                                                ->where(function ($q) {
                                                    $q->where('expired_time', '>', now())->orWhere('is_forever', 1);
                                                })
                                                ->pluck('course_id');
        $listCourseId = $listCourseId->merge($listUserCourseId)->unique();
        $this->listUserCourseId = $listCourseId;
        return $listCourseId;
    }
    public function wallet()
    {
        return $this->hasOne(UserWallet::class, 'user_id', 'id');
    }

    public function isAccount()
    {
        return in_array($this->user_type_id,[UserType::NORMAL_ACCOUNT,UserType::INTERNAL_STUDENT_ACCOUNT]);
    }

    public function getAmountAvailable(){
        $wallet = $this->wallet()->first();
        if(!isset($wallet)){
            $user = \Auth::user();
            $wallet = \App\Helpers\UserWallet\WalletHelper::create($user);
        }
        return \Support::show($wallet,'amount_available');
    }

    public function plusAmountAvailable($amount,$type,$reson,$orderId = 0){
        if((int)$amount == 0) return false;
        $wallet = $this->wallet()->first();
        if(!isset($wallet)){
            $user = \Auth::user();
            $wallet = \App\Helpers\UserWallet\WalletHelper::create($user);
        }
        $wallet->amount_available = (int)\Support::show($wallet,'amount_available') + (int)$amount;
        $wallet->amount = (int)\Support::show($wallet,'amount') + (int)$amount;
        $wallet->save();
        WalletHelper::insertTransaction($wallet,$type,$amount,$reson,WalletHelper::TRANSACTION_CALCULATION_PLUS,WalletHelper::TRANSACTION_STATUS_SUCCESS,$orderId);
        return true;
    }

    public function minusAmountAvailable($amount,$type,$reson,$orderId = 0){
        if((int)$amount == 0) return false;
        $wallet = $this->wallet()->first();
        if(!isset($wallet)){
            $user = \Auth::user();
            $wallet = \App\Helpers\UserWallet\WalletHelper::create($user);
        }
        if((int)\Support::show($wallet,'amount_available') < (int)$amount) return false;
        $wallet->amount_available = (int)\Support::show($wallet,'amount_available') - (int)$amount;
        $wallet->amount = (int)\Support::show($wallet,'amount') - (int)$amount;
        $wallet->save();
        WalletHelper::insertTransaction($wallet,$type,$amount,$reson,WalletHelper::TRANSACTION_CALCULATION_PLUS,WalletHelper::TRANSACTION_STATUS_SUCCESS,$orderId);
        return true;
    }

}

<?php
namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\User as UserNotify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tech5s\Notify\Traits\NotificationUserTrait;

class User extends Authenticatable
{
    use HasFactory, NotificationUserTrait;
    protected $listUserCourseId = null;
    protected $hidden = ['remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendNotification(array $data, int $type)
    {
        $this->notify(new UserNotify($data, $type, $this));
    }
    public function pivot(){
    	return $this->hasMany(UserTeacherSkill::class, 'user_id', 'id');
    }
    public function skills()
    {
    	return $this->belongsToMany(TeacherSkill::class,'user_teacher_skill', 'user_id', 'teacher_skill_id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class,'province_id','id');
    }
    public function scopeTeacher($q)
    {
        return $q->where('user_type_id', UserType::TEACHER_ACCOUNT);
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class,'ward_id','id');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    public function course()
    {
        return $this->hasMany(Course::class,'teacher_id');
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
    public function userCourseCombo()
    {
        return $this->hasMany(UserCourseCombo::class);
    }
    public function getCountNeedDoneExam()
    {
        $user = $this;
        $listUserCourseId = $user->userAllCourseId();
        $strIdCourseUser = implode(',',$listUserCourseId->toArray());
        return Course::baseView()->whereIn('id', $listUserCourseId)
                                        ->whereRaw(vsprintf("id in (select id from (select id,case when count_video = 0 then 0 else (100*count_video_done/count_video) end as percent_done from (SELECT *,(SELECT count(*) from course_videos WHERE course_videos.course_id = courses.id) as count_video,(SELECT count(*) from course_video_user WHERE course_video_user.course_id = courses.id and course_video_user.user_id = %s) as count_video_done from courses where id in (%s)) as course_videos_statical having percent_done = 100) as base)",[$user->id,$strIdCourseUser]))
                                        ->whereHas('exam')
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
        $userCourseComboAllCount = $this->userCourseCombo()->whereHas('courseCombo',function($q){
                                                                $q->where('all_course',1);
                                                            })
                                                            ->where(function($q){
                                                                $q->where('expired_time','>',now())->orWhere('is_forever',1);
                                                            })
                                                            ->first();
        if (isset($userCourseComboAllCount)) {
            return Course::act()->get()->pluck('id');
        }
        $userCourseComboSpecialCourse = $this->userCourseCombo()->whereHas('courseCombo',function($q){
                                                                    $q->act()->where('all_course','!=',1);
                                                                })
                                                                ->with(['courseCombo'=>function($q){
                                                                    $q->act()->where('all_course','!=',1)->with('course');
                                                                }])
                                                                ->where(function($q){
                                                                    $q->where('expired_time','>',now())->orWhere('is_forever',1);
                                                                })
                                                                ->get();
        $listCourseId = collect();
        foreach ($userCourseComboSpecialCourse as $item) {
            $listCourseId = $listCourseId->merge($item->courseCombo->course->pluck('id'));
        }
        $listUserCourseId = $this->userCourse()->whereHas('course',function($q){
                                                    $q->act();
                                                })
                                                ->where(function($q){
                                                    $q->where('expired_time','>',now())->orWhere('is_forever',1);
                                                })
                                                ->pluck('course_id');
        $listCourseId = $listCourseId->merge($listUserCourseId)->unique();
        $this->listUserCourseId = $listCourseId;
        return $listCourseId;
    }
    public function wallet(){
        return $this->hasOne(UserWallet::class,'user_id','id');
    }
}

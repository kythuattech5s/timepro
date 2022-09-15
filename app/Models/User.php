<?php
namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\User as UserNotify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $hidden = ['password', 'remember_token'];
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
    public function userCoursePaginage($paginateNumber)
    {
        $userCourseComboAllCount = $this->userCourseCombo()->whereHas('courseCombo',function($q){
                                                                $q->where('all_course',1);
                                                            })
                                                            ->where(function($q){
                                                                $q->where('expired_time','>',now())->orWhere('is_forever',1);
                                                            })
                                                            ->first();
        if (isset($userCourseComboAllCount)) {
            return Course::act()->paginate($paginateNumber);
        }
        $userCourseComboSpecialCourse = $this->userCourseCombo()->whereHas('courseCombo',function($q){
                                                                    $q->where('all_course','!=',1);
                                                                })
                                                                ->with(['courseCombo'=>function($q){
                                                                    $q->where('all_course','!=',1)->with('course');
                                                                }])
                                                                ->where(function($q){
                                                                    $q->where('expired_time','>',now())->orWhere('is_forever',1);
                                                                })
                                                                ->get();
        $listCourseId = collect();
        foreach ($userCourseComboSpecialCourse as $item) {
            $listCourseId = $listCourseId->merge($item->courseCombo->course->pluck('id'));
        }
        $listUserCourseId = $this->userCourse()->where(function($q){
                                            $q->where('expired_time','>',now())->orWhere('is_forever',1);
                                        })
                                        ->pluck('course_id');
        $listCourseId = $listCourseId->merge($listUserCourseId)->unique();
        return Course::whereIn('id',$listCourseId)->act()->paginate($paginateNumber);
    }
}

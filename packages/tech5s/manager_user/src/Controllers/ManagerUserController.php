<?php

namespace Tech5s\ManagerUser\Controllers;
use vanhenry\manager\controller\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tech5s\ManagerUser\Helpers\AdminStatical;
use App\Models\{User,Course,CourseCategory,CourseCombo,UserType};
use DB;
use View;
use Support;
class ManagerUserController extends BaseAdminController
{
    public function staticalAll(){
        $infoOrderToday =  AdminStatical::getOrderToDay();
        $revenueMonth   =  AdminStatical::getRevenueMonth();
        $listUserInfo   =  AdminStatical::staticalUserInfo();
        $listUserVip    =  AdminStatical::getUserVip();
        return view('mgu::statical_all',compact('infoOrderToday','revenueMonth','listUserInfo','listUserVip'));
    }


    public function staticalUserAndCourse(){
        return view('mgu::statical_user_course');
    }

    public function staticalUser(){
        $request = request();
        $type = $request->input('type');
        $users = User::all();
        switch ($type) {
            case UserType::TEACHER_ACCOUNT:
                $listItems = User::where('user_type_id',UserType::TEACHER_ACCOUNT)->paginate(10);
                return view('mgu::path.user_teacher',compact('listItems'))->render();
                break;
            case UserType::INTERNAL_STUDENT_ACCOUNT:
                $listItems = User::where('user_type_id',UserType::INTERNAL_STUDENT_ACCOUNT)->paginate(10);
                return view('mgu::path.user_internal',compact('listItems'))->render();
                break;
            case UserType::NORMAL_ACCOUNT:
                $listItems = User::where('user_type_id',UserType::NORMAL_ACCOUNT)->paginate(10);
                return view('mgu::path.user_normal',compact('listItems'))->render();
                break;
            default:
                break;
        }
    }

    public function staticalCourse(){
        $listItems = Course::act()->paginate(10);
        return view('mgu::path.course',compact('listItems'))->render();
    }

    public function staticalUserStudentOfCourse($courseId){
        $course = Course::with('teacher')->where('id',$courseId)->first();
        if(!isset($course)){
            return;
        }
        $listItems = User::student([$courseId])->paginate(6);
        return view('mgu::statical_user_of_course',compact('listItems','course'));
    }
    
    public function manageDetailStudentOfTeacher($userId){
        $userStudent = User::find($userId);
        if (!isset($userStudent)) {
            return false;
        }
        $listUserCourseId = $userStudent->userAllCourseId();
        $action = \FCHelper::getSegment($request, 3);
        $currentItem->vi_name = $currentItem->vi_name.' - '.$userStudent->name;
        $currentItem->vi_seo_title = $currentItem->vi_seo_title.' - '.$userStudent->name;
        $currentItem->vi_seo_key = $currentItem->vi_seo_key.' - '.$userStudent->name;
        $currentItem->vi_seo_des = $currentItem->vi_seo_des.' - '.$userStudent->name;
        $listItems = Course::baseView()
                    ->whereIn('id', $listUserCourseId)
                    ->whereIn('id',$listTeacherCourseId)
                    ->orderBy('id','desc')
                    ->paginate(6);
        return view('auth.teacher.manage_student_detail', compact('user','currentItem','userStudent','listItems'));
    }

    public function manageStudentOfTeacher($userId){
        $user = User::find($userId);
        if(!isset($user)){
            return;
        }
        $request = request();
        $listTeacherCourseId = $user->teacherCourses()->pluck('id');
        $currentItem = null;
        $userStudent = null;
        $usersearch = $request->usersearch ?? null;
        $listItems = User::student($listTeacherCourseId)
                ->orderBy('created_at','desc')
                ->when(isset($usersearch),function($q) use ($usersearch) {
                    $q->where(function($q) use ($usersearch) {
                        $q->where('name','like','%'.$usersearch.'%')->orWhere('email','like','%'.$usersearch.'%');
                    });
                })->paginate(20);
        return view('mgu::list_student', compact('user','currentItem','userStudent','listItems'));    
    }

    public function viewLearningHistoryOfUser($userId){
        $user = User::find($userId);
        if(!isset($user)){
            return;
        }
        $listUserCourseId = $user->userAllCourseId();
        $strIdCourseUser = trim(implode(',', $listUserCourseId->toArray()).',-1',',');
        $type = $request->type ?? 1;
        $activeCategoryId = $request->category ?? null;
        $sort = $request->sort ?? 1;
        $sortStr = 'id desc';
        if ($sort == 2) {
            $sortStr = 'id asc';
        }
        $listUserCourseId = $user->userAllCourseId();
        $listItems = Course::baseView()->whereIn('id', $listUserCourseId)
        ->when($activeCategoryId,function($q) use ($activeCategoryId){
            $q->whereHas('category',function($q) use ($activeCategoryId){
                $q->where('course_categories.id',$activeCategoryId);
            });
        })
        ->when($type != 1,function($q) use($type,$user,$strIdCourseUser) {
            $havingString = '';
            switch ($type) {
                case 2:
                    $havingString = 'HAVING percent_done = 0';
                    break;
                case 3:
                    $havingString = 'HAVING percent_done > 0 and percent_done < 100';
                    break;
                case 4:
                    $havingString = 'HAVING percent_done = 100';
                    break;
                default:
                    break;
            }
            $q->whereRaw(vsprintf("id in (select id from (select id,case when count_video = 0 then 0 else (100*count_video_done/count_video) end as percent_done from (SELECT *,(SELECT count(*) from course_videos WHERE course_videos.course_id = courses.id) as count_video,(SELECT count(*) from course_video_user WHERE course_video_user.course_id = courses.id and course_video_user.user_id = %s) as count_video_done from courses where id in (%s)) as course_videos_statical %s) as base)",[$user->id,$strIdCourseUser,$havingString]));
        })
        ->orderByRaw($sortStr)
        ->paginate(6);
        return view('mgu::history_learn',compact('listItems','user'));
    }
}
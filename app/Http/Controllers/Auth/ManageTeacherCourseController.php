<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ExamResult;
use App\Models\User;
use App\Models\UserType;
use Auth;
use Illuminate\Http\Request;
use Support;

class ManageTeacherCourseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) {
            if (request()->ajax()) {
                echo json_encode([
                    'code' => 100,
                    'message' => 'Vui lòng đăng nhập',
                    'redirect_url' => \VRoute::get("login")
                ]);
                die();
            }else{
                redirect()->to(\VRoute::get("login"))->with('messageNotify', 'Vui lòng đăng nhập')->with('typeNotify', 100)->send();
                throw new \Exception("Tài khoản của bạn không có chức năng này", 100);
            }
        }
        $user = Auth::user();
        if ($user->user_type_id != UserType::TEACHER_ACCOUNT) {
            if (request()->ajax()) {
                echo json_encode([
                    'code' => 100,
                    'message' => 'Tài khoản của bạn không có chức năng này',
                    'redirect_url' => \VRoute::get("login")
                ]);
                die();
            } else {
                redirect()->to(\VRoute::get("home"))->with('messageNotify', 'Tài khoản của bạn không có chức năng này')->with('typeNotify', 100)->send();
                throw new \Exception("Tài khoản của bạn không có chức năng này", 100);
            }
        }
    }
    
    public function manageStudent(Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $listTeacherCourseId = $user->teacherCourses()->pluck('id');
        $userStudentId = str_replace('thong-tin-hoc-vien-','',\FCHelper::getSegment($request, 2));
        if ($userStudentId != '') {
            $userStudent = User::student($listTeacherCourseId)->find($userStudentId);
            if (!isset($userStudent)) {
                return Support::redirectTo(\VRoute::get("manage_student"),100,'Không tìm thấy thông tin học viên');
            }
            $listUserCourseId = $userStudent->userAllCourseId();
            $action = \FCHelper::getSegment($request, 3);
            if ($action == 'ket-qua-thi') {
                $currentItem->vi_name = $currentItem->vi_name.' - '.$userStudent->name.' - Kết quả thi';
                $currentItem->vi_seo_title = $currentItem->vi_seo_title.' - '.$userStudent->name.' - Kết quả thi';
                $currentItem->vi_seo_key = $currentItem->vi_seo_key.' - '.$userStudent->name.' - Kết quả thi';
                $currentItem->vi_seo_des = $currentItem->vi_seo_des.' - '.$userStudent->name.' - Kết quả thi';
                $activeCourseId = $request->course ?? null;
                $listItems = ExamResult::with('course','exam')->whereHas('exam')
                                                        ->whereHas('course')
                                                        ->where('user_id',$userStudent->id)
                                                        ->whereIn('course_id',$listTeacherCourseId)
                                                        ->orderBy('id','desc')
                                                        ->when(isset($activeCourseId) && $listTeacherCourseId->contains($activeCourseId),function($q) use ($activeCourseId) {
                                                            $q->where('course_id',$activeCourseId);
                                                        })
                                                        ->paginate(10);
                $listTeacherCousre = Course::act()->whereIn('id',$listTeacherCourseId)->get();
                return view('auth.teacher.manage_student_detail_exam_result', compact('user','currentItem','userStudent','listItems','listTeacherCousre','activeCourseId'));
            }
            $currentItem->vi_name = $currentItem->vi_name.' - '.$userStudent->name;
            $currentItem->vi_seo_title = $currentItem->vi_seo_title.' - '.$userStudent->name;
            $currentItem->vi_seo_key = $currentItem->vi_seo_key.' - '.$userStudent->name;
            $currentItem->vi_seo_des = $currentItem->vi_seo_des.' - '.$userStudent->name;
            $listItems = Course::baseView()->whereIn('id', $listUserCourseId)
                                            ->whereIn('id',$listTeacherCourseId)
                                            ->orderBy('id','desc')
                                            ->paginate(6);
            return view('auth.teacher.manage_student_detail', compact('user','currentItem','userStudent','listItems'));
        }
        
        $usersearch = $request->usersearch ?? null;
        $listItems = User::student($listTeacherCourseId)->orderBy('created_at','desc')
                                                        ->when(isset($usersearch),function($q) use ($usersearch) {
                                                            $q->where(function($q) use ($usersearch) {
                                                                $q->where('name','like','%'.$usersearch.'%')->orWhere('email','like','%'.$usersearch.'%');
                                                            });
                                                        })
                                                        ->paginate(20);
        return view('auth.teacher.manage_student',compact('user','currentItem','listItems','usersearch'));
    }
    public function examResult(Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $listTeacherCourseId = $user->teacherCourses()->pluck('id');
        $activeCourseId = $request->course ?? null;
        $activeCourse = isset($activeCourseId) && $listTeacherCourseId->contains($activeCourseId) ? Course::find($activeCourseId):null;
        $listItems = ExamResult::with('course','exam','user')->whereHas('exam')
                                                            ->whereHas('course')
                                                            ->whereHas('user')
                                                            ->whereIn('course_id',$listTeacherCourseId)
                                                            ->orderBy('id','desc')
                                                            ->when(isset($activeCourseId) && $listTeacherCourseId->contains($activeCourseId),function($q) use ($activeCourseId) {
                                                                $q->where('course_id',$activeCourseId);
                                                            })
                                                            ->paginate(10);
        $listTeacherCousre = Course::act()->whereIn('id',$listTeacherCourseId)->get();
        return view('auth.teacher.student_exam_result',compact('user','currentItem','listItems','listTeacherCousre','activeCourseId','activeCourse'));
    }
}
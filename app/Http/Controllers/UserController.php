<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use stdClass;
use Support;

class UserController extends Controller
{
    public function view(Request $request)
    {
        $uSlug = \FCHelper::getSegment($request, 2);
        $userTeacher = User::with('gender','skills')
                            ->with(['teacherCourses'=>function($q){
                                $q->baseView();
                            }])
                            ->teacher()
                            ->where('uslug',$uSlug)
                            ->where('act',1)
                            ->where('banned',0)
                            ->first();
        if (!isset($userTeacher)) {
            return Support::redirectTo(\VRoute::get("home"),100,'Không tìm thấy tin giảng viên');
        }
        $currentItem = new stdClass;
        $currentItem->name = 'Giảng viên '.$userTeacher->name;
        $currentItem->slug = 'thong-tin-giang-vien/'.$uSlug;
        return view('users.teacher_profile',compact('userTeacher','currentItem'));
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use stdClass;

class UserController extends Controller
{
    public function view(Request $request)
    {
        $uSlug = \FCHelper::getSegment($request, 2);
        $userTeacher = User::with('gender','skills')
                            ->with(['course'=>function($q){
                                $q->baseView();
                            }])
                            ->teacher()
                            ->where('uslug',$uSlug)
                            ->where('act',1)
                            ->where('banned',0)
                            ->first();
        if (!isset($userTeacher)) {
            abort(404);
        }
        $currentItem = new stdClass;
        $currentItem->name = 'Giảng viên '.$userTeacher->name;
        $currentItem->slug = 'thong-tin-giang-vien/'.$uSlug;
        return view('users.teacher_profile',compact('userTeacher','currentItem'));
    }
}

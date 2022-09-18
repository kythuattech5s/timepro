<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Auth;
use Illuminate\Http\Request;
use Support;
class ManageUserCourseController extends Controller
{
    public function goLogin()
    {
        return Support::sendResponse(\VRoute::get("login"),100,'Vui lòng đăng nhập');
    }
    public function myCourse(Request $request)
    {
        if (!Auth::check()) {
            return $this->goLogin();
        }
        $user = Auth::user();
        $listUserCourseId = $user->userAllCourseId();
        $listItems = Course::baseView()->whereIn('id',$listUserCourseId)
                                        ->paginate(6);
        return view('auth.account.my_course',compact('user','listItems'));
    }
}

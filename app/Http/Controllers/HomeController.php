<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\CourseCategory;
use App\Models\User;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $listBanner = Banner::act()->ord()->get();
        $listCourseCategory = CourseCategory::act()->with(['course'=>function($q){
                                            $q->select('id','act')->act();
                                        }])->where('home',1)->ord()->limit(5)->get();
        $listTeacher = User::teacher()->where('act', 1)->where('banned', 0)->with('ratings')->with(['course'=>function($q){
                                                                            $q->select('id','act','duration','teacher_id')->act();
                                                                        }])->get();
        return view('home',compact('listBanner','listCourseCategory','listTeacher'));
    }
}

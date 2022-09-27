<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\CourseCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $listBanner = Cache::rememberForever('listHomeBanner', function () {
            return Banner::act()->ord()->get();
        });



        $listTeacher = Cache::rememberForever('listOurTeacher', function () {
            return User::teacher()->where('act', 1)->where('banned', 0)->with('ratings')->with(['teacherCourses' => function ($q) {
                $q->with('videos')->act();
            }])->get();
        });
        return view('home', compact('listBanner', 'listTeacher'));
    }

    public function getCategoryCourse(Request $request)
    {
        $listCourseCategory  = CourseCategory::act()->with(['course' => function ($q) {
            $q->with(['ratings', 'teacher', 'timePackage'])->select(['id', 'act', 'name', 'img', 'teacher_id', 'duration', 'ord', 'time_package', 'number_student', 'slug'])->act()->ord();
        }])->where('home', 1)->ord()->limit(5)->get();
        return response([
            'html' => view('components.list_category', compact('listCourseCategory'))->render()
        ]);
    }
}

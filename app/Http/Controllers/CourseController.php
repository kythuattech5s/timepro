<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Auth;
use Support;

class CourseController extends Controller
{
    public function view($request, $route, $link)
    {
        $video = request()->segment(2);
        $currentVideoId = request()->segment(3);
        $currentItem = Course::slug($link)->baseView()->with('timePackage')->act()->first();
        if ($currentItem == null) {
            abort(404);
        }
        $isOwn = $currentItem->isOwn(Auth::user());
        $listVideo = $currentItem->videos()->where('act',1)->get();
        if (isset($video)) {
            $videos = CourseVideo::with(['notes' => function ($q) {
                $q->where('user_id', \Auth::id());
            }])->where('course_id', $currentItem->id)->get();
            return view('courses.video', compact('videos', 'currentItem'));
        }
        $parent = $currentItem->category()->orderBy('id','desc')->first();
        $listRelateCourse = $currentItem->getRelatesCollection(4);
        return view('courses.view', compact('currentItem', 'parent','listRelateCourse','isOwn','listVideo'));
    }
}

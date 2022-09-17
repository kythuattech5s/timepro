<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use Tech5s\VideoChapter\Models\CourseVideo;

class CourseController extends Controller
{
    public function view($request, $route, $link)
    {
        $video = request()->segment(2);
        $currentItem = Course::slug($link)->with('timePackage')->act()->first();
        if ($currentItem == null) {
            abort(404);
        }
        if (isset($video)) {
            $videos = CourseVideo::with(['notes' => function ($q) {
                $q->where('user_id', \Auth::id());
            }])->where('course_id', $currentItem->id)->get();
            return view('courses.video', compact('videos', 'currentItem'));
        }
        $parent = $currentItem->category()->first();
        $parent = isset($parent) && \Support::show($parent, 'parent') == 0 ? $parent : CourseCategory::act()->where('parent', \Support::show($parent, 'parent'))->first();
        return view('courses.view', compact('currentItem', 'parent'));
    }
}

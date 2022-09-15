<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Tech5s\VideoChapter\Models\CourseVideo;

class CourseController extends Controller
{
    public function view(Request $request)
    {
        $slug = request()->segment(1);
        $video = request()->segment(2);

        $currentItem = Course::whereSlug($slug)->first();
        if ($currentItem  == null) {
            abort(404);
        }

        if (isset($video)) {
            $videos = CourseVideo::where('course_id', $currentItem->id)->get();

            return view('courses.video');
        }




        return view('course.view', compact('currentItem', 'videos'));
    }
}

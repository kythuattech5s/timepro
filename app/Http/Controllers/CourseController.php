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
            $videos = $listVideo;
            $mainVideo = $currentItem->videos()->find($currentVideoId);
            if (isset($mainVideo)) {
                if (!$isOwn && !$mainVideo->isFree()) {
                    return Support::redirectTo($link,100,'Vui lòng đăng ký khóa học để học bài này');
                }
                return view('courses.video', compact('videos','currentItem','isOwn','mainVideo'));
            }else{
                return Support::redirectTo($link,100,'Không tìm thấy thông tin video');
            }
        }
        $parent = $currentItem->category()->orderBy('id','desc')->first();
        $listRelateCourse = $currentItem->getRelatesCollection(4);
        return view('courses.view', compact('currentItem', 'parent','listRelateCourse','isOwn','listVideo'));
    }
}

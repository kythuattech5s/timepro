<?php

namespace App\Http\Controllers;

use App\Models\AskAndAnswer;
use App\Models\Course;
use App\Models\QuestionTeacher;
use Auth;
use modulevideosecurity\managevideo\Models\TvsSecret;
use Roniejisa\Comment\Models\Comment;
use Support;
use Tech5s\VideoChapter\Models\CourseVideo;

class CourseController extends Controller
{
    public function view($request, $route, $link)
    {
        $video = request()->segment(2);
        $currentVideoId = request()->segment(3);
        $currentItem = Course::slug($link)->baseView()->act()->first();
        if ($currentItem == null) {
            abort(404);
        }
        $isOwn = $currentItem->isOwn(Auth::user());
        if (isset($video)) {
            if (!$isOwn || Auth::user() == null) {
                return Support::redirectTo($currentItem->slug, 100, 'Vui lòng đăng ký khóa học để thực hiện hành động này!');
            }


            $videos = CourseVideo::with(['users' => function ($q) {
                $q->where('id', \Auth::id());
            }, 'notes' => function ($q) {
                $q->where('user_id', \Auth::id());
            }])->where('course_id', $currentItem->id)->where('act', 1)->orderBy('ord', 'ASC')->orderBy('id', 'ASC')->get();
            $listQuestions = QuestionTeacher::with(['questions' => function ($q) {
                $q->where('act', 1);
            }])->where('map_table', 'courses')->where('map_id', $currentItem->id)->where('act', 1)->paginate(5);
            // Chạy video mã hóa
            header('Access-Control-Allow-Origin: ' . asset('/'));
            header("X-Frame-Options: SAMEORIGIN");
            $videoFirst = null;
            if (request()->segment(3) != null) {
                $videoFirst = $videos->first(function ($q) {
                    return $q->id == request()->segment(3);
                });
            } else {
                $videoFirst = $videos[0];
            }
            $tvsMapItem = \Support::tvsMapItem('course_videos', 'source', \Support::show($videoFirst, 'id'));

            $secretId = 0;
            if ($tvsMapItem == null) {
                return Support::redirectTo($currentItem->slug, 100, 'Vui lòng đăng ký khóa học để thực hiện hành động này!');
            }
            $secret = TvsSecret::where('media_id', $tvsMapItem->video_media_map_id)
                ->where('converted', 2)
                ->first();
            if ($secret != null) {
                $secretId = $secret->id;
            }
            return view('courses.video', compact('videos', 'currentItem', 'isOwn', 'listQuestions', 'secretId', 'videoFirst', 'tvsMapItem'));
        }
        $comments = Comment::where('act', 1)->where('map_table', 'courses')->where('map_id', $currentItem->id)->whereNull('comment_id')->orderBy('id', 'DESC')->paginate(5);
        $listVideo = $currentItem->videos()->where('act', 1)->orderBy('ord', 'ASC')->orderBy('id', 'ASC')->get();
        $parent = $currentItem->category()->orderBy('id', 'desc')->first();
        $listRelateCourse = $currentItem->getRelatesCollection(4);
        $ratings = $currentItem->getRating();
        $asks = AskAndAnswer::with('likes')->where('map_id', $currentItem->id)->where('map_table', 'courses')->where('act', 1)->whereNull('ask_and_answer_id')->orderBy('id', 'DESC')->paginate(5);
        return view('courses.view', compact('currentItem', 'parent', 'listRelateCourse', 'isOwn', 'listVideo', 'comments', 'ratings', 'asks'));
    }
}

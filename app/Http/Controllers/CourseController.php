<?php

namespace App\Http\Controllers;

use App\Models\AskAndAnswer;
use App\Models\Course;
use App\Models\QuestionTeacher;
use Auth;
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
            if (!$isOwn) {
                return Support::redirectTo($currentItem->slug, 100, 'Vui lòng đăng ký khóa học để thực hiện hành động này!');
            }
            $videos = CourseVideo::with(['users'=>function($q){
                $q->where('id',\Auth::id());
            },'notes' => function ($q) {
                $q->where('user_id', \Auth::id());
            }])->where('course_id', $currentItem->id)->where('act',1)->orderBy('ord','ASC')->orderBy('id','ASC')->get();
            $listQuestions = QuestionTeacher::with(['questions' => function ($q) {
                $q->where('act', 1);
            }])->where('map_table', 'courses')->where('map_id', $currentItem->id)->where('act', 1)->paginate(5);
            return view('courses.video', compact('videos', 'currentItem', 'isOwn', 'listQuestions'));
        }
        $comments = Comment::where('act', 1)->where('map_table', 'courses')->where('map_id', $currentItem->id)->whereNull('comment_id')->orderBy('id', 'DESC')->paginate(5);
        $listVideo = $currentItem->videos()->where('act', 1)->orderBy('ord','ASC')->orderBy('id','ASC')->get();
        $parent = $currentItem->category()->orderBy('id', 'desc')->first();
        $listRelateCourse = $currentItem->getRelatesCollection(4);
        $ratings = $currentItem->getRating();
        $asks = AskAndAnswer::with('likes')->where('map_id', $currentItem->id)->where('map_table', 'courses')->where('act', 1)->whereNull('ask_and_answer_id')->orderBy('id', 'DESC')->paginate(5);
        return view('courses.view', compact('currentItem', 'parent', 'listRelateCourse', 'isOwn', 'listVideo', 'comments', 'ratings', 'asks'));
    }
}

<?php

namespace Tech5s\VideoChapter\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tech5s\VideoChapter\Models\CourseVideo;
use Tech5s\VideoChapter\Models\CourseVideoNote;

class VideoController extends Controller
{
    public function note(Request $request)
    {
        if (!\Auth::check()) {
            return response([
                'code' => 100,
                'message' => 'Vui lòng đăng nhập để thực hiện hành động này'
            ]);
        }

        $note = new CourseVideoNote();
        $note->course_video_id = $request->input('course_video_id');
        $note->content = $request->input('content');
        $note->user_id = \Auth::id();
        $note->time = $request->input('time');
        $note->save();

        return response([
            'code' => 200,
            'message' => 'Ghi chú thành công'
        ]);
    }

    public function getListNote(Request $request)
    {
        $videoFirst = CourseVideo::with('notes')->find($request->input('course_video_id'));
        return response([
            'code' => 100,
            'html' => view('courses.components.list_note', compact('videoFirst'))->render()
        ]);
    }

    public function markVideoDone(Request $request)
    {
        $course_video_done = \DB::table('course_video_user')->where('user_id', \Auth::id())->where('course_video_id', $request->input('course_video_id'))->first();
        if ($course_video_done == null) {
            \DB::table('course_video_user')->insert([
                'course_video_id' => $request->input('course_video_id'),
                'user_id' => \Auth::id()
            ]);
        }
        return response([
            'code' => 200,
            'message' => 'Thành công'
        ]);
    }
}

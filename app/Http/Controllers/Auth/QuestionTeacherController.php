<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\QuestionTeacher;
use Auth;
use Illuminate\Http\Request;

class QuestionTeacherController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            return redirect()->to('/')->with('typeNotify', 100)->with('messageNotify', 'Vui lòng đăng nhập để thực hiện chức năng này')->send();
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->isAccount()) {
            $courses = Course::whereHas('questions',  function ($q) {
                $q->with('questions')->where('user_id', Auth::id())->whereNull('question_teacher_id');
            });
            $courses->with(['questions' =>  function ($q) {
                $q->with(['questions' => function ($q) {
                    $q->with('user');
                }, 'user'])->where('user_id', Auth::id())->whereNull('question_teacher_id');
            }]);
        } else {
            $courses = Course::where('teacher_id', Auth::id());
            $courses->with(['questions' => function ($q) {
                $q->with(['questions' => function ($q) {
                    $q->with('user');
                }, 'user']);
            }]);
        }

        $courses->when($request->input('q'), function ($q, $keyword) {
            $q->where('content', 'LIKE', '%' . $keyword . '%');
        });

        $courses = $courses->get();
        return view('auth.teacher.question', compact('courses', 'user'));
    }
}

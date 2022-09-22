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

    public function index()
    {
        $user = Auth::user();
        if ($user->isAccount()) {
            $cources = Course::whereHas('questions',  function ($q) {
                $q->where('user_id', Auth::id());
            })->get();
        } else {
            $cources = Course::where('teacher_id', Auth::id())->get();
        }
        return view('auth.teacher.question', compact('cources', 'user'));
    }
}

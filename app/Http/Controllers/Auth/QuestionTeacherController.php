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
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $cources = Course::where('teacher_id', Auth::id())->get();
        return view('auth.teacher.question', compact('cources','user'));
    }
}

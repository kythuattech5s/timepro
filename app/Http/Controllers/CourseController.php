<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;

class CourseController extends Controller
{
    public function view($request, $route, $link){
        $currentItem = Course::slug($link)->with('timePackage')->act()->first();
        if ($currentItem == null) { 
            abort(404); 
        }
        $parent = $currentItem->category()->first();
        $parent = isset($parent) && \Support::show($parent,'parent') == 0 ? $parent:CourseCategory::act()->where('parent',\Support::show($parent,'parent'))->first();
        return view('courses.view',compact('currentItem','parent'));
    }
}

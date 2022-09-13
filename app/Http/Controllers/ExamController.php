<?php
namespace App\Http\Controllers;
use App\Models\Exam;
use App\Models\ExamCategory;
class ExamController extends Controller
{
    public function view($request, $route, $link){
        $currentItem = Exam::slug($link)->with(['pivotQuestion'=>function($q){
                                            $q->orderBy('ord','asc')->whereHas('question')->with(['question'=>function($q){
                                                $q->with('questionType');
                                            }]);
                                        }])->act()->first();
        if ($currentItem == null) { 
            abort(404); 
        }
        $parent = $currentItem->category()->first();
        $parent = isset($parent) && \Support::show($parent,'parent') == 0 ? $parent:ExamCategory::act()->where('parent',\Support::show($parent,'parent'))->first();
        return view('exams.view',compact('currentItem','parent'));
    }
}

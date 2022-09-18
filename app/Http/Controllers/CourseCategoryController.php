<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
class CourseCategoryController extends Controller
{
    public function all($request, $route, $link)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $type = \FCHelper::getSegment($request, 2);
        $type = $type == '' ? 'new':$type;
        switch ($type) {
            case 'khoa-hoc-dang-hot':
                $listItems = Course::baseView()->orderBy('number_student','desc')->orderBy('id','desc')->paginate(20);
                $currentItem->vi_name = $currentItem->vi_name.' - Khóa học đang hot';
                $currentItem->vi_seo_title = $currentItem->vi_seo_title.' - Khóa học đang hot';
                $currentItem->vi_seo_key = $currentItem->vi_seo_key.' - Khóa học đang hot';
                $currentItem->vi_seo_des = $currentItem->vi_seo_des.' - Khóa học đang hot';
                break;
            case 'goi-y-cho-ban':
                $listItems = Course::baseView()->orderBy('id','desc')->paginate(20);
                $currentItem->vi_name = $currentItem->vi_name.' - Gợi ý cho bạn';
                $currentItem->vi_seo_title = $currentItem->vi_seo_title.' - Gợi ý cho bạn';
                $currentItem->vi_seo_key = $currentItem->vi_seo_key.' - Gợi ý cho bạn';
                $currentItem->vi_seo_des = $currentItem->vi_seo_des.' - Gợi ý cho bạn';
                break;
            default:
                $listItems = Course::baseView()->orderBy('id','desc')->paginate(20);
                $currentItem->vi_name = $currentItem->vi_name.' - Khóa học mới';
                $currentItem->vi_seo_title = $currentItem->vi_seo_title.' - Khóa học mới';
                $currentItem->vi_seo_key = $currentItem->vi_seo_key.' - Khóa học mới';
                $currentItem->vi_seo_des = $currentItem->vi_seo_des.' - Khóa học mới';
                break;
        }
        return view('course_categories.all', compact('currentItem','type','listItems'));
    }
    public function view($request, $route, $link)
    {
        $currentItem = CourseCategory::slug($link)->act()->first();
        if ($currentItem == null) {
            abort(404);
        }
        $listItems = $currentItem->course()->baseView()->orderBy('id','desc')->paginate(20);
        return view('course_categories.view', compact('currentItem','listItems'));
    }
}

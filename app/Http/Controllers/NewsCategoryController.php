<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{NewsCategory,News};
use Support;
class NewsCategoryController extends Controller
{
    public function view($request, $route, $link){
    	$currentItem = NewsCategory::slug($link)->act()->first();
    	if ($currentItem == null) {
    		abort(404);
    	}
    	$listItems = $currentItem->news()->act()->ord()->paginate(12);
        $parent = $currentItem->parent==0||$currentItem->parent==''?$currentItem:NewsCategory::act()->where('parent',$currentItem->parent)->first();
        $listCate = $currentItem->parent==0||$currentItem->parent==''?NewsCategory::act()->where('parent',$currentItem->id)->get():NewsCategory::act()->where('parent',$currentItem->parent)->get();
        $newsHighViews = News::act()->orderBy('count','desc')->take(9)->get();
        $listAllNewsCategory = NewsCategory::act()->get();
    	return view('news_categories.view', compact('currentItem', 'listItems','parent','newsHighViews','listCate','listAllNewsCategory'));
    }
}
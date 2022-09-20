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
    	$listItems = $currentItem->news()->act()->ord()->orderBy('hot','desc')->paginate(10);
        $newsHighViews = News::act()->orderBy('count','desc')->take(5)->get();
        $listNewsNew = News::act()->orderBy('created_at','desc')->take(5)->get();
        $listAllNewsCategory = NewsCategory::act()->where('parent',0)->ord()->get();
        $listNewsSale = News::act()->where('sale',1)->ord()->take(4)->get();
        $table = 'news_categories';
    	return view('news_categories.view', compact('currentItem', 'listItems','newsHighViews','listNewsNew','listAllNewsCategory','table','listNewsSale'));
    }
}
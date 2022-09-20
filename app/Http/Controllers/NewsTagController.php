<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{News,NewsTag};
class NewsTagController extends Controller{
	public function view($request, $route, $link){
    	$currentItem = NewsTag::slug($link)->act()->ord()->first();
    	if ($currentItem == null) {
    		abort(404);
    	}
        $listNewsSale = News::act()->where('sale',1)->ord()->take(4)->get();
    	$listItems = $currentItem->news()->ord()->paginate(10);
        $newsHighViews = News::act()->orderBy('count','desc')->take(5)->get();
        $listNewsNew = News::act()->orderBy('created_at','desc')->take(5)->get();
    	return view('news_tags.view', compact('currentItem', 'listItems','listNewsSale','newsHighViews','listNewsNew'));
    }
}
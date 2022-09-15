<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{News,NewsCategory};
class NewsController extends Controller
{	
    public function view($request, $route, $link){
        $currentItem = News::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        $currentItem->load(['category'=>function($q){
            $q->act();
        },'tags']);
        $parent = $currentItem->category->first();
        $parent = isset($parent) && \Support::show($parent,'parent') == 0?$parent:NewsCategory::act()->where('parent',\Support::show($parent,'parent'))->first();
        $newsRelateds = $currentItem->getRelatesCollection();
        $newsHighViews = News::act()->orderBy('count','desc')->take(9)->get();
        $listAllNewsCategory = NewsCategory::act()->ord()->get();
        $tags = $currentItem->tags;
        $this->updateCountViewed($currentItem);
        return view('news.view',compact('currentItem','newsRelateds','newsHighViews','parent','listAllNewsCategory','tags'));
    }
    
	public function all($request,$route,$link){
        $listItems = News::act()->ord()->paginate(12);
        $listAllNewsCategory = NewsCategory::act()->where('parent',0)->ord()->get();
        $newsHighViews = News::act()->orderBy('count','desc')->take(9)->get();
        return view('news.all',compact('listItems','listAllNewsCategory','newsHighViews'));
    } 
    public function updateCountViewed($currentItem) {
        $currentItem->count = $currentItem->count + 1;
        $currentItem->save();
    }
    
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{News,NewsCategory,Course};
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
        $listNewsSale = News::act()->where('sale',1)->ord()->take(4)->get();
        $listAllNewsCategory = NewsCategory::act()->ord()->get();
        $products = Course::act()->take(4)->get();
        $tags = $currentItem->tags;
        $table = 'news';
        $this->updateCountViewed($currentItem);
        return view('news.view',compact('currentItem','newsRelateds','listNewsSale','parent','listAllNewsCategory','products','tags','table'));
    }
    
	public function all($request,$route,$link){
        $listItems = News::act()->ord()->paginate(10);
        $newsHighViews = News::act()->orderBy('count','desc')->take(5)->get();
        $listNewsNew = News::act()->orderBy('created_at','desc')->take(5)->get();
        $listAllNewsCategory = NewsCategory::act()->where('parent',0)->ord()->get();
        $table = 'news_categories';
        return view('news.all',compact('listItems','newsHighViews','listNewsNew','listAllNewsCategory','table'));
    } 
    public function updateCountViewed($currentItem) {
        $currentItem->count = $currentItem->count + 1;
        $currentItem->save();
    }
    
}

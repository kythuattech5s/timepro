<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
class SearchController extends Controller
{
    public function search(Request $request, $route, $link){
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $keySeach = $request->q ?? '';
        $listItems = Course::baseView()->where('name','like','%'.$keySeach.'%')->orderBy('id','desc')->paginate(20);
        return view('searchs.view',compact('currentItem','listItems','keySeach'));
    }
}
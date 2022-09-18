<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use vanhenry\helpers\helpers\SettingHelper;
use App\Models\{Page};

class StaticController extends Controller
{
    public function contact($request, $route, $link){
        return view('pages.contact');
    }

    public function introduce($request, $route, $link){
        return view('pages.introduce');
    }

    public function normal($request, $route, $link){
    	$currentItem = Page::slug($link)->act()->first();
        if ($currentItem == null) { abort(404); }
        return view('pages.normal',compact('currentItem'));
    }
}
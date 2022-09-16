<?php
namespace App\Http\Controllers;

use App\Models\CourseCombo;
use App\Models\CourseComboTimePackage;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {
        // $itemBuy = CourseCombo::find(2);
        // $itemTimePackage = CourseComboTimePackage::find(1);
        // \Tech5sCart::instance('vip');
        // \Tech5sCart::add($itemBuy->id,$itemBuy->name,1,$itemTimePackage->price,0,$itemTimePackage->toArray());
        return view('home');
    }
}

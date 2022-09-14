<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {
        // \App\Models\OrderCourse::find(1)->orderSuccess();
        return view('home');
    }
}

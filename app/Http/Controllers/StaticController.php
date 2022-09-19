<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use vanhenry\helpers\helpers\SettingHelper;
use App\Models\{Page};
use Support;
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
    public function getLastDateOfMonth(){
        $year = request()->input('year','2022');
        $month = request()->input('month','1');
        $day = request()->input('day','0');
        $time = strtotime($year.'-'.$month.'-'.'1');
        $month_end = strtotime('last day of this month', $time);
        $dateLastMonth = date('d',$month_end);
        $html = '';
        for($i = 0;$i < $dateLastMonth+1;$i++){
            $selected = $i==$day?'selected':'';
            if($i == 0){
                $html .= '<option value="'.$i.'">Ngày</option>';
            }
            else{
                $html .= '<option value="'.$i.'" '.$selected.'>Ngày '.$i.'</option>';
            }
        }
        return response()->json(['code'=>200,'message'=>'Thành Công','html'=>$html]);
    }

    public function getDistrictByProvince(){
        $provinceId = request()->input('province_id',0);
        $districtId = request()->input('district_id',0);
        $districts = \App\Models\District::where('province_id',$provinceId)->get();
        $html = '<option>Quận/Huyện</option>';
        foreach ($districts as $item) {
            $selected = $districtId == Support::show($item,'id')?'selected':'';
            $html .= '<option value="'.Support::show($item,'id').'"'.$selected.'>'.Support::show($item,'name').'</option>';
        }
        return response()->json(['code'=>200,'message'=>'Thành công','html'=>$html]);
    }

    public function getWardByDistrict(){
        $districtId = request()->input('district_id');
        $wardId = request()->input('ward_id',0);
        $wards = \App\Models\Ward::where('district_id',$districtId)->get();
        $html = '<option>Phường/Xã</option>';
        foreach ($wards as $item) {
            $selected = $wardId == Support::show($item,'id')?'selected':'';
            $html .= '<option value="'.Support::show($item,'id').'" '.$selected.'>'.Support::show($item,'name').'</option>';
        }
        return response()->json(['code'=>200,'message'=>'Thành công','html'=>$html]);
    }
}
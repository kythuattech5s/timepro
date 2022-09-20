<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use vanhenry\helpers\helpers\SettingHelper;
use App\Models\{Page,Contact,News};
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

    public function sendContact($request){
        if (cache()->get('contact_' . session()->getId()) == 1) {
            return response([
                'code' => 100,
                'message' => 'Chúng tôi đã nhận được yêu cầu của bạn!',
            ]);
        }
        $contact = new Contact();
        if($request->input('email') != ''){
            $contact->email = $request->input('email');
        }
        if($request->input('name') != ''){
            $contact->name = $request->input('name');
        }
        if($request->input('phone') != ''){
            $contact->phone = $request->input('phone');
        }
        if($request->input('note') != ''){
            $contact->note = $request->input('note');
        }
        $contact->save();
        cache()->remember('contact_' . session()->getId(), 600, function () {
            return 1;
        });
        return response([
            'code' => 200,
            'message' => 'Đã gửi thông tin liên hệ thành công',
        ]);
    }

    public function searchNews($request){
        $keyword = $request->input('keyword');
        $listItems = News::act();
        if($keyword != ''){
            $listItems = $listItems->where('name','like',$keyword);
        }
        $listItems =  $newlistItemss->pagination(10);
        return view('news.search',compact('listItems'));
    }

}
<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCombo;
use App\Models\CourseComboTimePackage;
use App\Models\CourseTimePackage;
use App\Models\PaymentMethod;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Support;
use Tech5sCart;

class CartController extends Controller
{
    protected $cartInstance = ['course','vip'];
    public function action(Request $request,$action)
    {
        switch ($action) {
            case 'add':
                return $this->addItemCart($request);
                break;
            case 'get-count':
                return $this->getCountItemCart($request);
                break;
            case 'delete-item':
                return $this->deleteItemCart($request);
                break;
            default:
                return response()->json([
                    'code' => 100,
                    'message' => 'Không thể thực hiện hành động này'
                ]);
                break;
        }
    }
    protected function _resetQtyItemCart($newItem){
        foreach (Tech5sCart::content() as $item) {
            if ($item->id == $newItem->id && $item->rowId != $newItem->rowId) {
                Tech5sCart::update($item->rowId,0,false);
            }else{
                Tech5sCart::update($item->rowId,1,false);
            }
        }
        Tech5sCart::store();
    }
    protected function validatorAddCartItem(array $data)
    {
        return Validator::make($data, [
            'action' => ['in:buy-now,add-cart'],
            'type' => ['in:'.implode(',',$this->cartInstance)],
            'id' => ['required'],
            'package' => ['required'],
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'in' => 'Dữ liệu không hợp lệ',
        ], [
            'action' => 'Hành động',
            'type' => 'Loại',
            'id' => 'Item',
            'package' => 'Gói',
        ]);
    }
    protected function addItemCart($request){
        $validator = $this->validatorAddCartItem($request->all());
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first()
            ]);
        }
        switch ($request->type) {
            case 'course':
                $itemBuy = Course::find($request->id);
                break;
            case 'vip':
                $itemBuy = Course::find($request->id);
                break;
            default:
                return response()->json([
                    'code' => 100,
                    'message' => 'Không tìm thấy thông tin sản phẩm'
                ]);
                break;
        }
        if (!isset($itemBuy)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin sản phẩm'
            ]);
        }
        $itemTimePackage = $itemBuy->timePackage()->select('id','name','price','price_old','description','number_day','is_forever')->find($request->package);
        if (!isset($itemTimePackage)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin sản phẩm'
            ]);
        }
        Tech5sCart::instance($request->type);
        $newItem = Tech5sCart::add($itemBuy->id,$itemBuy->name,1,$itemTimePackage->price,0,$itemTimePackage->toArray());
        $this->_resetQtyItemCart($newItem);
        switch ($request->action) {
            case 'buy-now':
                return response()->json([
                    'code' => 200,
                    'message' => 'Thêm vào giỏ hàng thành công',
                    'redirect_url' => 'thanh-toan'
                ]);
                break;
            default:
                return response()->json([
                    'code' => 200,
                    'message' => 'Thêm vào giỏ hàng thành công'
                ]);
                break;
        }
    }
    protected function deleteItemCart($request){
        $instance = $request->instance ?? '';
        $row = $request->row ?? '';
        if (!in_array($instance,$this->cartInstance)) {
            return response()->json([
                'code' => 100,
                'message' => 'Dữ liệu không hợp lệ'
            ]); 
        }
        Tech5sCart::instance($instance);
        try {
            Tech5sCart::remove($row);
            Tech5sCart::store();
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 100,
                'message' => 'Dữ liệu không hợp lệ'
            ]); 
        }
        return response()->json([
            'code' => 200,
            'message' => 'Cập nhật giỏ hàng thành công'
        ]); 
    }
    protected function getCountItemCart($request){
        $ret = 0;
        foreach ($this->cartInstance as $itemCartInstance) {
            Tech5sCart::instance($itemCartInstance);
            $ret += Tech5sCart::countItems();
        }
        return response()->json([
            'code' => 200,
            'count' => $ret
        ]); 
    }
    public function view(Request $request,$route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $listItems = [];
        $totalMoney = 0;
        $listCourseId = [];
        $listCourseCategoryId = collect();
        foreach ($this->cartInstance as $itemCartInstance) {
            Tech5sCart::instance($itemCartInstance);
            $instanceContent = Tech5sCart::content();
            foreach ($instanceContent as $item) {
                switch ($itemCartInstance) {
                    case 'course':
                        $realItem = Course::baseView()->with('category')->find($item->id);
                        $itemTimePackage = CourseTimePackage::find($item->options->id ?? 0);
                        array_push($listCourseId,$item->id);
                        if (isset($realItem) && count($realItem->category) > 0) {
                            $listCourseCategoryId = $listCourseCategoryId->merge($realItem->category->pluck('id'));
                        }
                        break;
                    case 'vip':
                        $realItem = CourseCombo::baseView()->find($item->id);
                        $itemTimePackage = CourseComboTimePackage::find($item->options->id ?? 0);
                        break;
                    default:
                        $realItem = null;
                        break;
                }
                if (isset($realItem) && isset($itemTimePackage)) {
                    $item->instance = $itemCartInstance;
                    $item->realItem = $realItem;
                    $item->itemTimePackage = $itemTimePackage;
                    $totalMoney += $item->price;
                    array_push($listItems,$item);
                }else{
                    Tech5sCart::update($item->rowId,0);
                }
            }
        }
        $listCourseCategoryId = $listCourseCategoryId->unique();
        if (count($listCourseCategoryId) > 0) {
            $listRelateCourse = Course::baseView()->whereHas('category',function($q) use ($listCourseCategoryId){
                                                    $q->whereIn('id',$listCourseCategoryId);
                                                })
                                                ->whereHas('timePackage')
                                                ->whereNotIn('id',$listCourseId)
                                                ->limit(10)
                                                ->get();
        } else{
            $listRelateCourse = Course::baseView()->whereNotIn('id',$listCourseId)
                                                ->whereHas('timePackage')
                                                ->inRandomOrder()
                                                ->limit(10)
                                                ->get();
        }
        
        return view('carts.view',compact('listItems','currentItem','totalMoney','listRelateCourse'));
    }
    public function viewPayment(Request $request,$route)
    {
        if (!Auth::check()) {
            return Support::redirectTo(\VRoute::get("login"),200,'Vui lòng đăng nhập.');
        }
        $user = Auth::user();
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $listItems = [];
        $totalMoney = 0;
        foreach ($this->cartInstance as $itemCartInstance) {
            Tech5sCart::instance($itemCartInstance);
            $instanceContent = Tech5sCart::content();
            foreach ($instanceContent as $item) {
                switch ($itemCartInstance) {
                    case 'course':
                        $realItem = Course::baseView()->with('category')->find($item->id);
                        $itemTimePackage = CourseTimePackage::find($item->options->id ?? 0);
                        break;
                    case 'vip':
                        $realItem = CourseCombo::baseView()->find($item->id);
                        $itemTimePackage = CourseComboTimePackage::find($item->options->id ?? 0);
                        break;
                    default:
                        $realItem = null;
                        break;
                }
                if (isset($realItem) && isset($itemTimePackage)) {
                    $item->instance = $itemCartInstance;
                    $item->realItem = $realItem;
                    $item->itemTimePackage = $itemTimePackage;
                    $totalMoney += $item->price;
                    array_push($listItems,$item);
                }else{
                    Tech5sCart::update($item->rowId,0);
                }
            }
        }
        $listPaymentMethod = PaymentMethod::act()->orderBy('ord','asc')->get();
        return view('carts.view_payment',compact('listItems','currentItem','totalMoney','user','listPaymentMethod'));
    }
}

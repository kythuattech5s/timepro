<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tech5sCart;

class CartController extends Controller
{
    public function action(Request $request,$action)
    {
        switch ($action) {
            case 'add':
                return $this->addItemCart($request);
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
            'type' => ['in:course,vip'],
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
}

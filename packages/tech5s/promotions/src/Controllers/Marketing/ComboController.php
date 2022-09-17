<?php

namespace Tech5s\Promotion\Controllers\Marketing;

use Illuminate\Http\Request;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\ComboContruct;

class ComboController extends MarketingController
{
    public function showFormAdd()
    {
        $item = new ComboContruct;
        $item->flush();
        $promotion = 'combos';
        $action = 'create';
        return view('tech5spromotion::marketing.combos.add', compact('action', 'promotion'));
    }

    public function create(Request $request)
    {

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }

        $item = new ComboContruct;
        $item->setDataCombo();
        $messageCheckTime = $item->checkTimeCreate();
        if ($messageCheckTime) {
            return response([
                'code' => 100,
                'message' => $messageCheckTime,
            ]);
        }
        $messageCheckProduct = $item->checkProduct();
        if ($messageCheckProduct) {
            return response([
                'code' => 100,
                'message' => $messageCheckProduct,
            ]);
        }
        $item->saveCombo();
        return response([
            'code' => 200,
            'message' => 'Tạo combo khuyến mãi thành công',
            'redirect_url' => base64_decode($request->input('returnurl', base64_encode(url('esystem/view/combos')))),
        ]);
    }

    public function changeAct(Request $request)
    {
        try {
            $item = new ComboContruct();
            foreach ($request->id as $id) {
                $data = [
                    'id' => $id,
                    'act' => 1,
                ];
                if ((int) $request->input('act') === 1) {
                    $item->setProductReal($data);
                    $item->removeProductNoActive($id);
                } else {
                    $item->removeProductReal($id);
                }
            }
            $item->saveProductNoActive();
            $item->saveProductReal();
            return response([
                'code' => 200,
            ]);
        } catch (\Exception $err) {
            return response([
                'code' => 100,
            ]);
        }
    }

    public function removeItem(Request $request)
    {
        // try {
        $item = new ComboContruct();
        foreach ($request->id as $id) {
            $item->removeProductReal($id);
            $item->removeProductNoActive($id);
            $item->removeProduct($id);
            $item->checkRemoveItemDB($id);
        }
        $item->saveProductNoActive();
        $item->saveProductReal();
        $item->saveProduct();
        return response([
            'code' => 200,
        ]);
        // } catch (\Exception $err) {
        //     return response([
        //         'code' => 100
        //     ]);
        // }
    }

    private function validator(array $data)
    {
        return \Validator::make($data, [
            "name" => 'required',
            "start_at" => 'required',
            "expired_at" => 'required',
            "discount" => 'required|integer',
            "type" => 'required',
            "qty" => 'required|integer|min:2',
            "limit" => 'required|integer|min:1',
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'unique' => ':attribute đã được sử dụng',
            'integer' => ':attribute phải là số nguyên',
            'min' => ':attribute phải lớn hơn hoặc bằng :min',
        ], [
            "name" => 'Tên',
            "start_at" => 'Thời gian bắt đầu',
            "expired_at" => 'Thời gian kết thúc',
            "discount" => 'Discount',
            "limit" => 'Lượt sử dụng',
            "qty" => 'Số lượng',
            "type" => 'Loại combo',
        ]);
    }

    public function showFormEdit(Request $request, $id)
    {
        $action = 'edit';
        $promotion = 'combos';
        $item = new ComboContruct($id);
        $products = $item->product_current;
        $product_checked = $item->product_real->pluck('id');
        $currentItem = $item->combo;
        $item->saveProduct();
        $item->saveProductCurrent();
        $item->saveProductNoActive();
        $item->saveProductReal();
        $item->saveSessionCombo();
        return view('tech5spromotion::marketing.combos.edit', compact('action', 'promotion', 'products', 'currentItem', 'product_checked'));
    }

    public function update(Request $request, $id)
    {
        $item = new ComboContruct($id, true);
        $item->setDataUpdate();
        $messageCheckProduct = $item->checkProduct();
        if ($messageCheckProduct) {
            return response([
                'code' => 100,
                'message' => $messageCheckProduct,
            ]);
        }
        $messageCheckTimeUpdate = $item->checkTimeUpdate();
        if ($messageCheckTimeUpdate) {
            return response([
                'code' => 100,
                'message' => $messageCheckTimeUpdate,
            ]);
        }
        $item->saveCombo();
        return response([
            'code' => 200,
            'message' => 'Cập nhật combo khuyến mãi thành công',
            'redirect_url' => base64_decode($request->input('returnurl', base64_encode(url('esystem/view/combos')))),
        ]);
    }

    public function showFormCopy(Request $request, $id)
    {
        $action = 'copy';
        $promotion = 'combos';
        $item = new ComboContruct($id);
        $products = $item->product_current;
        $product_checked = $item->product_real->pluck('id');
        $currentItem = $item->combo;
        $item->saveProduct();
        $item->saveProductCurrent();
        $item->saveProductNoActive();
        $item->saveProductReal();
        return view('tech5spromotion::marketing.combos.copy', compact('action', 'promotion', 'products', 'currentItem', 'product_checked'));
    }
}

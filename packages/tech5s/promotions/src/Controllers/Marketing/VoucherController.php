<?php

namespace Tech5s\Promotion\Controllers\Marketing;

use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\VoucherContruct;
use App\Models\NotificationType;
use Tech5s\Promotion\Models\Voucher;
use vanhenry\helpers\helpers\FCHelper;
use VoucherHelper;

class VoucherController extends MarketingController
{
    public function showFormAddVoucher()
    {
        $item = new VoucherContruct();
        $item->flush();
        $promotion = 'vouchers';
        $action = 'create';
        return view('tech5spromotion::marketing.vouchers.add', compact('action', 'promotion'));
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

        $voucher = new VoucherContruct;
        $voucher->setDataVoucher();

        $messageTimeCheck = $voucher->checkTimeCreate();
        if ($messageTimeCheck) {
            return response([
                'code' => 100,
                'message' => $messageTimeCheck,
            ]);
        }

        $messageCheckCodeType = $voucher->checkCodeType();
        if ($messageCheckCodeType) {
            return response([
                'code' => 100,
                'message' => $messageCheckCodeType,
            ]);
        }

        $messageCheckDiscount = $voucher->checkDiscountVoucher();
        if ($messageCheckDiscount) {
            return response([
                'code' => 100,
                'message' => $messageCheckDiscount,
            ]);
        }

        $voucher->setImg('img', 'voucher');
        $voucher->saveVoucher();

        $messageCreateProduct = $voucher->createProductVoucher();
        if ($messageCreateProduct) {
            return response([
                'code' => 100,
                'message' => $messageCreateProduct,
            ]);
        }

        return response([
            'code' => 200,
            'message' => 'Tạo mã giảm giá thành công',
            'redirect_url' => base64_decode($request->input('returnurl')),
        ]);
    }

    public function editFormVoucher(Request $request, $id)
    {
        $promotion = 'vouchers';
        $action = 'edit';
        $currentItem = Voucher::find($id);
        $lock = false;
        if (new \DateTime($currentItem->start_at) < new DateTime()) {
            $lock = true;
        }
        $code = \Str::replace(VoucherHelper::PREFIX_CODE, '', $currentItem->code);
        $products = $currentItem->products;
        if ($products->count() > 0) {
            session()->put(VoucherContruct::PREFIX_SESSION_PRODUCT, $products->pluck('id'));
        } else {
            session()->put(VoucherContruct::PREFIX_SESSION_PRODUCT, collect());
        }
        return view('tech5spromotion::marketing.vouchers.edit', compact('currentItem', 'products', 'code', 'lock', 'promotion', 'action'));
    }

    public function copyFormVoucher(Request $request, $id)
    {
        $promotion = 'vouchers';
        $action = 'copy';
        $currentItem = Voucher::find($id);
        $code = \Str::replace(VoucherHelper::PREFIX_CODE, '', $currentItem->code);
        $products = $currentItem->products;
        if ($products->count() > 0) {
            session()->put(VoucherContruct::PREFIX_SESSION_PRODUCT, $products->pluck('id'));
        } else {
            session()->put(VoucherContruct::PREFIX_SESSION_PRODUCT, collect());
        }
        return view('tech5spromotion::marketing.vouchers.copy', compact('currentItem', 'products', 'code', 'promotion', 'action'));
    }

    public function update(Request $request, $id)
    {
        $voucher = new VoucherContruct($id);
        $voucher->setDataVoucher();
        $messageCheckTimeUpdate = $voucher->checkTimeUpdate();
        if ($messageCheckTimeUpdate) {
            return response([
                'code' => 100,
                'message' => $messageCheckTimeUpdate,
            ]);
        }

        $messageCheckCodeType = $voucher->checkCodeType();
        if ($messageCheckCodeType) {
            return response([
                'code' => 100,
                'message' => $messageCheckCodeType,
            ]);
        }

        $messageCheckDiscount = $voucher->checkDiscountVoucher();
        if ($messageCheckDiscount) {
            return response([
                'code' => 100,
                'message' => $messageCheckDiscount,
            ]);
        }

        $voucher->setImg('img', 'voucher');
        $voucher->saveVoucher();

        $messageCreateProduct = $voucher->createProductVoucher();
        if ($messageCreateProduct) {
            return response([
                'code' => 100,
                'message' => $messageCreateProduct,
            ]);
        }

        return response([
            'code' => 200,
            'message' => 'Cập nhật mã giảm giá thành công',
            'redirect_url' => base64_decode($request->input('returnurl')),
        ]);
    }

    public function removeProduct(Request $request)
    {
        $products = session()->get(VoucherContruct::PREFIX_SESSION_PRODUCT);
        $products = $products->filter(function ($value) use ($request) {
            return (int) $value !== (int) $request->input('product_id');
        });
        session()->put(VoucherContruct::PREFIX_SESSION_PRODUCT, $products);

        return response([
            'code' => 200,
            'count' => $products->count(),
        ]);
    }

    private function validator(array $data)
    {
        $data['code'] = VoucherHelper::PREFIX_CODE . $data['code'];
        return \Validator::make($data, [
            "code_type" => 'required',
            "name" => 'required',
            "code" => 'required|unique:vouchers',
            "start_at" => 'required',
            "expired_at" => 'required',
            "voucher_type" => 'required',
            "type_discount" => 'required',
            "discount" => 'required',
            "max_discount" => 'integer|min:1000',
            "minimum_apply_voucher" => 'required|integer|min:0',
            "limit" => 'required|integer|min:1',
            "is_public" => 'required',
            'condition_receive' => 'required|integer|min:0',
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'unique' => ':attribute đã được sử dụng',
            'integer' => ':attribute phải là số nguyên',
            'min' => ':attribute phải lớn hơn hoặc bằng :min',
        ], [
            "condition_receive" => 'Điều kiện để được nhận mã giảm giá',
            "code_type" => 'Loại mã',
            "name" => 'Tên',
            "code" => 'Mã giảm giá',
            "start_at" => 'Thời gian bắt đầu',
            "expired_at" => 'Thời gian kết thúc',
            "voucher_type" => 'Loại khuyến mãi',
            "type_discount" => 'Loại hạ giá',
            "discount" => 'Discount',
            "max_discount" => 'Mức giảm tối đa',
            "minimum_apply_voucher" => 'Giá tối thiểu để được áp dụng mã giảm giá',
            "limit" => 'Lượt sử dụng',
            "is_public" => 'Công khai',
        ]);
    }

    //Gửi thông báo voucher cho khách

    public function showFormSendVoucher(Request $request, $id)
    {
        $voucher = Voucher::find($id);
        $users = User::select(['id', 'name', 'email', 'phone'])->get();
        return view('tech5spromotion::marketing.vouchers.send-voucher', compact('voucher', 'users'));
    }

    public function sendVoucher(Request $request)
    {
        $voucher = Voucher::find($request->input('voucher_id'));
        if ($request->input('id') !== null) {
            $users = User::find($request->id);
        } else {
            $users = User::all();
        }
        foreach ($users as $user) {
            $type = NotificationType::NOTIFICATION_VOUCHER;

            $types = $user->notificationTypes->filter(function($q) use($type){
                return $q->id == $type;
            });

            if($types->count() == 0){
                continue;
            }
            
            $data = [
                'title' => 'Có 1 voucher mới cho bạn!',
                'body' => 'Mã giảm giá ' . $voucher->getNameShowUser() . ' cho đơn hàng từ ' . ($voucher->minimum_apply_voucher > 0 ? $voucher->minimum_apply_voucher / 1000 : 0) . 'k nằm trong ví voucher của bạn! 💥. Hiệu lực: từ ' . date("H:i:s d-m-Y", strtotime($voucher->created_at)) . ' đến ' . date("H:i:s d-m-Y", strtotime($voucher->expired_at)) . '. Hãy dùng ngay khỏi phí 😍',
                'url' => 'javascript:void',
                'image' => FCHelper::eimg2($voucher, 'img'),
            ];

            if ($voucher->is_public !== 1) {
                $data['body'] = 'Nhập mã giảm giá ' . $voucher->code . ' để được hưởng ưu đãi dành riêng cho bạn! 💥. ' . $voucher->getNameShowUser() . ' cho đơn hàng từ ' . ($voucher->minimum_apply_voucher > 0 ? $voucher->minimum_apply_voucher / 1000 : 0) . 'k . Hiệu lực: từ ' . date("H:i:s d-m-Y", strtotime($voucher->created_at)) . ' đến ' . date("H:i:s d-m-Y", strtotime($voucher->expired_at)) . '. Hãy dùng ngay khỏi phí 😍';
                $data['url'] = 'javascript:void(0)';
            }

            $user->sendNotification($data, $type);
        }
        return response([
            'code' => 200,
            'message' => "Đã gửi thông báo thành công",
        ]);
    }

}



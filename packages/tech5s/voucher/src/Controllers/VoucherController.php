<?php

namespace Tech5s\Voucher\Controllers;

use App\Models\User;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Tech5s\Notify\Models\NotificationCatalog;
use Tech5s\Notify\Models\NotificationType;
use Tech5s\Voucher\Helpers\VoucherCheck;
use Tech5s\Voucher\Traits\FullText;
use Tech5s\Voucher\Helpers\VoucherHelper;
use Tech5s\Voucher\Models\Voucher;
use Tech5s\Voucher\Services\VoucherService;
use Tech5sCart;
use vanhenry\helpers\helpers\FCHelper;

class VoucherController extends BaseController
{
    const NO_FULLTEXT = false;
    use FullText;

    public function showFormAddVoucher()
    {
        $item = new VoucherService();
        $item->flush();
        $promotion = 'vouchers';
        $action = 'create';
        return view('tpv::add', compact('action', 'promotion'));
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

        $voucher = new VoucherService;
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

        $checkProductInVoucherSafity = $voucher->checkProductInVoucherSafity();
        if ($checkProductInVoucherSafity) {
            return response([
                'code' => 100,
                'message' => $checkProductInVoucherSafity,
            ]);
        }

        $voucher->setImg('img', 'voucher');
        $voucher->saveVoucher();

        if (($messageCreateProduct = $voucher->createProductVoucher())) {
            return response([
                'code' => 100,
                'message' => $messageCreateProduct,
            ]);
        }

        if (($messageCreateProductCategory = $voucher->createProductCategoryVoucher())) {
            return response([
                'code' => 100,
                'message' => $messageCreateProductCategory,
            ]);
        }

        return response([
            'code' => 200,
            'message' => 'Tạo mã giảm giá thành công',
            'redirect_url' => base64_decode($request->input('returnurl')),
        ]);
    }

    public function editFormVoucher($data)
    {
        $request = request();
        $id = $data['id'];
        $promotion = 'vouchers';
        $action = 'edit';
        $pivotMethodTable = config('tpvc_setting.pivot_method');
        $pivotMethodCategory = config('tpvc_setting.pivot_method_categories');
        $currentItem = Voucher::with($pivotMethodTable, $pivotMethodCategory)->find($id);
        if ($currentItem == null) {
            return redirect()->to('esystem/view/vouchers');
        }
        $lock = false;
        if (new \DateTime($currentItem->start_at) < new DateTime()) {
            $lock = true;
        }
        $code = \Str::replace(VoucherHelper::PREFIX_CODE, '', $currentItem->code);


        $products = $currentItem->$pivotMethodTable;

        $listCategories = collect();
        $course_categories = $currentItem->$pivotMethodCategory;

        if ($course_categories->count() > 0) {
            foreach ($course_categories->pluck('id') as $id) {
                $listCategories[] = [
                    'id' => (string) $id,
                ];
            }
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT_CATEGORY, $listCategories);
        } else {
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT_CATEGORY, collect());
        }

        $categories = $this->filterCategory()->whereIn('id', $listCategories->pluck('id'))->paginate(5);
        $listItemId = collect();

        if ($products->count() > 0) {
            foreach ($products->pluck('id') as $id) {
                $listItemId[] = [
                    'id' => (string) $id,
                ];
            }
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT, $listItemId);
        } else {
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT, collect());
        }

        $listItems = DB::table(config('tpvc_setting.table'))->whereIn('id', $listItemId->pluck('id'))->paginate(5);

        return view('tpv::edit', compact('currentItem', 'listItems', 'code', 'lock', 'promotion', 'action', 'categories', 'listCategories'));
    }

    public function copyFormVoucher($data)
    {
        $request = request();
        $id = $data['id'];
        $promotion = 'vouchers';
        $action = 'edit';
        $pivotMethodTable = config('tpvc_setting.pivot_method');
        $pivotMethodCategory = config('tpvc_setting.pivot_method_categories');
        $currentItem = Voucher::with($pivotMethodTable, $pivotMethodCategory)->find($id);
        if ($currentItem == null) {
            return redirect()->to('esystem/view/vouchers');
        }
        $lock = false;
        if (new \DateTime($currentItem->start_at) < new DateTime()) {
            $lock = true;
        }
        $code = \Str::replace(VoucherHelper::PREFIX_CODE, '', $currentItem->code);


        $products = $currentItem->$pivotMethodTable;

        $listCategories = collect();
        $course_categories = $currentItem->$pivotMethodCategory;

        if ($course_categories->count() > 0) {
            foreach ($course_categories->pluck('id') as $id) {
                $listCategories[] = [
                    'id' => (string) $id,
                ];
            }
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT_CATEGORY, $listCategories);
        } else {
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT_CATEGORY, collect());
        }

        $categories = $this->filterCategory()->whereIn('id', $listCategories->pluck('id'))->paginate(5);
        $listItemId = collect();

        if ($products->count() > 0) {
            foreach ($products->pluck('id') as $id) {
                $listItemId[] = [
                    'id' => (string) $id,
                ];
            }
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT, $listItemId);
        } else {
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT, collect());
        }

        $listItems = DB::table(config('tpvc_setting.table'))->whereIn('id', $listItemId->pluck('id'))->paginate(5);

        return view('tpv::copy', compact('currentItem', 'listItems', 'code', 'lock', 'promotion', 'action', 'categories', 'listCategories'));
    }

    public function update(Request $request, $id)
    {
        $voucher = new VoucherService($id);
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

        $checkProductInVoucherSafity = $voucher->checkProductInVoucherSafity();
        if ($checkProductInVoucherSafity) {
            return response([
                'code' => 100,
                'message' => $checkProductInVoucherSafity,
            ]);
        }

        $voucher->setImg('img', 'voucher');
        $voucher->saveVoucher();

        if (($messageCreateProduct = $voucher->createProductVoucher())) {
            return response([
                'code' => 100,
                'message' => $messageCreateProduct,
            ]);
        }

        if (($messageCreateProductCategory = $voucher->createProductCategoryVoucher())) {
            return response([
                'code' => 100,
                'message' => $messageCreateProductCategory,
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
        $items = session()->get(VoucherService::PREFIX_SESSION_PRODUCT);

        $items = $items->filter(fn ($item) => $item['id'] != $request->input('id'));

        session()->put(VoucherService::PREFIX_SESSION_PRODUCT, $items);

        $listItems = DB::table(config('tpvc_setting.table'))->whereIn('id', $items->pluck('id'))->paginate(5);

        return response([
            'code' => 200,
            'count' => $listItems->total(),
            'html' => view('tpv::components.table_item', compact('listItems'))->render(),
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
            "minimum_apply_voucher" => 'required|integer|min:0',
            "limit" => 'required|integer|min:1',
            "is_public" => 'required',
            // 'condition_receive' => 'required|integer|min:0',
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'unique' => ':attribute đã được sử dụng',
            'integer' => ':attribute phải là số nguyên',
            'min' => ':attribute phải lớn hơn hoặc bằng :min',
        ], [
            // "condition_receive" => 'Điều kiện để được nhận mã giảm giá',
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
            $type = 1; // Thêm mã thông của voucher vào phần này

            $types = $user->notificationTypes->filter(function ($q) use ($type) {
                return $q->id == $type;
            });

            if ($types->count() == 0) {
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
            $catalog = NotificationCatalog::find(1);
            $type = NotificationType::find(14);
            $user->sendNotification($data, $catalog, $type);
        }
        return response([
            'code' => 200,
            'message' => "Đã gửi thông báo thành công",
        ]);
    }

    public function loadProduct(Request $request)
    {
        $listItemId = session()->get(VoucherService::PREFIX_SESSION_PRODUCT);
        $listItems = DB::table(config('tpvc_setting.table'))->whereIn('id', $listItemId->pluck('id'))->paginate(5);
        return response([
            'code' => 200,
            'html' => view('tpv::components.table_item', compact('listItems'))->render(),
        ]);
    }

    public function showListCategory(Request $request)
    {
        $listProducts = collect(json_decode($request->input('data', []), true));

        $listItems = $this->filterCategory()->paginate(5);
        return response([
            'code' => 200,
            'html' => view('tpv::components.categoryShow', compact('listItems', 'listProducts'))->render(),
        ]);
    }

    public function searchCategory(Request $request)
    {
        $listProducts = collect(json_decode($request->input('data', []), true));

        $listItems = $this->filterCategory();

        if ($request->input('isShow') == 1) {
            $listItems->whereIn('id', $listProducts->pluck('id'));
        }

        $listItems = $listItems->paginate(5);

        return response([
            'code' => 200,
            'html' => view('tpv::components.table_category_list', compact('listItems', 'listProducts'))->render(),
        ]);
    }

    public function filterCategory()
    {
        $request = request();
        $listItems = DB::table(config('tpvc_setting.category_table'))->where('act', 1);
        if ($request->input('q') !== null) {
            $listItems = $this->FullTextSearch($listItems, 'name', $request->input('q'));
        }
        return $listItems;
    }

    public function applyVoucher(Request $request)
    {
        $cartContent = Tech5sCart::instance('course');
        $code = $request->input('code');
        $voucherCheck = new VoucherCheck($code);
        if ($voucherCheck->voucher == null) {
            return response([
                'code' => 100,
                'message' => 'Mã giảm giá không tồn tại'
            ]);
        }
        if ($cartContent->count() == 0) {
            return response([
                'code' => 100,
                'message' => 'Không có sản phẩm nào trong giỏ hàng phù hợp với mã giảm giá'
            ]);
        }
        if (($message = $voucherCheck->refreshData($cartContent, 0))) {
            return response([
                'code' => 100,
                'message' => $message,
                'apply' => false
            ]);
        };
        // $listItems = $cartContent->content();
        // $totalMoney = $voucherCheck->totalPrice - $voucherCheck->discount;
        return response([
            'code' => 200,
            'message' => 'Áp dụng mã giảm giá thành công',
            // 'html' => view('carts.components.contentTotal', compact('totalMoney', 'listItems', 'voucherCheck'))->render(),
            // 'apply' => true
        ]);
    }

    public function removeVoucher(Request $request)
    {
        // $cartContent = Tech5sCart::instance();
        $voucherCheck = new VoucherCheck;
        if ($voucherCheck->voucher != null) {
            $voucherCheck->removeVoucher();
        }
        // $listItems =  $cartContent->content();
        // $totalMoney = $cartContent->totalFloat();
        return response([
            'code' => 200,
            'message' => 'Cập nhật mã giảm giá thành công',
            // 'html' => view('carts.components.contentTotal', compact('totalMoney', 'listItems', 'voucherCheck'))->render(),
            // 'apply' => true
        ]);
    }
}

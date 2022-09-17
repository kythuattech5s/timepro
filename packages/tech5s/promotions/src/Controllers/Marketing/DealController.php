<?php

namespace Tech5s\Promotion\Controllers\Marketing;

use App\Models\Product;
use DealHelper;
use Illuminate\Http\Request;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\DealContruct;
use Tech5s\Promotion\Models\Deal;

class DealController extends MarketingController
{
    public function showFormAdd()
    {
        $item = new DealContruct;
        $item->flush();
        $action = 'create';
        $promotion = 'deals';
        return view('tech5spromotion::marketing.deals.add', compact('action', 'promotion'));
    }

    public function create(Request $request)
    {
        $validator = $this->validator($request->all());
        $action = $request->input('action');
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }
        $item = new DealContruct();
        $item->setDataCreate();
        $item->saveDeal();
        $currentItem = Deal::find($item->deal->id);
        $promotion = 'deals';
        $type = $item->deal->type;
        $dataResponse = [
            'code' => 200,
            'type' => $type,
            'action' => $action,
            'html' => view('tech5spromotion::marketing.deals.itemDeal', compact('currentItem', 'action'))->render(),
        ];

        if ($action == 'copy') {
            $products = Product::find($item->product_mains);
            $product_checked = $item->product_main_real->pluck('id');
            $dataResponse['html_product_main'] = view('tech5spromotion::marketing.deals.itemMainShow', compact('type', 'action', 'product_checked', 'promotion', 'products'))->render();
        }
        return response($dataResponse);
    }

    private function validator(array $data)
    {
        return \Validator::make($data, [
            "name" => 'required',
            "start_at" => 'required',
            "expired_at" => 'required',
            "price" => 'integer|min:1',
            "type" => 'required',
            "qty" => 'integer|min:2',
            "limit" => 'integer|min:1',
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'unique' => ':attribute đã được sử dụng',
            'integer' => ':attribute phải là số nguyên',
            'min' => ':attribute phải lớn hơn hoặc bằng :min',
        ], [
            "name" => 'Tên',
            "start_at" => 'Thời gian bắt đầu',
            "expired_at" => 'Thời gian kết thúc',
            "price" => 'Giá',
            "limit" => 'Số lượng tối đa sản phẩm',
            "qty" => 'Số lượng quà',
            "type" => 'Loại deal',
        ]);
    }

    public function changeAct(Request $request)
    {
        // try {
        $type = $request->input('type');
        $item = new DealContruct();
        foreach ($request->id as $id) {
            $data = [
                'id' => $id,
                'act' => $request->input('act'),
            ];
            if ((int) $request->input('act') === 1) {
                $type == 'main' ? $item->setProductMainReal($data) : $item->setProductSubReal($data);
                $type == 'main' ? $item->removeItemProductMainNoActive($id) : $item->removeItemProductSubNoActive($id);
            } else {
                $type == 'main' ? $item->removeItemProductMainReal($id) : $item->removeItemProductSubReal($id);
                $type == 'main' ? $item->setProductMainNoActive($data) : $item->setProductSubNoActive($data);
            }
        }

        $type == 'main' ? $item->saveSessionProductMainNoActive() : $item->saveSessionProductSubNoActive();
        $type == 'main' ? $item->saveSessionProductMainReal() : $item->saveSessionProductSubReal();

        return response([
            'code' => 200,
        ]);
        // } catch (\Exception $err) {
        //     return response([
        //         'code' => 100
        //     ]);
        // }
    }

    public function changeActSub(Request $request)
    {
        // try {
        $item = new DealContruct();
        $data = json_decode($request->input('data'), true);
        $data = array_filter($data);
        foreach ($data as $dataItem) {
            $data = [
                'id' => $dataItem['id'][0],
                'act' => $dataItem['act'][0],
                'price' => $dataItem['price'],
                'percent' => \is_numeric($dataItem['percent']) ? $dataItem['percent'] : null,
                'ord' => $dataItem['ord'] ?? null,
            ];
            if ((int) $dataItem['act'][0] === 1) {
                $item->setProductSubReal($data);
                $item->removeItemProductSubNoActive($dataItem['id'][0]);
            } else {
                $item->removeItemProductSubReal($dataItem['id'][0]);
                $item->setProductSubNoActive($data);
            }
        }
        $item->saveProductSub();
        $item->saveSessionProductSubNoActive();
        $item->saveSessionProductSubReal();
        return response([
            'code' => 200,
        ]);
        // } catch (\Exception $err) {
        //     return response([
        //         'code' => 100
        //     ]);
        // }
    }

    public function removeItem(Request $request)
    {
        // try {
        $type = $request->input('type');
        $item = new DealContruct();
        foreach ($request->id as $id) {
            $type == 'main' ? $item->removeItemProductMainReal($id) : $item->removeItemProductSubReal($id);
            $type == 'main' ? $item->removeItemProductMainNoActive($id) : $item->removeItemProductSubNoActive($id);
            $type == 'main' ? $item->removeItemProductMain($id) : $item->removeItemProductSub($id);
            $type == 'main' ? $item->removeItemProductMainDB($id) : $item->removeItemProductSubDB($id);
        }
        $type == 'main' ? $item->saveSessionProductMainNoActive() : $item->saveSessionProductSubNoActive();
        $type == 'main' ? $item->saveSessionProductMainReal() : $item->saveSessionProductSubReal();
        $type == 'main' ? $item->saveSessionProductMain() : $item->saveSessionProductSub();
        return response([
            'code' => 200,
        ]);
        // } catch (\Exception $err) {
        //     return response([
        //         'code' => 100
        //     ]);
        // }
    }

    public function saveProductMain(Request $request)
    {
        $action = $request->input('action');
        $promotion = $request->input('promotion');
        $item = new DealContruct();
        $product_checked = $item->product_main_real->pluck('id');
        $item->saveProductMain();
        $products = Product::find($item->product_mains);
        $currentItem = $item->deal;
        $type = $currentItem->type;
        $dataResponse = [
            'code' => 200,
            'html' => view('tech5spromotion::marketing.deals.itemMain', compact('currentItem', 'products', 'product_checked', 'promotion', 'action'))->render(),
            'type' => 'type',
            'action' => $action,
        ];

        if ($action == 'copy') {
            $product_checked = $item->product_sub_real->pluck('id');
            $products = Product::with(['dealSub' => function ($q) use ($item) {
                $q->where('deals.id', $item->deal->id);
            }])->find($item->product_subs);
            $currentItem = $item->deal;
            if ($item->deal->type == DealHelper::TYPE_DEAL) {
                $view = 'tech5spromotion::marketing.deals.itemSubShow';
            } else {
                $view = 'tech5spromotion::marketing.deals.itemSubShowGift';
            }
            $dataResponse['html_product_sub'] = view($view, compact('currentItem', 'products', 'product_checked', 'type', 'action', 'promotion'))->render();
        }
        return response($dataResponse);
    }

    public function editProductMain(Request $request)
    {
        $type = $request->input('type');
        $promotion = $request->input('promotion');
        $action = $request->input('action');
        $item = new DealContruct();
        $currentItem = $item->deal;
        $type == 'main' ? $item->saveSessionProductMainReal() : $item->saveSessionProductSubReal();
        $products = Product::find($type == 'main' ? $item->product_mains : $item->product_subs);
        $product_checked = $item->product_main_real->pluck('id');
        return response([
            'html' => view('tech5spromotion::marketing.deals.itemMainShow', compact('products', 'action', 'currentItem', 'promotion', 'type', 'product_checked'))->render(),
            'count' => $products->count(),
            'type' => $type,
        ]);
    }

    public function editDeal(Request $request, $id)
    {
        $currentItem = Deal::find($id);
        $action = $request->input('action');
        return response([
            'html' => view('tech5spromotion::marketing.deals.editDeal', compact('currentItem', 'action'))->render(),
        ]);
    }

    public function saveEditDeal(Request $request)
    {
        $validator = $this->validator($request->all());
        $action = $request->input('action');
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }
        $item = new DealContruct();
        $messageCheckTimeEdit = $item->checkTimeEditNow();

        if ($messageCheckTimeEdit) {
            return response([
                'code' => 100,
                'message' => $messageCheckTimeEdit,
            ]);
        }
        $item->setDataCreate();
        $item->saveDeal();
        $currentItem = Deal::find($item->deal->id);
        return response([
            'code' => 200,
            'html' => view('tech5spromotion::marketing.deals.itemDeal', compact('currentItem', 'action'))->render(),
        ]);
    }

    public function saveProductSub(Request $request)
    {
        $promotion = $request->input('promotion');
        $type = $request->input('type');
        $action = $request->input('action');
        $item = new DealContruct();
        $data = json_decode($request->input('data'), true);
        $data = array_filter($data);
        foreach ($data as $dataItem) {
            $data = [
                'id' => $dataItem['id'][0],
                'price' => $dataItem['price'],
                'act' => 0,
                'ord' => $dataItem['ord'] ?? null,
                'limit' => null,
            ];
            if (isset($dataItem['percent'])) {
                $data['percent'] = $dataItem['percent'];
            }

            if (isset($dataItem['limit']) && !empty($dataItem['limit'])) {
                $data['limit'] = $dataItem['limit'];
            }
            if ($dataItem['act'][0] == 1) {
                $data['act'] = 1;
                $item->removeItemProductSubNoActive($data['id']);
                $item->setProductSubReal($data);
            } else {
                $item->removeItemProductSubReal($data['id']);
                $item->setProductSubNoActive($data);
            }
        }
        $item->saveProductSub();
        $item->saveSessionProductSubNoActive();
        $item->saveSessionProductSubReal();
        if (isset($request->type_save)) {
            $product_checked = $item->product_sub_real->pluck('id');
            $products = Product::with(['dealSub' => function ($q) use ($item) {
                $q->where('deals.id', $item->deal->id);
            }])->find($item->product_subs);
            $currentItem = $item->deal;
            return response([
                'code' => 200,
                'html' => view('tech5spromotion::marketing.deals.itemSub', compact('currentItem', 'products', 'product_checked', 'promotion', 'action', 'type'))->render(),
            ]);
        }
        return response([
            'code' => 200,
        ]);

    }

    public function editProductSub(Request $request)
    {
        $item = new DealContruct();
        $promotion = $request->input('promotion');
        $type = $request->input('type');
        $action = $request->input('action');
        $product_checked = $item->product_sub_real->pluck('id');
        $products = Product::with(['dealSub' => function ($q) use ($item) {
            $q->where('deals.id', $item->deal->id);
        }])->find($item->product_subs);
        $currentItem = $item->deal;
        if ($item->deal->type == DealHelper::TYPE_DEAL) {
            $view = 'tech5spromotion::marketing.deals.itemSubShow';
        } else {
            $view = 'tech5spromotion::marketing.deals.itemSubShowGift';
        }
        return response([
            'code' => 200,
            'html' => view($view, compact('currentItem', 'products', 'product_checked', 'promotion', 'action', 'type'))->render(),
            'count' => $products->count(),
            'type' => $type,
        ]);
    }

    public function showFormEdit(Request $request, $id)
    {
        $action = 'edit';
        $promotion = 'deals';
        $item = new DealContruct($id);
        $item->saveAll();
        $currentItem = $item->deal;
        $product_mains = Product::find($item->product_mains);
        $product_main_checked = $item->product_main_real->pluck('id');
        $product_subs = Product::with(['dealSub' => function ($q) use ($item) {
            $q->where('deals.id', $item->deal->id);
        }])->find($item->product_subs);
        $product_sub_checked = $item->product_sub_real->pluck('id');
        return view('tech5spromotion::marketing.deals.edit', compact('currentItem', 'product_mains', 'product_subs', 'product_main_checked', 'product_sub_checked', 'action', 'promotion'));
    }

    public function showFormCopy(Request $request, $id)
    {
        $action = 'copy';
        $promotion = 'deals';
        $item = new DealContruct($id, $action);
        $item->saveAll();
        $currentItem = $item->deal;
        $product_mains = Product::find($item->product_mains);
        $product_main_checked = $item->product_main_real->pluck('id');
        $product_subs = Product::with(['dealSub' => function ($q) use ($item) {
            $q->where('deals.id', $item->deal->id);
        }])->find($item->product_subs);
        $product_sub_checked = $item->product_sub_real->pluck('id');
        $item->deal = new Deal();
        $item->saveSessionDeal();
        return view('tech5spromotion::marketing.deals.copy', compact('currentItem', 'product_mains', 'product_subs', 'product_main_checked', 'product_sub_checked', 'action', 'promotion'));
    }

    public function save(Request $request)
    {
        $item = new DealContruct();
        $item->saveDeal();
        $item->saveProductMain();
        $item->saveProductSub();
        return response([
            'code' => 200,
            'message' => $request->input('type') == 'edit' ? 'Cập nhật Deal sốc thành công' : 'Tạo deal thành công',
            'redirect_url' => url(\base64_decode($request->input('returnurl', \base64_encode(url('esystem/view/deals'))))),
        ]);
    }
}

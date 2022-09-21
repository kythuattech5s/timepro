<?php

namespace Tech5s\FlashSale\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tech5s\Voucher\Services\VoucherService;

class BaseController extends Controller
{

    public function showProduct(Request $request)
    {
        $action = $request->input('action', '');
        $type = $request->input('type', '');
        $promotion = $request->input('promotion', '');
        $categories = DB::table(config('tpvc_setting.category_table'))->where('act', 1)->paginate(30);
        $listItems = $this->queryFilterProduct()->paginate(config('tpvc_setting.paginate', 10));
        $promotion = $request->input('promotion');
        $item_checked_old = session()->get(VoucherService::PREFIX_SESSION_PRODUCT, collect());
        $item_chooses = collect();
        $shop_id = $request->input('shop_id', false);

        foreach ($item_checked_old as $product) {
            $item_chooses[] = [
                'id' => $product['id'],
                'disabled' => 1,
            ];
        }
        return response([
            'html' => view('tpv::components.modal_product', compact('item_checked_old', 'categories', 'listItems', 'promotion', 'item_chooses', 'action', 'type', 'shop_id'))->render(),
        ]);
    }

    public function searchProduct(Request $request)
    {
        $promotion = $request->input('promotion');
        $action = $request->input('action');
        $item_chooses = collect(json_decode($request->input('item_chooses', []), true));
        $item_checked_old = $item_chooses->filter(fn ($item) => isset($item['disabled']));
        $listItems = $this->queryFilterProduct();
        if ($request->input('isShow') !== null && $item_checked_old->count() > 0) {
            $listItems->whereNotIn('id', $item_checked_old->pluck('id'));
        }

        $listItems = $listItems->paginate(config('tpvc_setting.paginate', 10));

        return response([
            'html' => view('tpv::components.modal_table_item', compact('listItems', 'item_chooses', 'item_checked_old'))->render(),
            'lastPage' => $listItems instanceof Collection ? 'null' : $listItems->onLastPage(),
            'count' => $listItems->count(),
        ]);
    }

    public function chooseProduct(Request $request)
    {
        $action = $request->input('action');
        $type = $request->input('type', '');
        $promotion = $request->input('promotion');
        $item = new VoucherService();
        if (($itemIds = $request->input('item_id')) !== null) {
            $dataItemId = collect($itemIds)->map(
                fn ($value) => [
                    "id" => $value['id'],
                ]
            )->unique();
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT, $dataItemId);
        } else {
            session()->put(VoucherService::PREFIX_SESSION_PRODUCT, $item->products);
        }
        $listItems = DB::table(config('tpvc_setting.table'))->whereIn('id', $dataItemId->pluck('id'))->paginate(5);
        return response([
            'html' => view('tpv::components.ItemShow', \compact('listItems', 'action', 'promotion'))->render(),
        ]);
    }
}

<?php

namespace Tech5s\FlashSale\Controllers;

use App\Http\Controllers\Controller;
use DB;
use FlashSaleHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tech5s\FlashSale\Models\FlashSale;
use Tech5s\FlashSale\Services\FlashSaleService;
use Tech5s\Voucher\Services\VoucherService;
use vanhenry\manager\controller\BaseAdminController;

class BaseController extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function showProduct(Request $request)
    {
        $service = new FlashSaleService;
        $categories = DB::table(config('tpfc_setting.category_table'))->where('act', 1);
        $pivotMethodCategories = config('tpfc_setting.pivot_method_categories');

        if (($listCategories = $service->flash_sale->$pivotMethodCategories)->count() > 0) {
            $categories->whereIn('id', $listCategories->pluck('id'));
        }

        $categories = $categories->get();
        $action = $request->input('action', '');
        $type = $request->input('type', '');
        $promotion = $request->input('promotion', '');
        $listItems = $this->queryFilterProduct()->paginate(config('tpfc_setting.paginate', 10));
        $promotion = $request->input('promotion');
        $item_checked_old = session()->get(FlashSaleService::PREFIX_SESSION_PRODUCT, collect());
        $item_chooses = collect();
        $shop_id = $request->input('shop_id', false);

        foreach ($item_checked_old as $product) {
            $item_chooses[] = [
                'id' => $product['id'],
                'disabled' => 1,
            ];
        }
        return response([
            'html' => view('tpf::components.modal_product', compact('item_checked_old', 'categories', 'listItems', 'promotion', 'item_chooses', 'action', 'type', 'shop_id'))->render(),
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
            'html' => view('tpf::components.modal_table_item', compact('listItems', 'item_chooses', 'item_checked_old'))->render(),
            'lastPage' => $listItems instanceof Collection ? 'null' : $listItems->onLastPage(),
            'count' => $listItems->count(),
        ]);
    }

    public function chooseProduct(Request $request)
    {
        $action = $request->input('action');
        $type = $request->input('type', '');
        $promotion = $request->input('promotion');
        $item = new FlashSaleService();
        $listItemOld = session()->get(FlashSaleService::PREFIX_SESSION_PRODUCT);

        $dataItemId = collect($request->input('item_id'))->map(
            function ($value) use ($listItemOld) {
                $itemContain = collect($listItemOld)->first(fn ($q) => (int)$q['id'] == (int)$value['id']);
                if ($itemContain !== null) {
                    return $itemContain;
                } else {
                    return [
                        "id" => $value['id'],
                        'act' => 1,
                        'discount' => 0
                    ];
                }
            }
        )->unique();

        session()->put(FlashSaleService::PREFIX_SESSION_PRODUCT, $dataItemId);
        $listItems = DB::table(config('tpfc_setting.table'))->whereIn('id', $dataItemId->pluck('id'))->paginate(5);

        return response([
            'html' => view('tpf::components.ItemShow', \compact('listItems', 'action', 'promotion', 'dataItemId', 'listItemOld'))->render(),
        ]);
    }

    public function queryFilterProduct()
    {
        $request = request();

        $products = DB::table(config('tpvc_setting.table'))->where('act', 1);

        if (isset($request->q)) {
            $products = $this->fullTextSearch($products, $request->input('by', 'name'), $request->input('q'));
        }

        if (isset($request->category_id) && config('tpvc_setting.has_pivot')) {
            $itemIds = DB::table(config('tpvc_setting.pivot_table'))->where(config('tpvc_setting.pivot_field_category_table'), $request->category_id)->pluck(config('tpvc_setting.pivot_field_table'));
            $products->whereIn('id', $itemIds);
        } else {
            $service = new FlashSaleService;
            $pivotMethodCategories = config('tpfc_setting.pivot_method_categories');
            if (($listCategories = $service->flash_sale->$pivotMethodCategories)->count() > 0) {
                $itemIds = DB::table(config('tpvc_setting.pivot_table'))->whereIn(config('tpvc_setting.pivot_field_category_table'), $listCategories->pluck('id'))->pluck(config('tpvc_setting.pivot_field_table'));
                $products->whereIn('id', $itemIds);
            }
        }

        return $products;
    }
}

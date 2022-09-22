<?php

namespace Tech5s\FlashSale\Controllers;

use Cache;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Tech5s\FlashSale\Models\FlashSale;
use Tech5s\FlashSale\Models\PromotionSlotTime;
use Tech5s\FlashSale\Models\PromotionType;
use Tech5s\FlashSale\Models\PromotionTypeComparison;
use Tech5s\FlashSale\Services\FlashSaleService;
use Tech5s\FlashSale\Traits\FullText;

class FlashSaleController extends BaseController
{
    use FullText;
    public function __construct()
    {
        $this->middleware('h_users');
        parent::__construct();
    }

    public function show(Request $request)
    {
        $promotion = 'flash_sales';
        $id = $request->input('id');
        $item = new FlashSaleService($id);
        $item->resetSession();
        $item->saveSessionFlashSale();
        $item->getListItems();
        $currentItem = $item->flash_sale;
        $pivotMethod = config('tpfc_setting.pivot_method');
        $listItemOld = session()->get(FlashSaleService::PREFIX_SESSION_PRODUCT);
        $listItems = $item->flash_sale->$pivotMethod()->paginate(5);
        return view('tpf::detail', compact('currentItem', 'promotion', 'listItems', 'listItemOld'));
    }

    public function showFormAdd()
    {
        $action = 'add';
        $type_comparisons = Cache::rememberForever('promotion_comparation', function () {
            return PromotionTypeComparison::select(['id', 'name'])->act()->ord()->get();
        });

        $types = Cache::rememberForever('promotion_types', function () {
            return PromotionType::select(['id', 'name'])->act()->ord()->get();
        });
        $item = new FlashSaleService();
        $item->flush();
        return view('tpf::add', compact('type_comparisons', 'types', 'action'));
    }

    public function createTimeSlot(Request $request)
    {
        $item = new FlashSaleService();
        $item->setData();
        $messageCheckTime = $item->checkTimeCreate();
        if ($messageCheckTime) {
            return response([
                'code' => 100,
                'message' => $messageCheckTime,
            ]);
        }
        if (($checkTimeSatisfy = $item->checkTimeActiveOrCreateSatisfy())) {
            return response([
                'code' => 100,
                'message' => $checkTimeSatisfy,
            ]);
        }

        $flash_sale = $item->flash_sale;
        $item->saveSessionFlashSale();
        return response([
            'html' => view('tpf::components.TimeSlot', compact('flash_sale'))->render(),
        ]);
    }

    public function editTimeSlot(Request $request)
    {
        $item = new FlashSaleService();
        $item->getSessionFlashSale();
        $flash_sale = $item->flash_sale;
        return response([
            'html' => view('tpf::components.EditTimeSlot', compact('flash_sale'))->render(),
        ]);
    }

    public function findSlotTime(Request $request)
    {
        $flash_sale_current = new FlashSaleService;
        $date_start_current = $flash_sale_current->flash_sale->start_at instanceof DateTime ? $flash_sale_current->flash_sale->start_at->format('Y-m-d') : (new DateTime($flash_sale_current->flash_sale->start_at))->format('Y-m-d');
        $now = time();
        $slot_times = PromotionSlotTime::act()->get();
        $time_slot = [];
        foreach ($slot_times as $key => $time) {
            $data = $request->input('date', (new DateTime)->format('Y-m-d')) . ' ' . $time->from;
            $timeData = strtotime($data);
            $flash_sale = FlashSale::where('start_at', $data)->first();
            if ($flash_sale == null && ($timeData > $now || ($date_start_current == $request->time && $flash_sale_current->flash_sale->promotion_slot_time_id == $time->id))) {
                $time_slot[] = $time;
            }
        }
        $res = [
            'html' => view('tpf::components.table_time_slot', compact('time_slot'))->render(),
        ];
        if (isset($flash_sale_current->flash_sale->flash_sale_slot_time_id) && $date_start_current == $request->input('date')) {
            $res['slot_time_id'] = $flash_sale_current->flash_sale->flash_sale_slot_time_id;
        }
        return response()->json($res);
    }

    public function choosePromotionTypeApply(Request $request)
    {
        $type = $request->type;
        list($listData, $view, $search) = $this->getDataType($type);

        return response([
            'search_html' => view($search)->render(),
            'html' => view($view, compact('listData'))->render(),
        ]);
    }

    public function search(Request $request)
    {
        $paginate = config('tpc_setting.paginate', 10);
        $listChecked = collect(json_decode($request->input('listChecked'), true));
        $keyword = $request->input('name', $request->input('q', null));
        $listData = DB::table(config('tpfc_setting.category_table'));

        if ($request->input('isShow') == 'on') {
            $listData->whereIn('id', $listChecked->pluck('id'));
        }
        if (!is_null($keyword)) {
            $listData = $this->FullText($listData, 'name', $keyword);
        }

        $listData = $listData->where('act', 1)->paginate($paginate);
        return response([
            'html' => view('tpf::components.types.category', compact('listData', 'listChecked'))->render(),
        ]);
    }

    public function getDataType($type)
    {
        $configs = config('tpfc_PromotionType');
        $data = $configs['data'][$type];
        $model = $data['model'] ?? false;
        $wheres = $data['where'] ?? [];
        $withs = $data['with'] ?? [];
        $select = $data['select'] ?? [];
        $paginate = $data['paginate'] ?? 10;
        $view = $data['view'];
        $search = $data['search_view'];

        $listData = [];
        if ($model) {
            $query = $model::query();
            $query->select($select);
            foreach ($wheres as $field => $value) {
                if (is_array($value)) {
                    $query->where(function ($q) use ($field, $value) {
                        foreach ($value as $key => $item) {
                            if ($key == 0) {
                                $q->where($field, $item);
                            } else {
                                $q->orWhere($field, $item);
                            }
                        }
                    });
                } else {
                    $query->where($field, $value);
                }
            }

            if (count($withs) > 0) {
                $query->with($withs);
            }

            $listData = $query->paginate($paginate);
        }
        return [$listData, $view, $search];
    }

    public function showChildCategory(Request $request)
    {
        $listData = DB::table(config('tpfc_setting.category_table'))->where('parent', $request->input('id'))->select(['id', 'name'])->get();
        $data = compact('listData');

        if (isset($request->id_promotion_product)) {
            $currentItem = FlashSale::find($request->flash_sale_id);
            $data = compact('currentItem', 'listData');
        }

        return response([
            'html' => view('tpf::components.types.category', $data)->render(),
        ]);
    }

    public function store(Request $request)
    {
        $item = new FlashSaleService();
        // $item->setPromotionTypeComparison($request->input('promotion_type_comparison_id'));
        $item->setPromotionType($request->input('promotion_type_id'));
        $item->setName($request->input('name'));
        // $item->setDiscount($request->input('discount'));
        $item->setAct($request->input('act', 1));
        $item->setOrd($request->input('ord', 0));
        if ($request->input('img') !== null) {
            $item->setImage($request->input('img', ''));
        }
        $item->saveFlashSale();
        return response([
            'code' => 200,
            'message' => 'Tạo chương trình Flash sale thành công',
            'redirect_url' => base64_decode($request->input('returnurl', base64_encode(url('tpf/flashsale/chinh-sua-chi-tiet-flash-sale?id=' . $item->flash_sale->id)))),
        ]);
    }

    public function editForm($data)
    {
        $id = $data['id'];
        $item = new FlashSaleService($id);
        $item->saveSessionFlashSale();
        $type_comparisons = Cache::rememberForever('promotion_comparation', function () {
            return PromotionTypeComparison::select(['id', 'name'])->act()->ord()->get();
        });

        $types = Cache::rememberForever('promotion_types', function () {
            return PromotionType::select(['id', 'name'])->act()->ord()->get();
        });

        $currentItem = $item->flash_sale;

        $data = compact('currentItem', 'types', 'type_comparisons');
        $pivotMethodCategories = config('tpfc_setting.pivot_method_categories');
        if ($currentItem->$pivotMethodCategories->count() > 0 || $currentItem->promotion_type_id == config('tpc_PromotionType.key.CATEGORY')) {
            $limit = config('tpc_setting.paginate', 10);
            $checkedData = $currentItem->$pivotMethodCategories->pluck('id');
            $listProductOfPromotion = $currentItem->$pivotMethodCategories;

            $listData = DB::table(config('tpfc_setting.category_table'))->where('act', 1)->whereIn('id', $listProductOfPromotion->pluck('id'))->paginate($limit);
            $data = compact('currentItem', 'listData', 'types', 'checkedData', 'listProductOfPromotion', 'type_comparisons');
        }
        return view('tpf::edit', $data);
    }

    public function update(Request $request, $id)
    {
        $item = new FlashSaleService();
        // $item->setPromotionTypeComparison($request->input('promotion_type_comparison_id'));
        $item->setPromotionType($request->input('promotion_type_id'));
        $item->setName($request->input('name'));
        // $item->setDiscount($request->input('discount'));
        $item->setAct($request->input('act') == 1 ? 1 : 0);
        $item->setOrd($request->input('ord', 0));
        if ($request->input('img') !== null) {
            $item->setImage($request->input('img'));
        }
        $item->saveFlashSale();
        return response([
            'code' => 200,
            'message' => 'Thay đổi chương trình Flash Sale thành công',
            'redirect_url' => base64_decode($request->input('returnurl', base64_encode(url('esystem/view/flash_sales')))),
        ]);
    }

    public function copyForm($data)
    {
        $this->resetSession();
        $id = $data['id'];
        $item = new FlashSaleService($id);
        $type_comparisons = Cache::rememberForever('promotion_comparation', function () {
            return PromotionTypeComparison::select(['id', 'name'])->act()->ord()->get();
        });

        $types = Cache::rememberForever('promotion_types', function () {
            return PromotionType::select(['id', 'name'])->act()->ord()->get();
        });

        $currentItem = $item->flash_sale;

        $data = compact('currentItem', 'types', 'type_comparisons');
        $pivotMethodCategories = config('tpfc_setting.pivot_method_categories');
        if ($currentItem->$pivotMethodCategories->count() > 0 || $currentItem->promotion_type_id == config('tpc_PromotionType.key.CATEGORY')) {
            $limit = config('tpc_setting.paginate', 10);
            $checkedData = $currentItem->$pivotMethodCategories->pluck('id');
            $listProductOfPromotion = $currentItem->$pivotMethodCategories;

            $listData = DB::table(config('tpfc_setting.category_table'))->where('act', 1)->whereIn('id', $listProductOfPromotion->pluck('id'))->paginate($limit);
            $data = compact('currentItem', 'listData', 'types', 'checkedData', 'listProductOfPromotion', 'type_comparisons');
        }
        return view('tpf::copy', $data);
    }

    public function resetSession()
    {
        if (session()->has(FlashSaleService::PREFIX_SESSION_FLASH_SALE)) {
            session()->forget(FlashSaleService::PREFIX_SESSION_FLASH_SALE);
        }
        if (session()->has(FlashSaleService::PREFIX_SESSION_PRODUCT)) {
            session()->forget(FlashSaleService::PREFIX_SESSION_FLASH_SALE);
        }
    }
    public function loadProduct(Request $request)
    {
        $listItemOld = session()->get(FlashSaleService::PREFIX_SESSION_PRODUCT);
        $listItems = DB::table(config('tpvc_setting.table'))->whereIn('id', $listItemOld->pluck('id'))->paginate(5);
        return response([
            'code' => 200,
            'html' => view('tpf::components.table_item', compact('listItems', 'listItemOld'))->render(),
        ]);
    }

    public function saveProductCurrent(Request $request)
    {
        $listItems = json_decode($request->input('listItems'), true);
        $listItemCurrent = session()->get(FlashSaleService::PREFIX_SESSION_PRODUCT);
        foreach ($listItemCurrent as $key => $item) {
            $itemContain = collect($listItems)->first(fn ($q) => (int)$q['id'] == (int)$item['id']);
            if ($itemContain !== null) {
                $listItemCurrent[$key] = $itemContain;
            }
        }

        session()->put(FlashSaleService::PREFIX_SESSION_PRODUCT, $listItemCurrent);
    }

    public function updateForAll(Request $request)
    {
        $act = $request->input('act');
        $discount = $request->input('discount');
        $listItems = session()->get(FlashSaleService::PREFIX_SESSION_PRODUCT);
        $newListItems = [];
        foreach ($listItems as $key => $item) {
            $item['act'] = $act;
            $item['discount'] = $discount;
            $newListItems[] = $item;
        }
        $listItemOld = collect($newListItems);
        session()->put(FlashSaleService::PREFIX_SESSION_PRODUCT, $listItemOld);
        $listItems = DB::table(config('tpvc_setting.table'))->whereIn('id', $listItemOld->pluck('id'))->paginate(5);
        return response([
            'code' => 200,
            'html' => view('tpf::components.table_item', compact('listItems', 'listItemOld'))->render(),
        ]);
    }

    public function saveProduct(Request $request)
    {
        $item = new FlashSaleService();

        $pivotMethod = config('tpfc_setting.pivot_method');
        $item->flash_sale->$pivotMethod()->sync([]);
        $listItems = session()->get(FlashSaleService::PREFIX_SESSION_PRODUCT);
        $dataPivot = $listItems->map(function ($item) {
            return [
                config('tpfc_setting.pivot_field_table') => $item['id'],
                'act' => $item['act'],
                'discount' => $item['discount']
            ];
        });
        $item->flash_sale->$pivotMethod()->sync($dataPivot);
        return response([
            'code' => 200,
            'message' => 'Cập nhật sản phẩm thành công',
            'redirect_url' => url('esystem/view/flash_sales')
        ]);
    }

    public function removeProduct(Request $request)
    {
        $listItemOld = session()->get(FlashSaleService::PREFIX_SESSION_PRODUCT);
        $listItemOld = $listItemOld->filter(fn ($q) => (int)$q['id'] !== (int) $request->input('id'));
        session()->put(FlashSaleService::PREFIX_SESSION_PRODUCT, $listItemOld);
        $listItems = DB::table(config('tpvc_setting.table'))->whereIn('id', $listItemOld->pluck('id'))->paginate(5);
        return response([
            'code' => 200,
            'html' => view('tpf::components.table_item', compact('listItems', 'listItemOld'))->render(),
            'count' => $listItemOld->count()
        ]);
    }
}

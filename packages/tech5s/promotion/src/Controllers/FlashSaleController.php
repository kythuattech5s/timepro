<?php

namespace Tech5s\Promotion\Controllers;

use App\Models\Course;
use App\Models\Product;
use App\Models\CourseCategory;
use App\Models\Promotion\ShopFlashSaleProduct;
use Cache;
use DateTime;
use Illuminate\Http\Request;
use Shop\Promotion\Models\ShopFlashSale;
use Tech5s\Promotion\Helpers\FlashSaleDetailHelper;
use Tech5s\Promotion\Helpers\FlashSaleHelper;
use Tech5s\Promotion\Models\FlashSale;
use Tech5s\Promotion\Models\PromotionSlotTime;
use Tech5s\Promotion\Models\PromotionType;
use Tech5s\Promotion\Models\PromotionTypeComparison;
use Tech5s\Promotion\Repository\FlashSaleRepository;
use Tech5s\Promotion\Services\FlashSaleService;

class FlashSaleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show(Request $request)
    {
        $promotion = 'flash_sales';
        $this->resetSession();
        $id = $request->input('id');
        $item = new FlashSaleService($id);
        // $repository = new FlashSaleRepository($item->flash_sale);
        // $listProduct = $repository->getListProduct();
        // dd($listProduct);
        // $listProducts = session()->get(FlashSaleDetailHelper::SESSION_PRODUCT_REAL);
        $item->saveSessionFlashSale();
        $currentItem = $item->flash_sale;
        return view('tp::flash_sales.detail', compact('currentItem', 'promotion'));
    }

    public function resetSession()
    {
        session()->forget(FlashSaleDetailHelper::SESSION_PRODUCT_CURRENT);
        session()->forget(FlashSaleDetailHelper::SESSION_PRODUCT_REAL);
        session()->forget(FlashSaleDetailHelper::SESSION_PRODUCT_REMOVE);
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
        return view('tp::flash_sales.add', compact('type_comparisons', 'types', 'action'));
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
            'html' => view('tp::flash_sales.components.TimeSlot', compact('flash_sale'))->render(),
        ]);
    }

    public function editTimeSlot(Request $request)
    {
        $item = new FlashSaleService();
        $item->getSessionFlashSale();
        $flash_sale = $item->flash_sale;
        return response([
            'html' => view('tp::flash_sales.components.EditTimeSlot', compact('flash_sale'))->render(),
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
            'html' => view('tp::components.table_time_slot', compact('time_slot'))->render(),
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
        $listData = CourseCategory::query();

        if ($request->input('isShow') == 'on') {
            $listData->whereIn('id', $listChecked->pluck('id'));
        }
        if (!is_null($keyword)) {
            $listData = $listData->where(function ($q) use ($keyword) {
                $q->where(function ($q) use ($keyword) {
                    $q->FullTextSearch('name', $keyword);
                })->orWhereHas('course', function ($q) use ($keyword) {
                    $q->FullTextSearchNoRelevance('name', $keyword);
                });
            })->with(['course' => function ($q) use ($keyword) {
                $q->FullTextSearchNoRelevance('name', $keyword);
            }]);
        }

        $listData = $listData->where('act', 1)->paginate($paginate);
        return response([
            'html' => view('tp::flash_sales.components.types.category', compact('listData', 'listChecked'))->render(),
        ]);
    }

    public function getDataType($type)
    {
        $configs = config('tpc_PromotionType');
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
        $listData = CourseCategory::where('parent', $request->input('id'))->with('childs')->select(['id', 'name'])->get();
        $data = compact('listData');

        if (isset($request->id_promotion_product)) {
            $currentItem = FlashSale::find($request->flash_sale_id);
            $data = compact('currentItem', 'listData');
        }

        return response([
            'html' => view('tp::flash_sales.components.types.category', $data)->render(),
        ]);
    }

    public function store(Request $request)
    {
        $item = new FlashSaleService();
        $item->setPromotionTypeComparison($request->input('promotion_type_comparison_id'));
        $item->setPromotionType($request->input('promotion_type_id'));
        $item->setName($request->input('name'));
        $item->setDiscount($request->input('discount'));
        $item->setAct($request->input('act', 1));
        $item->setOrd($request->input('ord', 0));
        if ($request->input('img') !== null) {
            $item->setImage($request->input('img', ''));
        }
        $item->saveFlashSale();
        return response([
            'code' => 200,
            'message' => 'Tạo chương trình Flash sale thành công',
            'redirect_url' => base64_decode($request->input('returnurl', base64_encode(url('tp/flash-sale/chinh-sua-chi-tiet-flash-sale?id=' . $item->flash_sale->id)))),
        ]);
    }

    public function showFormEdit($data)
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
        if ($currentItem->categories->count() > 0 || $currentItem->promotion_type_id == config('tpc_PromotionType.key.CATEGORY')) {
            $limit = config('tpc_setting.paginate', 10);
            $checkedData = $currentItem->categories->pluck('id');
            $listProductOfPromotion = $currentItem->categories;

            $listData = CourseCategory::act()->whereIn('id', $listProductOfPromotion->pluck('id'))->paginate($limit);
            $data = compact('currentItem', 'listData', 'types', 'checkedData', 'listProductOfPromotion', 'type_comparisons');
        }
        return view('tp::flash_sales.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $item = new FlashSaleService();
        $item->setPromotionTypeComparison($request->input('promotion_type_comparison_id'));
        $item->setPromotionType($request->input('promotion_type_id'));
        $item->setName($request->input('name'));
        $item->setDiscount($request->input('discount'));
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

    public function showFormCopy($data)
    {
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
        if ($currentItem->categories->count() > 0 || $currentItem->promotion_type_id == config('tpc_PromotionType.key.CATEGORY')) {
            $limit = config('tpc_setting.paginate', 10);
            $checkedData = $currentItem->categories->pluck('id');
            $listProductOfPromotion = $currentItem->categories;
            $listData = CourseCategory::act()->paginate($limit);
            $data = compact('currentItem', 'listData', 'types', 'checkedData', 'listProductOfPromotion', 'type_comparisons');
        }
        return view('tp::flash_sales.copy', $data);
    }

    public function saveProduct(Request $request, $listItem = false)
    {
        $listItems = $listItem ? $listItem : $this->saveDataProduct();
        $flashSale = FlashSale::find($request->input('flash_sale_id'));
        $newData = [];
        foreach ($listItems as $item) {
            $newData[] = [
                'course_id' => $item['id'],
                'price' => $item['price'],
                'percent' => $item['percent'],
                'qty' => $item['qty'],
                'limit' => $item['limit'] ?? null,
                'act' => $item['act'],
            ];
        }
        $flashSale->courses()->sync($newData);

        return response([
            'code' => 200,
            'message' => 'Lưu sản phẩm thành công',
            'redirect_url' => url('shop/chuong-trinh-flash-sale'),
        ]);
    }

    private function saveDataProduct()
    {
        $request = request();
        $listItems = session()->get(FlashSaleHelper::SESSION_PRODUCT_REAL, collect());
        $data = json_decode($request->input('data'), true);
        $data = collect(array_filter($data));
        $newCollect = collect();
        foreach ($listItems as $key => $item) {
            $firstItem = $data->first(function ($q) use ($item) {
                return $q['id'] == $item['id'];
            });
            if ($firstItem !== null) {
                $newCollect[] = $firstItem;
            } else {
                $newCollect[] = $item;
            }
        }
        return $newCollect;
    }
}

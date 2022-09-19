<?php

namespace Tech5s\Promotion\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Tech5s\Promotion\Helpers\DealHelper;
use Tech5s\Promotion\Helpers\FlashSaleHelper;
use Tech5s\Promotion\Services\ComboService;
use Tech5s\Promotion\Services\DealService;
use Tech5s\Promotion\Services\FlashSaleService;
use Tech5s\Promotion\Services\VoucherService;
use vanhenry\manager\controller\BaseAdminController;

class MarketingController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::guard('h_users')->check()) {
            echo 'Bạn cần login trước đã!';
            die;
        }
    }

    public function showProduct(Request $request)
    {
        $action = $request->input('action', '');
        $type = $request->input('type', '');
        $promotion = $request->input('promotion', '');
        $product_categories = CourseCategory::where('act', 1)->paginate(30);
        $products = $this->queryFilterProduct()->paginate(config('tpc_setting.paginate', 10));
        $promotion = $request->input('promotion');
        $old_product_selected = $this->getProductOfPromotion($promotion);
        $product_chooses = collect();

        $shop_id = $request->input('shop_id', false);

        if ($promotion == 'deals') {
            $item = new DealService;
            $shop_id = $item->deal->shop_id;
        }

        if ($promotion == 'flash_sales') {
        }
        foreach ($old_product_selected as $product) {
            $product_chooses[] = [
                'id' => $product,
                'disabled' => 1,
            ];
        }
        return response([
            'html' => view('tp::components.modal_product', compact('product_categories', 'products', 'promotion', 'product_chooses', 'action', 'type', 'shop_id'))->render(),
        ]);
    }

    public function getProductOfPromotion($promotion)
    {
        $request = request();
        switch ($promotion) {
            case 'deals':
                $type = $request->input('type');
                if ($type == 'main') {
                    return session()->get(DealService::PREFIX_SESSION_PRODUCT_MAIN, collect());
                } else {
                    return session()->get(DealService::PREFIX_SESSION_PRODUCT_SUB, collect());
                }
                break;
            case 'flash_sales':
                return session()->get(FlashSaleService::SS_PRODUCT_SELECTED, collect());
                break;
            default:
                return session()->get(VoucherService::PREFIX_SESSION_PRODUCT, collect());
                break;
        }
    }

    public function searchProduct(Request $request)
    {
        $promotion = $request->input('promotion');
        $action = $request->input('action');
        $product_chooses = collect(json_decode($request->input('product_chooses', []), true));
        $product_checked_old = $product_chooses->filter(fn ($item) => isset($item['disabled']));
        $products = $this->queryFilterProduct();
        if ($request->input('isShow') !== null && $product_checked_old->count() > 0) {
            $products->whereNotIn('id', $product_checked_old->pluck('id'));
        }

        $products = $products->paginate(config('tpc_setting.paginate', 10));

        return response([
            'html' => view('tp::components.table_item', compact('products', 'product_chooses', 'product_checked_old'))->render(),
            'lastPage' => $products instanceof Collection ? 'null' : $products->lastPage(),
            'count' => $products->count(),
        ]);
    }

    public function chooseProductForPromotion(Request $request)
    {
        $action = $request->input('action');
        $type = $request->input('type', '');
        $promotion = $request->input('promotion');
        switch ($promotion) {
            case "vouchers":
                $item = new VoucherService();
                if (($product_ids = $request->input('product_id')) !== null) {
                    $dataProductId = collect($product_ids)->map(
                        fn ($value) => [
                            "id" => $value['id'],
                        ]
                    )->unique();
                    session()->put(VoucherService::PREFIX_SESSION_PRODUCT, $dataProductId);
                } else {
                    session()->put(VoucherService::PREFIX_SESSION_PRODUCT, $item->products);
                }
                $products = Course::whereIn('id', $dataProductId->pluck('id'))->paginate(5);
                return response([
                    'html' => view('tp::vouchers.components.ItemShow', \compact('products', 'action', 'promotion'))->render(),
                ]);
                break;
            case "combos":
                $item = new ComboService();
                if (($product_ids = $request->input('product_id')) !== null) {
                    foreach ($request->input('product_id') as $id) {
                        if (!$item->products->contains($id)) {
                            $item->setProductReal([
                                'id' => $id['id'],
                                'act' => 1,
                            ]);
                        }
                    }
                    session()->put(ComboService::PREFIX_SESSION_PRODUCT, collect($product_ids));
                    $products = Course::whereIn('id', collect($product_ids)->pluck('id'))->get();
                } else {
                    session()->put(ComboService::PREFIX_SESSION_PRODUCT, collect());
                    $products = collect();
                }
                $item->saveProductReal();
                $product_checked = $item->product_real->pluck('id');
                return response([
                    'html' => view('tp::combos.components.ItemShow', \compact('products', 'action', 'promotion', 'product_checked'))->render(),
                ]);
                break;
            case 'deals':
                $item = new DealService();
                $currentItem = $item->deal;
                $messageCheckProductSub = $item->checkProductSub();
                if ($messageCheckProductSub) {
                    return response([
                        'code' => 100,
                        'message' => $messageCheckProductSub,
                    ]);
                }
                if (($product_ids = $request->input('product_id')) !== null) {
                    foreach ($product_ids as $id) {
                        // Thêm sản phẩm chính
                        if (!$item->product_mains->contains($id['id']) && !$item->product_subs->contains($id['id'])) {
                            // Kiểm tra loại deal nếu là mua kèm deal sốc chỉ có id và act
                            if ($type == 'main') {
                                $item->setProductMainReal([
                                    'id' => $id['id'],
                                    'act' => 1,
                                ]);
                            } else if ($item->deal->type == DealHelper::TYPE_GIFT) {
                                $product = Course::with('variants')->find($id['id']);
                                if ($product->variants->count() > 0) {
                                    foreach ($product->variants as $itemChild) {
                                        if (is_null($item->product_sub_no_active->first(function ($q) use ($itemChild) {
                                            return (int) $itemChild->id == (int) $q['id'];
                                        }))) {
                                            $item->setProductSubReal([
                                                'id' => $itemChild->id,
                                                'act' => 1,
                                                'price' => 0,
                                            ]);
                                        }
                                    }
                                } else {
                                    $item->setProductSubReal([
                                        'id' => $id['id'],
                                        'act' => 1,
                                        'price' => 0,
                                    ]);
                                }
                            }
                        }
                    }
                    $type == 'main' ? $item->saveSessionProductMainReal() : $item->saveSessionProductSubReal();
                    session()->put($type == 'main' ? DealService::PREFIX_SESSION_PRODUCT_MAIN : DealService::PREFIX_SESSION_PRODUCT_SUB, collect($product_ids));
                    $products = Course::with(['dealSub' => function ($q) use ($item) {
                        $q->where('deals.id', $item->deal->id);
                    }, 'dealMain' => function ($q) use ($item) {
                        $q->where('deals.id', $item->deal->id);
                    }])->whereIn('id', collect($product_ids)->pluck('id'))->get();
                } else {
                    session()->put($type == 'main' ? DealService::PREFIX_SESSION_PRODUCT_MAIN : DealService::PREFIX_SESSION_PRODUCT_SUB, collect());
                    $products = collect();
                }
                $product_checked = $type == 'main' ? $item->product_main_real->pluck('id') : $item->product_sub_real->pluck('id');
                if ($type == 'main') {
                    $view = 'tp::deals.components.itemMainShow';
                } elseif ($type == 'sub' && $item->deal->type == DealHelper::TYPE_DEAL) {
                    $view = 'tp::deals.components.itemSubShow';
                } else {
                    $view = 'tp::deals.components.itemSubShowGift';
                }
                return response([
                    'html' => view($view, compact('products', 'action', 'currentItem', 'promotion', 'type', 'product_checked'))->render(),
                    'count' => $products->count(),
                    'type' => $type,
                ]);
                break;
            case 'flash_sales':
               
                return response([
                    'code' => 200,
                    'message' => 'Thêm sản phẩm thành công'
                ]);
                break;
        }
    }

    public function queryFilterProduct()
    {
        $request = request();
        $promotion = $request->input('promotion');

        $products = Course::where('act', 1);
        if ($promotion == 'deals') {
            $item = new DealService;
            $shop_id = $item->deal->shop_id;
            $products->where('shop_id', $shop_id);
        }

        if (isset($request->shop_id)) {
            $products->where('shop_id', $request->shop_id);
        }

        if (isset($request->q)) {
            $products->fullTextSearch($request->input('by', 'name'), $request->input('q'));
        }

        if (isset($request->category_id)) {
            $products->whereHas('categories', function ($q) use ($request) {
                $q->where('product_categories.id', $request->category_id);
            });
        }

        $product_selected = $this->getProductOfPromotion($promotion);

        $products = $this->filterProductNoPromotion($products, $promotion, $product_selected);

        $products = $this->clearProduct($products, $promotion);

        return $products;
    }

    public function clearProduct($products, $promotion)
    {
        $request = request();
        if ($promotion == 'deals' && $request->input('type') == 'sub') {
            $item = new DealService;
            $products = $products->whereNotIn('id', $item->product_main_real->pluck('id'));
        }
        return $products;
    }

    public function filterProductNoPromotion($products, $promotion, $product_in_promotion)
    {
        switch ($promotion) {
            case 'deals':
                $detailPromotion = new DealService;
                $start_at = $detailPromotion->deal->start_at;
                $expired_at = $detailPromotion->deal->expired_at;
                $products->where('shop_id', $detailPromotion->deal->shop_id);
                break;
            case 'combos':
                $detailPromotion = new ComboService;
                $start_at = request()->input('start_at');
                $expired_at = request()->input('expired_at');
                break;
            case 'flash_sales':
                $detailPromotion = new FlashSaleService();
                $start_at = $detailPromotion->flash_sale->start_at;
                $expired_at = $detailPromotion->flash_sale->expired_at;
                break;
            case 'vouchers':
                $detailPromotion = new VoucherService();
                $start_at = request()->input('start_at');
                $expired_at = request()->input('expired_at');
                break;
        }

        $start_at = $start_at instanceof DateTime ? $start_at : new DateTime($start_at);
        $expired_at = $expired_at instanceof DateTime ? $expired_at : new DateTime($expired_at);
        $products->where(function ($q) use ($detailPromotion, $product_in_promotion, $start_at, $expired_at) {
            if ($detailPromotion instanceof ComboService || $detailPromotion instanceof DealService) {
                $q->whereDoesntHave('combo', function ($q) use ($product_in_promotion, $start_at, $expired_at) {
                    $q->where(function ($q) use ($start_at, $expired_at) {
                        $q->where(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('combos.start_at', [$start_at, $expired_at]);
                        })->orWhere(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('combos.expired_at', [$start_at, $expired_at]);
                        })->orWhere(function ($q) use ($start_at, $expired_at) {
                            $q->where('combos.start_at', '<=', $start_at)->where('combos.expired_at', '>=', $expired_at);
                        });
                    })->where('combos.act', 1)->where('combo_products.act', 1)->whereNotIn('combo_products.product_id', $product_in_promotion);
                });
                $q->whereDoesntHave('dealMain', function ($q) use ($product_in_promotion, $start_at, $expired_at) {
                    $q->where(function ($q) use ($start_at, $expired_at) {
                        $q->where(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('deals.start_at', [$start_at, $expired_at]);
                        })
                            ->orWhere(function ($q) use ($start_at, $expired_at) {
                                $q->whereBetween('deals.expired_at', [$start_at, $expired_at]);
                            })
                            ->orWhere(function ($q) use ($start_at, $expired_at) {
                                $q->where('deals.start_at', '<=', $start_at)->where('deals.expired_at', '>=', $expired_at);
                            });
                    })->where('deals.act', 1)->where('deal_product_mains.act', 1)->whereNotIn('deal_product_mains.product_id', $product_in_promotion);
                });
                $q->whereDoesntHave('dealSub', function ($q) use ($product_in_promotion, $start_at, $expired_at) {
                    $q->where(function ($q) use ($start_at, $expired_at) {
                        $q->where(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('deals.start_at', [$start_at, $expired_at]);
                        })->orWhere(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('deals.expired_at', [$start_at, $expired_at]);
                        })->orWhere(function ($q) use ($start_at, $expired_at) {
                            $q->where('deals.start_at', '<=', $start_at)->where('deals.expired_at', '>=', $expired_at);
                        });
                    })->where('deals.act', 1)->where('deal_product_subs.act', 1)->whereNotIn('deal_product_subs.product_id', $product_in_promotion);
                });
            }

            if ($detailPromotion instanceof FlashSaleService) {
            }
        });
        return $products;
    }

    public function softdeletePromotion(Request $request, $table)
    {
        \DB::table($table)->where('id', $request->input('id'))->update(['act' => 0, 'deleted' => 1]);
        return response([
            'code' => 200,
            'message' => 'Xóa chương trình thành công',
        ]);
    }
}

<?php

namespace Tech5s\Promotion\Controllers\Marketing;

use App\Models\Product;
use App\Models\ProductCategory;
use DateTime;
use DealHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\ComboContruct;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\DealContruct;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\FlashSaleContruct;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\VoucherContruct;
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
        $action = $request->action;
        $type = $request->input('type', '');
        $promotion = $request->input('promotion');
        $product_categories = ProductCategory::where('act', 1)->paginate(30);
        $products = $this->getProductNoPromotion($promotion);
        $promotion = $request->input('promotion');
        $product_chooses = $this->getProductOfPromotion($promotion);
        return response([
            'html' => view('tech5spromotion::marketing.modal_product', compact('product_categories', 'products', 'promotion', 'product_chooses', 'action', 'type'))->render(),
        ]);
    }

    public function getProductOfPromotion($promotion)
    {
        $request = request();
        if ($promotion == 'deals') {
            $type = $request->input('type');
            if ($type == 'main') {
                return session()->get(DealContruct::PREFIX_SESSION_PRODUCT_MAIN, collect());
            } else {
                return session()->get(DealContruct::PREFIX_SESSION_PRODUCT_SUB, collect());
            }
        } else {
            return session()->get(VoucherContruct::PREFIX_SESSION_PRODUCT, collect());
        }
    }

    public function searchProduct(Request $request)
    {
        $promotion = $request->input('promotion');
        $products = $this->getProductNoPromotion($promotion);
        $product_chooses = $this->getProductOfPromotion($promotion);
        $product_in_promotion = $request->input('product_in_promotion',false);
        return response([
            'html' => view('tech5spromotion::marketing.all_product', compact('products', 'product_chooses','product_in_promotion'))->render(),
            'lastPage' => $products instanceof Collection ? 'null' : $products->lastPage(),
            'count' => $products->count()
        ]);
    }

    public function chooseProductForPromotion(Request $request)
    {
        $action = $request->input('action');
        $type = $request->input('type', '');
        $promotion = $request->input('promotion');
        switch ($promotion) {
            case "vouchers":
                $item = new VoucherContruct();
                if (($product_ids = $request->input('product_id')) !== null) {
                    session()->put(FlashSaleContruct::PREFIX_SESSION_PRODUCT, $item->products->merge(collect($product_ids))->unique());
                    $products = Product::find($item->products->merge(collect($product_ids)));
                } else {
                    session()->put(FlashSaleContruct::PREFIX_SESSION_PRODUCT, $item->products);
                    $products = Product::find($item->products);
                }
                return response([
                    'html' => view('tech5spromotion::marketing.vouchers.itemShow', \compact('products', 'action', 'promotion'))->render(),
                ]);
                break;
            case "combos":
                $item = new ComboContruct();
                if (($product_ids = $request->input('product_id')) !== null) {
                    foreach ($request->input('product_id') as $id) {
                        if (!$item->products->contains($id)) {
                            $item->setProductReal([
                                'id' => $id,
                                'act' => 1,
                            ]);
                        }
                    }
                    session()->put(ComboContruct::PREFIX_SESSION_PRODUCT, collect($product_ids));
                    $products = Product::find($product_ids);
                } else {
                    session()->put(ComboContruct::PREFIX_SESSION_PRODUCT, collect());
                    $products = collect();
                }
                $item->saveProductReal();
                $product_checked = $item->product_real->pluck('id');

                return response([
                    'html' => view('tech5spromotion::marketing.combos.itemShow', \compact('products', 'action', 'promotion', 'product_checked'))->render(),
                ]);
                break;
            case 'flash_sales':
                if (($product_ids = $request->input('product_id')) !== null) {
                    $item = new FlashSaleContruct();
                    $currentItem = $item->flash_sale;
                    session()->put(FlashSaleContruct::PREFIX_SESSION_PRODUCT, collect($product_ids));
                    $products = Product::with(['flash_sale', 'variants' => function ($q) use ($item, $action) {
                        if (in_array($action, ['edit', 'copy'])) {
                            $q->whereNotIn('id', $item->product_delete)->with('flash_sale', function ($q) use ($item) {
                                return $q->where('flash_sales.id', $item->flash_sale->id);
                            });
                        }
                    }])->whereIn('id', $product_ids)->get();
                } else {
                    session()->put(FlashSaleContruct::PREFIX_SESSION_PRODUCT, collect());
                    $products = collect();
                }
                return response([
                    'html' => view('tech5spromotion::marketing.flashsales.itemShow', compact('products', 'action', 'currentItem', 'promotion'))->render(),
                ]);
                break;
            case 'deals':
                $item = new DealContruct();
                $currentItem = $item->deal;
                $messageCheckProductSub = $item->checkProductSub();
                if ($messageCheckProductSub) {
                    return response([
                        'code' => 100,
                        'message' => $messageCheckProductSub,
                    ]);
                }
                if (($product_ids = $request->input('product_id')) !== null) {
                    foreach ($request->input('product_id') as $id) {
                        // Thêm sản phẩm chính
                        if (!$item->product_mains->contains($id) && !$item->product_subs->contains($id)) {
                            // Kiểm tra loại deal nếu là mua kèm deal sốc chỉ có id và act
                            if ($type == 'main') {
                                $item->setProductMainReal([
                                    'id' => $id,
                                    'act' => 1,
                                ]);
                            } else if ($item->deal->type == DealHelper::TYPE_GIFT) {
                                $product = Product::with('variants')->find($id);
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
                                        'id' => $id,
                                        'act' => 1,
                                        'price' => 0,
                                    ]);
                                }
                            }
                        }
                    }
                    $type == 'main' ? $item->saveSessionProductMainReal() : $item->saveSessionProductSubReal();
                    session()->put($type == 'main' ? DealContruct::PREFIX_SESSION_PRODUCT_MAIN : DealContruct::PREFIX_SESSION_PRODUCT_SUB, collect($product_ids));
                    $products = Product::with(['dealSub' => function ($q) use ($item) {
                        $q->where('deals.id', $item->deal->id);
                    }, 'dealMain' => function ($q) use ($item) {
                        $q->where('deals.id', $item->deal->id);
                    }, 'variants' => function ($q) use ($item) {
                        $q->with(['dealSub' => function ($q) use ($item) {
                            $q->where('deals.id', $item->deal->id);
                        }, 'dealMain' => function ($q) use ($item) {
                            $q->where('deals.id', $item->deal->id);
                        }]);
                    }])->whereIn('id', $product_ids)->get();
                } else {
                    session()->put($type == 'main' ? DealContruct::PREFIX_SESSION_PRODUCT_MAIN : DealContruct::PREFIX_SESSION_PRODUCT_SUB, collect());
                    $products = collect();
                }
                $product_checked = $type == 'main' ? $item->product_main_real->pluck('id') : $item->product_sub_real->pluck('id');
                if ($type == 'main') {
                    $view = 'tech5spromotion::marketing.deals.itemMainShow';
                } elseif ($type == 'sub' && $item->deal->type == DealHelper::TYPE_DEAL) {
                    $view = 'tech5spromotion::marketing.deals.itemSubShow';
                } else {
                    $view = 'tech5spromotion::marketing.deals.itemSubShowGift';
                }
                return response([
                    'html' => view($view, compact('products', 'action', 'currentItem', 'promotion', 'type', 'product_checked'))->render(),
                    'count' => $products->count(),
                    'type' => $type,
                ]);
                break;
        }
    }

    public function getProductNoPromotion($promotion)
    {
        $request = request();
        $products = Product::query();

        if (isset($request->q)) {
            $products->fullTextSearch($request->input('by'), $request->input('q'));
        }

        $product_chooses = $this->getProductOfPromotion($request->input('promotion'));
        $products = $this->filterProductNoPromotion($products, $promotion, $product_chooses);

        $products->where(function ($q) {
            $q->whereNull('parent');
        });

        $products = $this->clearProduct($products, $promotion);

        $products->with('variants');
        if ($request->input('page') == null && $product_chooses->count() > 0 && $request->input('q') == null) {
            $products->find($product_chooses);
            $products = $products->get();
        } else {
            if (isset($request->category)) {
                $products->whereHas('categories', function ($q) use ($request) {
                    $q->where('product_categories.id', $request->category);
                });
            }
            if ($request->input('q') == null) {
                $products->whereNotIn('id', $product_chooses);
            }
            $products = $products->paginate(10);
        }
        return $products;
    }

    public function clearProduct($products, $promotion)
    {
        $request = request();
        if ($promotion == 'deals' && $request->input('type') == 'sub') {
            $item = new DealContruct;
            $products = $products->whereNotIn('id', $item->product_main_real->pluck('id'));
        }
        return $products;
    }

    public function filterProductNoPromotion($products, $promotion, $product_in_promotion)
    {
        switch ($promotion) {
            case 'deals':
                $detailPromotion = new DealContruct;
                $start_at = $detailPromotion->deal->start_at;
                $expired_at = $detailPromotion->deal->expired_at;
                break;
            case 'combos':
                $detailPromotion = new ComboContruct;
                $start_at = request()->input('start_at');
                $expired_at = request()->input('expired_at');
                break;
            case 'flash_sales':
                $detailPromotion = new FlashSaleContruct();
                $start_at = $detailPromotion->flash_sale->start_at;
                $expired_at = $detailPromotion->flash_sale->expired_at;
                break;
            case 'vouchers':
                $detailPromotion = new VoucherContruct();
                $start_at = request()->input('start_at');
                $expired_at = request()->input('expired_at');
                break;
        }

        $start_at = $start_at instanceof DateTime ? $start_at : new DateTime($start_at);
        $expired_at = $expired_at instanceof DateTime ? $expired_at : new DateTime($expired_at);
        $products->where(function ($q) use ($detailPromotion, $product_in_promotion, $start_at, $expired_at) {
            if ($detailPromotion instanceof ComboContruct || $detailPromotion instanceof DealContruct) {
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
            }
            if ($detailPromotion instanceof ComboContruct || $detailPromotion instanceof DealContruct) {
                $q->whereDoesntHave('dealMain', function ($q) use ($product_in_promotion, $start_at, $expired_at) {
                    $q->where(function ($q) use ($start_at, $expired_at) {
                        $q->where(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('deals.start_at', [$start_at, $expired_at]);
                        })->orWhere(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('deals.expired_at', [$start_at, $expired_at]);
                        })->orWhere(function ($q) use ($start_at, $expired_at) {
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
            if ($detailPromotion instanceof FlashSaleContruct) {
                $q->whereDoesntHave('flash_sale', function ($q) use ($product_in_promotion, $start_at, $expired_at) {
                    $q->where(function ($q) use ($start_at, $expired_at) {
                        $q->where(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('flash_sales.start_at', [$start_at, $expired_at]);
                        })->orWhere(function ($q) use ($start_at, $expired_at) {
                            $q->whereBetween('flash_sales.expired_at', [$start_at, $expired_at]);
                        })->orWhere(function ($q) use ($start_at, $expired_at) {
                            $q->where('flash_sales.start_at', '<=', $start_at)->where('flash_sales.expired_at', '>=', $expired_at);
                        });
                    })->where('flash_sales.act', 1)->where('flash_sale_products.act', 1)->whereNotIn('flash_sale_products.product_id', $product_in_promotion);
                });
            }
        });
        if ($detailPromotion instanceof FlashSaleContruct || $detailPromotion instanceof DealContruct) {
            // Không lấy các sản phẩm có thuộc tính và thuộc tính đó có chương trình flash sale đang kích hoạt và có sản phẩm đang kích hoạt với thời gian bắt đầu nhỏ hơn hoặc bằng thời gian két thúc flashsale hiện tại và thời gian kết thúc phải lớn hơn thời gian bắt đàu của flashsale hiện tại
            $products->where(function ($q) use ($detailPromotion, $product_in_promotion, $start_at, $expired_at) {
                $q->whereDoesntHave('variants', function ($q) use ($detailPromotion, $product_in_promotion, $start_at, $expired_at) {
                    if ($detailPromotion instanceof FlashSaleContruct) {
                        $q->whereHas('flash_sale', function ($q) use ($product_in_promotion, $start_at, $expired_at) {
                            $q->where(function ($q) use ($start_at, $expired_at) {
                                $q->where(function ($q) use ($start_at, $expired_at) {
                                    $q->whereBetween('flash_sales.start_at', [$start_at, $expired_at]);
                                })->orWhere(function ($q) use ($start_at, $expired_at) {
                                    $q->whereBetween('flash_sales.expired_at', [$start_at, $expired_at]);
                                })->orWhere(function ($q) use ($start_at, $expired_at) {
                                    $q->where('flash_sales.start_at', '<=', $start_at)->where('flash_sales.expired_at', '>=', $expired_at);
                                });
                            })->where('flash_sales.act', 1)->where('flash_sale_products.act', 1)->whereNotIn('products.id', $product_in_promotion);
                        });
                    }
                    if ($detailPromotion instanceof DealContruct) {
                        $q->whereHas('dealSub', function ($q) use ($product_in_promotion, $start_at, $expired_at) {
                            $q->where(function ($q) use ($start_at, $expired_at) {
                                $q->where(function ($q) use ($start_at, $expired_at) {
                                    $q->whereBetween('deals.start_at', [$start_at, $expired_at]);
                                })->orWhere(function ($q) use ($start_at, $expired_at) {
                                    $q->whereBetween('deals.expired_at', [$start_at, $expired_at]);
                                })->orWhere(function ($q) use ($start_at, $expired_at) {
                                    $q->where('deals.start_at', '<=', $start_at)->where('deals.expired_at', '>=', $expired_at);
                                });
                            })->where('deals.act', 1)->where('deal_product_subs.act', 1)->whereNotIn('products.id', $product_in_promotion);
                        });
                    }
                });
            });
        }
        return $products;
    }
}

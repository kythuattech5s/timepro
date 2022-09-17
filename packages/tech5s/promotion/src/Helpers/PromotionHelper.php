<?php
namespace Tech5s\Promotion\Helpers;

use App\Models\Product;

class PromotionHelper
{
    public static function createProducts($promotion)
    {
        $collect = collect();

        if ($promotion == null) {
            return [collect(), $promotion];
        }

        if ($promotion !== null) {
            foreach ($promotion->shopFlashSales as $shopFlashSale) {
                foreach ($shopFlashSale->products as $product) {
                    if ($product->pivot->qty > 0) {
                        if ($product->parent != null) {
                            $collect[] = $product->parent;
                        } else {
                            $collect[] = $product->id;
                        }
                    }
                }
            }
        }

        $collect = $collect->unique()->values();
        $collect = Product::select(['products.id','products.name', 'products.slug', 'products.act', 'products.price', 'products.price_old', 'products.img', 'products.ord', 'products.parent', 'products.brand_id'])->where(function ($q) use ($promotion) {
            $q->whereHas('shopFlashSale', function ($q) use ($promotion) {
                $q->where('flash_sale_id', $promotion->id);
            })->orWhereHas('variants', function ($q) use ($promotion) {
                $q->select(['products.id','products.parent'])->whereHas('shopFlashSale', function ($q) use ($promotion) {
                    $q->where('flash_sale_id', $promotion->id);
                });
            });
        })->with(['brand', 'shopFlashSale' => function ($q) use ($promotion) {
            $q->where('flash_sale_id', $promotion->id);
        }, 'variants' => function ($q) use ($promotion) {
            $q->select(['products.id', 'products.name', 'products.slug', 'products.act', 'products.price', 'products.price_old', 'products.img', 'products.ord', 'products.parent', 'products.brand_id'])->with(['shopFlashSale' => function ($q) use ($promotion) {
                $q->where('flash_sale_id', $promotion->id);
            }, 'orderProducts' => function ($q) use ($promotion) {
                $q->where('created_at', '>=', $promotion->start_at)->where('created_at', '<=', $promotion->expired_at);
            }]);
        }, 'orderProducts' => function ($q) use ($promotion) {
            $q->where('created_at', '>=', $promotion->start_at)->where('created_at', '<=', $promotion->expired_at);
        }])->where('act', 1)->whereIn('id', $collect)->get();
        return [$collect, $promotion];
    }
}

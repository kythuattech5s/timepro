<?php

namespace Tech5s\Promotion\Helpers;

use Illuminate\Support\Collection;
use Tech5sPromotion\Models\Combo;
use Tech5sPromotion\Models\FlashSaleProduct;
use Tech5sPromotion\Models\PromotionOnTotalInvoice;
use Tech5sPromotion\Models\PromotionPriority;
use Auth;

class PromotionCheck
{
    const KEY_SESSION_PROMOTION_LIST = 'SESSION_LIST_PROMOTION_IN_CART';
    const KEY_SESSION_PROMOTION_USAGE = 'SESSION_PROMOSTION_USAGE';
    public $items;
    public $listPromotion;
    public $listDiscount;
    public $detailUsage;
    public $sortBy;
    public $discoundFixed = 0;
    public $totalPriceOrder = 0;

    public function __construct(array $listProduct = [], $noGetOldData = true)
    {
        if($noGetOldData){
            $this->getPriority();
            $this->listDiscount = collect();
            $this->items = collect();
            foreach ($listProduct as $item) {
                $this->items[] = new PromotionItem($item);
            }
            $this->detailUsage = $this->oldSessionPromotionUsage();
            $this->createGroupPromotion();
            $this->removeGroupNoSatisFy();
            $this->resetPromotion();
            $this->createDiscountAndPriceForPromotion();
            $this->saveSessionUsage();
            $this->getContentCart();
            $this->getDiscountForUser();
            $this->getDiscountPromotion();
        }
    }

    public function getPriority()
    {
        $this->sortBy = PromotionPriority::ord()->act()->pluck('key');
    }

    public function saveSessionUsage()
    {
        return session()->put(static::KEY_SESSION_PROMOTION_USAGE, $this->detailUsage);
    }

    public function oldSessionPromotionUsage()
    {
        return session()->get(static::KEY_SESSION_PROMOTION_USAGE, collect());
    }

    public function removeGroupNoSatisFy()
    {
        foreach ($this->listPromotion as $keyPromotion => $groupPromotion) {
            switch ($keyPromotion) {
                case 'combos':
                    foreach ($groupPromotion as $keyGroup => $promotion) {
                        if ($promotion->data->qty > $promotion->sum('qty')) {
                            $this->listPromotion[$keyPromotion]->pull($keyGroup);
                        }
                    }
                    break;
            }
        }
        $this->removePromotionNoSatisfy();
    }

    public function removePromotionNoSatisfy()
    {
        foreach ($this->listPromotion as $keyPromotion => $groupPromotion) {
            if ($groupPromotion->count() == 0) {
                $this->listPromotion->pull($keyPromotion);
            }
        }
    }
    public function resetPromotion()
    {
        foreach ($this->detailUsage as $key => $groupPromotion) {
            switch ($key) {
                case 'combos':
                    foreach ($groupPromotion as $promotion) {
                        $combo = Combo::find($promotion['item']->id);
                        $combo->qty_in_cart -= (int) $promotion['qty'];
                        $combo->save();
                    }
                    break;
                case 'flash_sales':
                    foreach ($groupPromotion as $promotion) {
                        $flash_sale_product = FlashSaleProduct::where('flash_sale_id', $promotion['item']->id)->where('product_id', $promotion['product']->id)->first();
                        $flash_sale_product->qty_in_cart -= $promotion['qty'];
                        $flash_sale_product->save();
                    }
                    break;
                case 'deals':

                    break;
                default:
                    # code...
                    break;
            }
        }
        $this->detailUsage = collect();
    }

    public function createDiscountAndPriceForPromotion()
    {

        /*
        Cần tìm mảng nằm trước
         */

        $i = 0;
        foreach ($this->listPromotion as $keyPromotion => $groupPromotion) {
            $cloneSortBy = clone $this->sortBy;
            $arrayPromotionBefore = $cloneSortBy->splice(0, $i)->toArray();
            $i++;
            $this->removeProductHadPromotion($groupPromotion, $keyPromotion, $arrayPromotionBefore);
            $groupPromotion = $this->listPromotion[$keyPromotion];
            switch ($keyPromotion) {
                case 'combos':
                    $this->createDiscountAndPriceForCombo($groupPromotion, $keyPromotion);
                    break;
                case 'deals':
                    $this->createDiscountAndPriceForDeal($groupPromotion, $keyPromotion);
                    break;
                case 'flash_sales':
                    $this->createDiscountAndPriceForFlashSale($groupPromotion, $keyPromotion);
                    break;
            }
        }
        $this->removePromotionNoSatisfy();
    }

    public function createDiscountAndPriceForFlashSale(Collection $groupPromotion, string $keyPromotion)
    {
        $discount = 0;
        foreach ($groupPromotion as $keyGroup => $group) {
            $arrayProductReal = collect();
            foreach ($group as $keyProduct => $product) {
                $this->listPromotion[$keyPromotion][$keyGroup]->pull($keyProduct);
                $flash_sale = $product->product->flashSaleCurrent()->where('flash_sale_products.act', 1)->where('flash_sales.id', $group->data->id)->first();
                if ($flash_sale !== null && ($flash_sale->pivot->limit - $flash_sale->pivot->qty_in_cart >= $product->qty || $flash_sale->pivot->limit == null)) {
                    $arrayProductReal[] = $product->product->id;
                    $product->setPrice($product->product->price);
                    $product->setPriceOld($product->product->price);
                    $discount += $product->qty * ($product->product->price - $flash_sale->pivot->price);
                    $this->listPromotion[$keyPromotion][$keyGroup][] = $product;

                    //Kiểm tra xem sản phẩm đó flash sale có số lượng hay không Lấy số lượng được giảm cho flashsale hiên tại để khi xóa hoặc thêm thì bỏ đi
                    if ($flash_sale->pivot->limit !== null) {
                        if (!isset($this->detailUsage[$keyPromotion])) {
                            $this->detailUsage[$keyPromotion] = collect();
                        }

                        $this->detailUsage[$keyPromotion][] = [
                            'item' => $group->data,
                            'product' => $product->product,
                            'qty' => $product->qty,
                        ];

                        //Cập nhật lại số lượng sản phẩm khi đã đặt hàng
                        $flash_sale_product = FlashSaleProduct::where('flash_sale_id', $flash_sale->id)->where('product_id', $product->product->id)->first();
                        $flash_sale_product->qty_in_cart = $flash_sale_product->qty_in_cart + $product->qty;
                        $flash_sale_product->save();
                    }
                }
            }
            //Kiểm tra nếu không có giảm giá thì xóa
            if ($discount == 0) {
                $this->listPromotion[$keyPromotion]->pull($keyGroup);
                break;
            }

            $this->listPromotion[$keyPromotion][$keyGroup]->productInFlashSale = $arrayProductReal;
            $this->listPromotion[$keyPromotion][$keyGroup]->discount = $discount;
        }
    }

    public function createDiscountAndPriceForDeal(Collection $groupPromotion, string $keyPromotion)
    {
        foreach ($groupPromotion as $keyGroup => $group) {
            $discount = 0;
            $this->listPromotion[$keyPromotion][$keyGroup]->discount = $discount;
            $this->listPromotion[$keyPromotion][$keyGroup] = collect();
            foreach ($group as $itemProduct) {
                if ($itemProduct->product->dealMainCurrent->count() > 0) {
                    $this->listPromotion[$keyPromotion][$keyGroup][] = $itemProduct;
                }
            }
            if ($group->data->type == DealHelper::TYPE_DEAL) {
                $productSub = $group->data->productSub()->where('deal_product_subs.act', 1)->pluck('deal_product_subs.product_id');
                $productSubInCart = $this->items->filter(function ($item) use ($productSub) {
                    return $productSub->contains($item->product->id);
                });
                $this->listPromotion[$keyPromotion][$keyGroup]->productMainInDeal = $group->pluck('product.id');
                // Tính số lượng giảm giá trong deal
                foreach ($productSubInCart as $item) {
                    $this->listPromotion[$keyPromotion][$keyGroup][] = $item;
                    $deal = $item->product->dealSubCurrent()->where('deals.id', $group->data->id)->first();
                    $limit = $item->qty;
                    if ($deal->pivot->limit !== null && $deal->pivot->limit < $item->qty) {
                        $limit = $deal->pivot->limit;
                    }
                    $discount += $limit * $deal->pivot->price;
                }
                //Kiểm tra nếu không có giảm giá thì xóa
                if ($discount == 0) {
                    $this->listPromotion[$keyPromotion]->pull($keyGroup);
                    break;
                }
                $this->listPromotion[$keyPromotion][$keyGroup]->productSubInDeal = $productSubInCart->pluck('product.id');
                $this->listPromotion[$keyPromotion][$keyGroup]->discount = $discount;
            } else {
                $productSub = $group->data->productSub()->where('deal_product_subs.act', 1)->pluck('deal_product_subs.product_id');
                // Lấy ra các sản phẩm quà tặng có trong giỏ hàng
                $productSubInCart = $this->items->filter(function ($item) use ($productSub) {
                    return $productSub->contains($item->product->id);
                });

                $arrayProductReal = collect();
                $qtyGift = $group->data->qty;
                // Tạo mảng các sản phẩm
                if ($productSubInCart->sum('qty') < $qtyGift) {
                    $qtyGift = $productSubInCart->sum('qty');
                    //Khi khách hàng không chọn quà
                }
                //Săp xếp số tiền từ cao đến thấp để tính ra số lượng discount lớn nhất
                $sortProducts = $productSubInCart->sortByDESC(function ($q) {
                    return $q->product->price;
                });
                // Lấy ra các sản phẩm được hưởng khuyến mãi
                foreach ($sortProducts as $product) {
                    if ($qtyGift == 0) {
                        break;
                    }
                    for ($i = 0; $i < $product->qty; $i++) {
                        $arrayProductReal[] = $product;
                        $discount += $product->product->price;
                        $qtyGift--;
                        if ($qtyGift == 0) {
                            break;
                        }
                    }
                }
                //Kiểm tra nếu không có giảm giá thì xóa
                if ($discount == 0) {
                    $this->listPromotion[$keyPromotion]->pull($keyGroup);
                    break;
                }
                foreach ($arrayProductReal->unique() as $key => $product) {
                    $this->listPromotion[$keyPromotion][$keyGroup][] = $product;
                }
                $this->listPromotion[$keyPromotion][$keyGroup]->productMainInDeal = $group->pluck('product.id');
                $this->listPromotion[$keyPromotion][$keyGroup]->productSubInDeal = $arrayProductReal->pluck('product.id');
                $this->listPromotion[$keyPromotion][$keyGroup]->discount = $discount;
            }
            $this->listPromotion[$keyPromotion][$keyGroup]->data = $group->data;
        }
    }

    public function createDiscountAndPriceForCombo(Collection $groupPromotion, string $keyPromotion)
    {
        foreach ($groupPromotion as $keyGroup => $promotion) {
            $combo = Combo::find($promotion->data->id);
            $discount = 0;
            // Lấy ra số lượng cần trong 1 combo
            $qtyProductOneCombo = $promotion->data->qty;
            // Số lượng combo có thể mua
            // $limit = $promotion->data->limit;
            $limit = $promotion->data->limit - $combo->qty_in_cart;
            // Tính số lượng combo có thể mua được theo số lượng thêm vào giỏ hàng
            $countSatisfy = $limit > 0 ? floor($promotion->sum('qty') / $combo->qty) : 0;

            //Kiểm tra nếu giới hạn lớn hơn số lượng combo có thể thêm thì giới hạn bằng số lượng combo có thể thêm
            if ($countSatisfy < $limit) {
                $limit = $countSatisfy;
            }

            //Kiểm tra nếu giới hạn được phép bằng 0 thì xóa
            if ((int) $limit === 0) {
                $this->listPromotion[$keyPromotion]->pull($keyGroup);
                break;
            }

            //Săp xếp số tiền từ cao đến thấp để tính ra số lượng discount lớn nhất
            $sortProducts = $promotion->sortByDESC(function ($q) {
                return $q->product->price;
            });
            // Tổng số lượng sản phẩm cần lấy
            $totalCount = $limit * $qtyProductOneCombo;
            // Tạo mảng các sản phẩm
            $arrayProductReal = collect();
            // Lấy ra các sản phẩm được hưởng khuyến mãi
            foreach ($sortProducts as $product) {
                if ($totalCount == 0) {
                    break;
                }
                for ($i = 0; $i < $product->qty; $i++) {
                    $arrayProductReal[] = $product->product;
                    $totalCount--;
                    if ($totalCount == 0) {
                        break;
                    }
                }
            }
            //Tính số tiền và lấy ra danh sách sản phẩm được giảm từ combo
            foreach ($arrayProductReal->chunk($qtyProductOneCombo) as $key => $products) {
                $priceTotalOne[$key] = 0;
                foreach ($products as $product) {
                    $priceTotalOne[$key] += $product->price;
                }
                switch ($promotion->data->type) {
                    case ComboHelper::TYPE_PERCENT:
                        $discount += round($priceTotalOne[$key] * $promotion->data->discount / 100);
                        break;
                    case ComboHelper::TYPE_MONEY:
                        $discount += $promotion->data->discount;
                        break;
                    case ComboHelper::TYPE_SPECIAL:
                        $discount += $priceTotalOne[$key] - $promotion->data->discount;
                        break;
                }
            }
            if ($discount > 0) {
                // Xử lý số combo được phép mua
                if (!isset($this->detailUsage[$keyPromotion])) {
                    $this->detailUsage[$keyPromotion] = collect();
                }

                $this->detailUsage[$keyPromotion][] = [
                    'item' => $combo,
                    'qty' => $limit,
                ];
                //Cập nhật lại số lượng sản phẩm khi đã đặt hàng
                $combo->qty_in_cart += $limit;
                $combo->save();
                // END
            }

            $productInCombo = $arrayProductReal->pluck('id')->unique();
            $productNotInCombo = $promotion->filter(function ($q) use ($productInCombo) {
                return !$productInCombo->contains($q->product->id);
            });

            foreach ($productNotInCombo as $keyProductItem => $itemProduct) {
                $this->listPromotion[$keyPromotion][$keyGroup]->pull($keyProductItem);
            }

            $this->listPromotion[$keyPromotion][$keyGroup]->productNotInCombo = $productNotInCombo;
            $this->listPromotion[$keyPromotion][$keyGroup]->productInCombo = $productInCombo;
            $this->listPromotion[$keyPromotion][$keyGroup]->discount = $discount;
        }
    }

    public function removeProductHadPromotion(Collection $groupPromotion, string $keyPromotion, array $arrayPromotionBefore)
    {
        $checkListProductHadPromotion = $this->getProductOfPromotion($arrayPromotionBefore);
        if ($checkListProductHadPromotion->count() == 0) {
            return;
        }

        foreach ($groupPromotion as $keyGroup => $group) {
            foreach ($group as $keyProduct => $product) {
                if ($checkListProductHadPromotion->contains($product->product->id)) {
                    $this->listPromotion[$keyPromotion][$keyGroup]->pull($keyProduct);
                }
            }
        }
    }

    public function getProductOfPromotion(array $promotions)
    {
        $list = collect();
        foreach ($promotions as $promotion) {
            switch ($promotion) {
                case 'combos':
                    if (isset($this->listPromotion[$promotion])) {
                        foreach ($this->listPromotion[$promotion] as $group) {
                            if (isset($group->productInCombo)) {
                                $list = $list->merge($group->productInCombo);
                            }
                        }
                    }
                    break;
                case 'deals':
                    if (isset($this->listPromotion[$promotion])) {
                        foreach ($this->listPromotion[$promotion] as $group) {
                            if (isset($group->productSubInDeal)) {
                                $list = $list->merge($group->productSubInDeal);
                            }
                            if (isset($group->productMainInDeal)) {
                                $list = $list->merge($group->productMainInDeal);
                            };
                        }
                    }
                    break;
                case 'flash_sales':
                    if (isset($this->listPromotion[$promotion])) {
                        foreach ($this->listPromotion[$promotion] as $group) {
                            if (isset($group->productInFlashSale)) {
                                $list = $list->merge($group->productInFlashSale);
                            }
                        }
                    }
                    break;
            }
        }
        return $list;
    }

    // Chia nhóm khuyến mãi để kiểm tra thỏa mãn điều kiện của chương trình khuyến mãi
    public function createGroupPromotion()
    {
        foreach ($this->items as $item) {
            foreach ($item->promotions as $key => $listPromotion) {
                if (!$this->listPromotion instanceof Collection) {
                    $this->listPromotion = collect();
                }
                if (!isset($this->listPromotion[$key])) {
                    $this->listPromotion[$key] = collect();
                }
                foreach ($listPromotion as $promotion) {
                    if (!isset($this->listPromotion[$key][$promotion->id])) {
                        $this->listPromotion[$key][$promotion->id] = collect();
                        $this->listPromotion[$key][$promotion->id]->data = $promotion;
                    }
                    $this->listPromotion[$key][$promotion->id][] = $item;
                }
            }
        }

        $newCollection = collect();
        $newKeyExitst = collect();
        foreach ($this->sortBy as $key) {
            if (isset($this->listPromotion[$key])) {
                $newCollection[$key] = $this->listPromotion[$key];
                $newKeyExitst[] = $key;
            }
        }
        $this->sortBy = $newKeyExitst;
        $this->listPromotion = $newCollection;
    }

    public static function getDiscount(string $promotion)
    {
        $listPromotion = static::get();
        $discount = 0;
        foreach ($listPromotion[$promotion] as $group) {
            $discount += $group->discount;
        }
        return $discount;
    }

    public function save()
    {
        return session()->put(self::KEY_SESSION_PROMOTION_LIST, $this);
    }

    public function get()
    {
        return session()->get(self::KEY_SESSION_PROMOTION_LIST);
    }

    public function flush()
    {
        return session()->forget(self::KEY_SESSION_PROMOTION_LIST);
    }

    public function getContentCart()
    {
        $idHasPromotion = $this->getProductOfPromotion(['flash_sales', 'deals', 'combos'])->unique();
        $listNormal = $this->items->filter(function ($q) use ($idHasPromotion) {
            return !$idHasPromotion->contains($q->product->id);
        });
        if ($listNormal->count() > 0) {
            $this->listPromotion['normal'] = collect();
            $this->listPromotion['normal'][] = $listNormal;
        }

        return $this->listPromotion;
    }

    public function getDiscountPromotion()
    {
        foreach ($this->listPromotion as $key => $promotion) {
            if ($key !== 'normal') {
                if (!isset($this->listDiscount[$key])) {
                    $this->listDiscount[$key] = collect();
                }
                if (!isset($this->listDiscount[$key]['discount'])) {
                    $this->listDiscount[$key]['discount'] = 0;
                }
                if (!isset($this->listDiscount[$key]['name'])) {
                    $this->listDiscount[$key]['name'] = '';
                }

                foreach ($promotion as $promotion) {
                    $this->listDiscount[$key]['discount'] += $promotion->discount ?? 0;
                    switch ($key) {
                        case 'combos':
                            $this->listDiscount[$key]['name'] = 'Chiết khấu từ Combo';
                            break;
                        case 'deals':
                            $this->listDiscount[$key]['name'] = 'Chiết khấu từ Deal sốc';
                            break;
                        case 'flash_sales':
                            $this->listDiscount[$key]['name'] = 'Chiết khấu từ Flash Sale';
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
        }
    }

    public function getDiscountForUser(){
        if(!Auth::check()) return;
        $user = Auth::user();
        $discount = $user->discount;
        $this->listDiscount['discount_of_user'] = collect([
            'name' => 'Chiết khấu theo tài khoản',
            'discount' => $this->totalPriceOrder * $discount / 100
        ]);
    }

    public function getTotalDiscount(){
        return $this->listDiscount->sum('discount');
    }

    public function getTotalPrice(){
        return $this->totalPriceOrder;
    }

    public function example()
    {
        $contentCarts = [];
        $listProduct = [];
        foreach ($contentCarts as $key => $item) {
            $listProduct[] = [
                'id' => $item->id,
                'rowId' => $key,
                'qty' => $item->qty,
                'item' => $item->model,
            ];
        }

        $groupMarketing = new PromotionCheck($listProduct);
        $groupMarketing->save();
    }
}

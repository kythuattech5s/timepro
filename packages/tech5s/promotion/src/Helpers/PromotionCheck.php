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
        C???n t??m m???ng n???m tr?????c
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

                    //Ki???m tra xem s???n ph???m ???? flash sale c?? s??? l?????ng hay kh??ng L???y s??? l?????ng ???????c gi???m cho flashsale hi??n t???i ????? khi x??a ho???c th??m th?? b??? ??i
                    if ($flash_sale->pivot->limit !== null) {
                        if (!isset($this->detailUsage[$keyPromotion])) {
                            $this->detailUsage[$keyPromotion] = collect();
                        }

                        $this->detailUsage[$keyPromotion][] = [
                            'item' => $group->data,
                            'product' => $product->product,
                            'qty' => $product->qty,
                        ];

                        //C???p nh???t l???i s??? l?????ng s???n ph???m khi ???? ?????t h??ng
                        $flash_sale_product = FlashSaleProduct::where('flash_sale_id', $flash_sale->id)->where('product_id', $product->product->id)->first();
                        $flash_sale_product->qty_in_cart = $flash_sale_product->qty_in_cart + $product->qty;
                        $flash_sale_product->save();
                    }
                }
            }
            //Ki???m tra n???u kh??ng c?? gi???m gi?? th?? x??a
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
                // T??nh s??? l?????ng gi???m gi?? trong deal
                foreach ($productSubInCart as $item) {
                    $this->listPromotion[$keyPromotion][$keyGroup][] = $item;
                    $deal = $item->product->dealSubCurrent()->where('deals.id', $group->data->id)->first();
                    $limit = $item->qty;
                    if ($deal->pivot->limit !== null && $deal->pivot->limit < $item->qty) {
                        $limit = $deal->pivot->limit;
                    }
                    $discount += $limit * $deal->pivot->price;
                }
                //Ki???m tra n???u kh??ng c?? gi???m gi?? th?? x??a
                if ($discount == 0) {
                    $this->listPromotion[$keyPromotion]->pull($keyGroup);
                    break;
                }
                $this->listPromotion[$keyPromotion][$keyGroup]->productSubInDeal = $productSubInCart->pluck('product.id');
                $this->listPromotion[$keyPromotion][$keyGroup]->discount = $discount;
            } else {
                $productSub = $group->data->productSub()->where('deal_product_subs.act', 1)->pluck('deal_product_subs.product_id');
                // L???y ra c??c s???n ph???m qu?? t???ng c?? trong gi??? h??ng
                $productSubInCart = $this->items->filter(function ($item) use ($productSub) {
                    return $productSub->contains($item->product->id);
                });

                $arrayProductReal = collect();
                $qtyGift = $group->data->qty;
                // T???o m???ng c??c s???n ph???m
                if ($productSubInCart->sum('qty') < $qtyGift) {
                    $qtyGift = $productSubInCart->sum('qty');
                    //Khi kh??ch h??ng kh??ng ch???n qu??
                }
                //S??p x???p s??? ti???n t??? cao ?????n th???p ????? t??nh ra s??? l?????ng discount l???n nh???t
                $sortProducts = $productSubInCart->sortByDESC(function ($q) {
                    return $q->product->price;
                });
                // L???y ra c??c s???n ph???m ???????c h?????ng khuy???n m??i
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
                //Ki???m tra n???u kh??ng c?? gi???m gi?? th?? x??a
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
            // L???y ra s??? l?????ng c???n trong 1 combo
            $qtyProductOneCombo = $promotion->data->qty;
            // S??? l?????ng combo c?? th??? mua
            // $limit = $promotion->data->limit;
            $limit = $promotion->data->limit - $combo->qty_in_cart;
            // T??nh s??? l?????ng combo c?? th??? mua ???????c theo s??? l?????ng th??m v??o gi??? h??ng
            $countSatisfy = $limit > 0 ? floor($promotion->sum('qty') / $combo->qty) : 0;

            //Ki???m tra n???u gi???i h???n l???n h??n s??? l?????ng combo c?? th??? th??m th?? gi???i h???n b???ng s??? l?????ng combo c?? th??? th??m
            if ($countSatisfy < $limit) {
                $limit = $countSatisfy;
            }

            //Ki???m tra n???u gi???i h???n ???????c ph??p b???ng 0 th?? x??a
            if ((int) $limit === 0) {
                $this->listPromotion[$keyPromotion]->pull($keyGroup);
                break;
            }

            //S??p x???p s??? ti???n t??? cao ?????n th???p ????? t??nh ra s??? l?????ng discount l???n nh???t
            $sortProducts = $promotion->sortByDESC(function ($q) {
                return $q->product->price;
            });
            // T???ng s??? l?????ng s???n ph???m c???n l???y
            $totalCount = $limit * $qtyProductOneCombo;
            // T???o m???ng c??c s???n ph???m
            $arrayProductReal = collect();
            // L???y ra c??c s???n ph???m ???????c h?????ng khuy???n m??i
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
            //T??nh s??? ti???n v?? l???y ra danh s??ch s???n ph???m ???????c gi???m t??? combo
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
                // X??? l?? s??? combo ???????c ph??p mua
                if (!isset($this->detailUsage[$keyPromotion])) {
                    $this->detailUsage[$keyPromotion] = collect();
                }

                $this->detailUsage[$keyPromotion][] = [
                    'item' => $combo,
                    'qty' => $limit,
                ];
                //C???p nh???t l???i s??? l?????ng s???n ph???m khi ???? ?????t h??ng
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

    // Chia nh??m khuy???n m??i ????? ki???m tra th???a m??n ??i???u ki???n c???a ch????ng tr??nh khuy???n m??i
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
                            $this->listDiscount[$key]['name'] = 'Chi???t kh???u t??? Combo';
                            break;
                        case 'deals':
                            $this->listDiscount[$key]['name'] = 'Chi???t kh???u t??? Deal s???c';
                            break;
                        case 'flash_sales':
                            $this->listDiscount[$key]['name'] = 'Chi???t kh???u t??? Flash Sale';
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
            'name' => 'Chi???t kh???u theo t??i kho???n',
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

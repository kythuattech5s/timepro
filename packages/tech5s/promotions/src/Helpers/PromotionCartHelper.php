<?php

namespace Tech5s\Promotion\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tech5sCart;

class PromotionCartHelper extends Controller
{   
    public function __construct()
    {
        parent::__construct();
    }
    public function getDiscountPromotion()
    {       
        $cartBuyProduct = $this->cartBuyProduct;
        $voucher = new VoucherCheck();
        $voucher->items = collect();
        $listProduct = [];
        foreach ($cartBuyProduct->content() as $rowid => $item) {
            $listProduct[] = [
                'qty' => $item->qty,
                'item' => $item->model,
                'rowId' => $item->rowId,
            ];

            $voucher->setItem([
                'id' => $item->id,
                'product' => $item->model,
                'rowId' => $item,
                'qty' => $item->qty,
                'price' => $item->price,
            ]);
        }

        $promotion = new PromotionCheck($listProduct);

        $promotion->save();
        if (!is_null($voucher->voucher)) {
            $voucher->checkUpdateContent($cartBuyProduct->totalFloat() - $promotion->getTotalDiscount());
        }
        return [$promotion, $voucher];
    }
}

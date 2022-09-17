<?php
namespace Tech5s\Promotion\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Tech5s\Promotion\Helpers\PromotionCheck;
use Tech5s\Promotion\Helpers\VoucherCheck;
use Tech5s\Promotion\Models\Voucher;

class ActionPromotionController extends Controller
{
    public function getListVoucher(Request $request)
    {
        $vouchers = Voucher::where(function ($q) {
            $q->where('is_public', 1);
        })->where('start_at', '<=', new \DateTime)->where('expired_at', '>=', new \DateTime)->act()->get();
        $voucherCurrent = new VoucherCheck();
        $voucherCurrent = $voucherCurrent->voucher;
        return response([
            'code' => 200,
            'html' => view('tech5spromotion::marketing.vouchers.out.item_voucher', compact('vouchers', 'voucherCurrent'))->render(),
        ]);
    }

    public function applyVoucher($voucherIdOrVoucherCode)
    {
        $cart = $this->cartBuyProduct;
        $price = $cart->totalFloat();
        $content = $cart->content();
        $voucher = new VoucherCheck($voucherIdOrVoucherCode);
        $listProduct = [];
        foreach ($content as $rowId => $product) {
            $voucher->setItem([
                'id' => $product->id,
                'product' => $product->model,
                'rowId' => $rowId,
                'qty' => $product->qty,
                'price' => $product->price,
            ]);

            $listProduct[] = [
                'qty' => $product->qty,
                'item' => $product->model,
                'rowId' => $product->rowId,
            ];
        };

        $promotion = new PromotionCheck($listProduct);

        $voucher->setTotalPrice($price - $promotion->getTotalDiscount());

        if (($checkContains = $voucher->checkContains())) {
            return response([
                'code' => 100,
                'message' => $checkContains,
            ]);
        };

        if (($checkTime = $voucher->checkTime())) {
            return response([
                'code' => 100,
                'message' => $checkTime,
            ]);
        }

        if ($checkLimit = $voucher->checkLimitVoucher()) {
            return response([
                'code' => 100,
                'message' => $checkLimit,
            ]);
        }

        if ($checkUserUsage = $voucher->checkUserUsageVoucher(Auth::id())) {
            return response([
                'code' => 100,
                'message' => $checkUserUsage,
            ]);
        }

        if ($checkProduct = $voucher->checkProductOfVoucher()) {
            return response([
                'code' => 100,
                'message' => $checkProduct,
            ]);
        }

        if (($checkMinumum = $voucher->checkSatisfyMinimum())) {
            return response([
                'code' => 100,
                'message' => $checkMinumum,
            ]);
        };

        if (($apply = $voucher->apply())) {
            return response([
                'code' => 100,
                'message' => $apply,
            ]);
        }

        $voucher->save();

        return response([
            'code' => 200,
            'total_final' => $price - $promotion->getTotalDiscount() - $voucher->discount,
            'message' => 'Áp dụng mã giảm giá thành công',
            'voucher_code' => $voucher->voucher->code,
        ]);
    }

    public function applyAndRemoveVoucher(Request $request)
    {
        $voucher = new VoucherCheck();

        if ($voucher->voucher == null) {
            return $this->applyVoucher($request->input('voucher_code',$request->input('voucher_id')));
        } else {
            $cart = $this->cartBuyProduct;
            $price = $cart->totalFloat();
            $content = $cart->content();
            foreach ($content as $rowId => $product) {
                $voucher->setItem([
                    'id' => $product->id,
                    'product' => $product->model,
                    'rowId' => $rowId,
                    'qty' => $product->qty,
                    'price' => $product->price,
                ]);

                $listProduct[] = [
                    'qty' => $product->qty,
                    'item' => $product->model,
                    'rowId' => $product->rowId,
                ];
            };

            $promotion = new PromotionCheck($listProduct);
            $voucher->removeVoucher();
            return response([
                'code' => 200,
                'remove' => true,
                'total_final' => $price - $promotion->getTotalDiscount(),
                'message' => 'Đã bỏ áp dụng mã giảm giá thành công',
            ]);
        }
    }
}

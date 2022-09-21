<?php

namespace Tech5s\Voucher\Helpers;

use App\Models\Order;
use Auth;
use DateTime;
use Illuminate\Support\Collection;
use Tech5s\Voucher\Models\Voucher;
use VoucherHelper;

class VoucherCheck
{
    const HAS_CHECK_LOGGED = false;
    public $voucher;
    public $discount = 0;
    public $totalPrice = 0;
    public $discountCurrent = 0;
    public $items;
    const SESSION_VOUCHER_ADD_CART = 'voucher_usage_cart';

    public function __construct($codeOrId = null)
    {
        $data = $this->getVoucher($codeOrId);
        if ($codeOrId == null && $data !== null) {
            $this->voucher = $data->voucher ?? null;
            $this->discount = $data->discount ?? 0;
            $this->totalPrice = $data->totalPrice ?? 0;
            $this->items = $data->items ?? collect();
        } else {
            $this->voucher = $data;
        }
    }

    public function getVoucher($codeOrId)
    {
        return $codeOrId == null ? session()->get(static::SESSION_VOUCHER_ADD_CART, false) : Voucher::where('id', $codeOrId)->orWhere('code', $codeOrId)->where('act', 1)->first();
    }

    public function setItem($data)
    {
        if (!$this->items instanceof Collection) {
            $this->items = collect();
        }

        $this->items[] = collect(
            [
                'id' => $data['id'],
                'item' => $data['product'],
                'qty' => $data['qty'],
                'price' => $data['price'],
                'rowId' => $data['rowId'],
            ]
        );
    }

    public function removeItem($rowId)
    {
        $this->items = $this->items->filter(function ($q) use ($rowId) {
            return $q['rowId'] !== $rowId;
        });
        $this->save();
    }

    public function refreshData($cart, $discount, $isUpdate = false)
    {
        foreach ($cart->content() as $rowId => $product) {
            $this->setItem([
                'id' => $product->id,
                'product' => $product->model,
                'qty' => $product->qty,
                'price' => $product->price,
                'rowId' => $rowId,
            ]);
        };
        return $this->checkUpdateContent($cart->totalFloat() - $discount, $isUpdate);
    }

    public function setDiscount($discount)
    {
        if ($this->voucher->max_discount !== null && $this->voucher->max_discount < $discount) {
            $discount = $this->voucher->max_discount;
        }

        $this->discount = $discount;
    }

    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    public function checkContains()
    {
        return $this->voucher == null ? 'Voucher không tồn tại' : false;
    }

    public function checkTime()
    {
        $start_at = new DateTime($this->voucher->start_at);
        $expired_at = new DateTime($this->voucher->expired_at);
        if ($start_at > new DateTime()) {
            return 'Vui lòng sử dụng voucher sau ' . $start_at->format('H:i d-m-Y');
        }

        if ($expired_at < new DateTime()) {
            return 'Voucher này đã hết thời gian sử dụng';
        }
        return false;
    }

    public function checkUserSatisfy($user_id, $statusDone)
    {
        $orders = Order::where('user_id', $user_id)->where('status', $statusDone)->count();
        if ($this->voucher->type_used == VoucherHelper::TYPE_USED_AFTER_BUY_ORDER && $orders < $this->voucher->type_used) {
            return 'Cần mua thêm đơn hàng để có thể áp dụng voucher';
        }
        return false;
    }

    public function save()
    {
        session()->put(static::SESSION_VOUCHER_ADD_CART, $this);
        return false;
    }

    public function checkLimitVoucher($isUpdate = 0)
    {
        return $this->voucher->countUsage() >= $this->voucher->limit + $isUpdate ? 'Voucher đã hết lượt sử dụng' : false;
    }

    public function checkUserUsageVoucher($user_id)
    {
        if (($user_id == null && static::HAS_CHECK_LOGGED) || ($user_id == null && $this->voucher->voucher_type == VoucherHelper::VOUCHER_TYPE_COIN)) {
            return 'Vui lòng đăng nhập để có thể sử dụng mã giảm giá';
        }

        $voucher_user = $this->voucher->users->first(function ($q) use ($user_id) {
            return $q->id == $user_id;
        });

        if ($voucher_user !== null) {
            return 'Bạn đã sử dụng voucher này không thể sử dụng nữa';
        }

        return false;
    }

    public function checkProductOfVoucher()
    {
        if ($this->items->count() == 0) {
            return 'Không có sản phẩm nào trong giỏ hàng';
        }

        if ($this->voucher->code_type == VoucherHelper::CODE_TYPE_PRODUCT && $this->getProductSatisfy()->count() == 0) {
            return 'Không có sản phẩm nào phù hợp để áp dụng mã giám giá';
        };
        return false;
    }

    public function apply($isUpdate = false)
    {
        if ($this->voucher->limit !== null && !$isUpdate) {
            $this->voucher->limit -= 1;
            $this->voucher->save();
        }

        if (Auth::check() && !$isUpdate) {
            $this->voucher->users()->attach(Auth::id());
        }

        switch ($this->voucher->voucher_type) {
            case VoucherHelper::VOUCHER_TYPE_COIN:
                return $this->applyReduceByPercent();
                break;
            case VoucherHelper::VOUCHER_TYPE_PROMOTION:
                return $this->applyReducePromotion();
                break;
        }
    }

    public function applyReducePromotion()
    {

        switch ($this->voucher->type_discount) {
            case VoucherHelper::DISCOUNT_MONEY:
                return $this->applyReduceByMoney();
                break;
            case VoucherHelper::DISCOUNT_PERCENT:
                return $this->applyReduceByPercent();
                break;
        }
        return false;
    }

    public function applyReduceByMoney()
    {
        $this->setDiscount($this->voucher->discount);
        return false;
    }

    public function checkSatisfyMinimum()
    {
        return $this->voucher->minimum_apply_voucher > $this->totalPrice ? 'Vui lòng mua thêm sản phẩm để có thể áp dụng mã giảm giá' : false;
    }

    public function applyReduceByPercent()
    {
        switch ($this->voucher->code_type) {
            case VoucherHelper::CODE_TYPE_SHOP:
                return $this->applyReduceByPercentForShop();
                break;

            case VoucherHelper::CODE_TYPE_PRODUCT:
                return $this->applyReduceByPercentForProduct();
                break;
        }
    }

    public function applyReduceByPercentForShop()
    {
        $this->setDiscount($this->totalPrice * $this->voucher->discount / 100);
    }

    public function applyReduceByPercentForProduct()
    {
        $listProductSatisfy = $this->getProductSatisfy();
        $totalPrice = $listProductSatisfy->sum(function ($item) {
            return $item['qty'] * $item['price'];
        });

        $this->setDiscount($totalPrice * $this->voucher->discount / 100);
    }

    public function getProductSatisfy()
    {
        return $this->items->filter(function ($item) {
            return $this->voucher->allProduct()->pluck('id')->contains($item['id']);
        });
    }

    public function removeVoucher()
    {
        if (session()->has(static::SESSION_VOUCHER_ADD_CART)) {
            session()->forget(static::SESSION_VOUCHER_ADD_CART);
        }
        if ($this->voucher->limit !== null) {
            $this->voucher->limit += 1;
            $this->voucher->save();
        }

        if (Auth::check()) {
            $this->voucher->users()->detach(Auth::id());
        }

        $this->voucher = null;
        $this->discount = 0;
        $this->totalPrice = 0;
        return false;
    }

    public function checkUpdateContent($price, $isUpdate = true)
    {
        $isUpdate = $isUpdate;
        $countUpdate = 1;
        $this->setTotalPrice($price);
        if (($message = $this->checkContains())
            ||
            ($message = $this->checkTime())
            ||
            ($message = $this->checkLimitVoucher($countUpdate))
            ||
            ($message = $this->checkUserUsageVoucher(\Auth::id()))
            ||
            ($message = $this->checkProductOfVoucher())
            ||
            ($message = $this->checkSatisfyMinimum())
            ||
            ($message = $this->apply($isUpdate))
            ||
            ($message = $this->save())
        ) {
            $this->removeVoucher();
            return $message;
        }
        return false;
    }
}

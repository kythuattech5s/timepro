<?php

namespace Tech5s\Promotion\Controllers\Marketing\Abstracts;

use DateTime;
use Tech5s\Promotion\Controllers\Marketing\Condition\FlashSaleCondition;
use Tech5s\Promotion\Controllers\Marketing\Traits\OldDataFlashSale;
use Tech5s\Promotion\Models\FlashSale;
use Tech5s\Promotion\Models\FlashSaleProduct;

class FlashSaleContruct extends FlashSaleCondition
{
    use OldDataFlashSale;
    public $flash_sale;
    public $products;
    public $product_real;
    public $product_delete;
    public $product_no_active;
    public $product_current;
    const PREFIX_SESSION_PRODUCT = 'PROMOTION_PRODUCT';
    const PREFIX_SESSION_FLASH_SALE = 'FLASH_SALE';
    const PREFIX_SESSION_PRODUCT_REAL = 'FLASH_SALE_PRODUCT_REAL';
    const PREFIX_SESSION_PRODUCT_DELETE = 'FLASH_SALE_PRODUCT_DELETE';
    const PREFIX_SESSION_PRODUCT_NO_ACTIVE = 'FLASH_SALE_PRODUCT_NO_ACTIVE';
    const PREFIX_SESSION_PRODUCT_CURRENT = 'FLASH_SALE_PRODUCT_CURRENT';

    public function __construct($id = null)
    {
        if (session()->has(static::PREFIX_SESSION_FLASH_SALE) && is_null($id)) {
            $this->flash_sale = session()->get(static::PREFIX_SESSION_FLASH_SALE);
            $this->products = session()->get(static::PREFIX_SESSION_PRODUCT, collect());
            $this->product_real = session()->get(static::PREFIX_SESSION_PRODUCT_REAL, collect());
            $this->product_delete = session()->get(static::PREFIX_SESSION_PRODUCT_DELETE, collect());
            $this->product_no_active = session()->get(static::PREFIX_SESSION_PRODUCT_NO_ACTIVE, collect());
        } else {
            $this->flash_sale = is_null($id) ? new FlashSale : FlashSale::with(['products' => function ($q) {
                $q->with(['propertyProduct' => function ($q) {
                    $q->with(['propertyProductDetails' => function ($q) {
                        $q->with(['property']);
                    }]);
                }]);
            }])->find($id);
            $this->product_current = $this->setProductCurrent();
            $this->products = $this->setProductParent();
            $this->product_real = $this->setProductRealCurrent();
            $this->product_no_active = $this->setProductNoActiveCurrent();
            $this->product_delete = $this->setProductDeleteCurrent();
        }
    }

    public function setStartAt(DateTime $start_at)
    {
        $this->flash_sale->start_at = $start_at;
    }

    public function setExpiredAt(DateTime $expired_at)
    {
        $this->flash_sale->expired_at = $expired_at;
    }

    public function setAct(int $act = 1)
    {
        $this->flash_sale->act = $act;
    }

    public function setOrd(int $ord = 0)
    {
        $this->flash_sale->ord = $ord;
    }

    public function setData()
    {
        $request = request();
        $this->setStartAt(new DateTime($request->input('start_at')));
        $this->setExpiredAt(new DateTime($request->input('expired_at')));
        $this->setAct();
        $this->setOrd();
    }

    public function setName(string $name)
    {
        $this->flash_sale->name = $name;
    }

    public function saveSessionFlashSale()
    {
        session()->put(static::PREFIX_SESSION_FLASH_SALE, $this->flash_sale);
    }

    public function saveProduct()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT, $this->products);
    }

    public function saveProductReal()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_REAL, $this->product_real);
    }

    public function saveItemProductDelete()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_DELETE, $this->product_delete);
    }

    public function saveItemProductNoActive()
    {
        session()->put(static::PREFIX_SESSION_PRODUCT_NO_ACTIVE, $this->product_no_active);
    }

    public function setItemProduct($itemData)
    {
        $this->removeItemProduct($itemData['id']);
        $this->product_real[] = $itemData;
    }

    public function removeItemProduct($id)
    {
        $this->product_real = $this->product_real->filter(function ($q) use ($id) {
            return (int) $q['id'] !== (int) $id;
        });
    }

    public function removeItemProductNoActive($id)
    {
        $this->product_no_active = $this->product_no_active->filter(function ($q) use ($id) {
            return (int) $q['id'] !== (int) $id;
        });
    }

    public function getSessionFlashSale()
    {
        $this->flash_sale = session()->get(static::PREFIX_SESSION_FLASH_SALE);
    }

    public function setItemProductDelete($id)
    {
        $this->product_delete[] = $id;
    }

    public function checkRemoveItemDB($id)
    {
        if (isset($this->flash_sale->id)) {
            $product = FlashSaleProduct::where('product_id', $id)->where('flash_sale_id', $this->flash_sale->id)->first();
            if ($product !== null) {
                $product->delete();
            }
        }
    }

    public function setDataProduct()
    {
        foreach ($this->product_no_active->merge($this->product_real) as $itemProduct) {
            $this->setDataItem($itemProduct);
        }
    }

    public function setDataItem($itemProduct)
    {
        $item = FlashSaleProduct::where('flash_sale_id', $this->flash_sale->id)->where('product_id', $itemProduct['id'])->first();
        if ($item == null) {
            $item = new FlashSaleProduct;
        }
        $item->product_id = $itemProduct['id'];
        $item->price = $itemProduct['price'];
        $item->flash_sale_id = $this->flash_sale->id;
        $item->act = $itemProduct['act'] ?? 0;
        $item->limit = $itemProduct['limit'] ?? null;
        $item->qty = $itemProduct['qty'] ?? null;
        $item->percent = $itemProduct['percent'] ?? null;
        $item->save();
    }

    public function saveFlashSale()
    {
        $this->flash_sale->save();
        $this->setDataProduct();
        $this->flush();
    }

    public function setItemProductNoActive($dataItem)
    {
        $this->removeItemProductNoActive($dataItem['id']);
        $this->product_no_active[] = $dataItem;
    }

    public function flush()
    {
        session()->forget(static::PREFIX_SESSION_FLASH_SALE);
        session()->forget(static::PREFIX_SESSION_PRODUCT);
        session()->forget(static::PREFIX_SESSION_PRODUCT_DELETE);
        session()->forget(static::PREFIX_SESSION_PRODUCT_REAL);
        session()->forget(static::PREFIX_SESSION_PRODUCT_NO_ACTIVE);
    }
}

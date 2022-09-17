<?php
namespace Tech5s\Promotion\Controllers\Marketing\Traits;

use Tech5s\Promotion\Controllers\Marketing\Abstracts\FlashSaleContruct;
use Tech5s\Promotion\Models\Product;

trait OldDataFlashSale
{
    public function setProductParent()
    {
        $parents = $this->product_current->groupBy('parent');
        $this->products = collect();
        foreach ($parents as $key => $parent) {
            if ($key != "") {
                $this->products[] = $key;
            } else {
                foreach ($parent as $product) {
                    $this->products[] = $product->id;
                }
            }
        }
        $this->saveProduct();
        return $this->products;
    }

    public function setProductRealCurrent()
    {
        $products = $this->product_current->filter(function ($q) {
            return $q->pivot->act == 1;
        });
        $this->product_real = collect();
        foreach ($products as $product) {
            $data = [
                'id' => $product->pivot->product_id,
                'price' => $product->pivot->price,
                'qty' => $product->pivot->qty,
                'act' => $product->pivot->act,
                'limit' => $product->pivot->limit,
                'percent' => $product->pivot->percent,
            ];
            $this->setItemProduct($data);
        }
        return $this->product_real;
    }

    public function setProductDeleteCurrent()
    {
        $products = Product::with('variants')->whereIn('id', $this->products)->get();
        $ids = collect();
        foreach ($products as $product) {
            if ($product->variants->count() > 0) {
                foreach ($product->variants as $itemProduct) {
                    $ids[] = $itemProduct->id;
                }
            } else {
                $ids[] = $product->id;
            }
        }
        $this->product_delete = $ids->filter(function ($id) {
            return !$this->product_real->merge($this->product_no_active)->pluck('id')->contains($id);
        });
        return $this->product_delete;
    }

    public function setProductNoActiveCurrent()
    {
        $products = $this->product_current->filter(function ($q) {
            return $q->pivot->act == null || $q->pivot->act == 0;
        });
        $this->product_no_active = collect();
        foreach ($products as $product) {
            $data = [
                'id' => $product->pivot->product_id,
                'price' => $product->pivot->price,
                'qty' => $product->pivot->qty,
                'act' => $product->pivot->act,
                'limit' => $product->pivot->limit,
                'percent' => $product->pivot->percent,
            ];
            $this->setItemProductNoActive($data);
        }
        return $this->product_no_active;
    }

    public function setProductCurrent()
    {
        $this->product_current = $this->flash_sale->products;
        $this->saveProductCurrent();
        return $this->product_current;
    }

    public function saveProductCurrent()
    {
        session()->put(FlashSaleContruct::PREFIX_SESSION_PRODUCT_CURRENT, $this->product_current);
    }
}

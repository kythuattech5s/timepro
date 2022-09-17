<?php
namespace Tech5s\Promotion\Controllers\Marketing\Traits;

use Tech5s\Promotion\Controllers\Marketing\Abstracts\ComboContruct;
use Tech5s\Promotion\Models\Product;

trait OldDataCombo
{
    public function setProduct()
    {
        return $this->product_current->pluck('id');
    }

    public function setComboOld()
    {

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
                'act' => $product->pivot->act,
            ];
            $this->setProductReal($data);
        }
        return $this->product_real;
    }

    public function setProductDeleteCurrent()
    {
        $products = Product::with('variants')->whereIn('id', $this->products)->get();
        $ids = collect();
        foreach ($products as $product) {
            if ($product->variants()->count() > 0) {
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
                'act' => $product->pivot->act,
            ];
            $this->setProductNoActive($data);
        }
        return $this->product_no_active;
    }

    public function setProductCurrent()
    {
        $this->product_current = $this->combo->products;

        $this->saveProductCurrent();
        return $this->product_current;
    }

    public function saveProductCurrent()
    {
        session()->put(ComboContruct::PREFIX_SESSION_PRODUCT_CURRENT, $this->product_current);
    }
}

<?php

namespace Tech5s\Promotion\Controllers\Marketing\Traits;

trait OldDataDeal
{
    public function setProductMainOld()
    {
        return $this->deal->productMain->pluck('id');
    }

    public function setProductMainRealOld()
    {
        $collect = collect();
        foreach ($this->deal->productMain as $item) {
            if ($item->pivot->act == 1) {
                $collect[] = [
                    'id' => $item->id,
                    'act' => 1,
                ];
            }
        }
        return $collect;
    }

    public function setProductMainNoActiveOld()
    {
        $collect = collect();
        foreach ($this->deal->productMain as $item) {
            if ($item->pivot->act !== 1) {
                $collect[] = [
                    'id' => $item->id,
                    'act' => 0,
                ];
            }
        }
        return $collect;
    }

    public function setProductSubOld()
    {
        $collect = collect();
        foreach ($this->deal->productSub as $product) {
            if ($product->parent == null) {
                $collect[] = $product->id;
            } else {
                $collect[] = $product->parent;
            }
        }
        return $collect->unique();
    }

    public function setProductSubRealOld()
    {
        $collect = collect();
        foreach ($this->deal->productSub as $item) {
            if ($item->pivot->act == 1) {
                $collect[] = [
                    'id' => $item->id,
                    'act' => 1,
                    'percent' => $item->pivot->percent,
                    'price' => $item->pivot->price,
                    'limit' => $item->pivot->limit,
                ];
            }
        }
        return $collect;
    }
    public function setProductSubNoActiveOld()
    {
        $collect = collect();
        foreach ($this->deal->productSub as $item) {
            if ($item->pivot->act !== 1) {
                $collect[] = [
                    'id' => $item->id,
                    'act' => 0,
                    'percent' => $item->pivot->percent,
                    'price' => $item->pivot->price,
                    'limit' => $item->pivot->limit,
                ];
            }
        }
        return $collect;
    }
}

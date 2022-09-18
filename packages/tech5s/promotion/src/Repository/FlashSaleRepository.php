<?php

namespace Tech5s\Promotion\Repository;

use App\Models\Course;
use Illuminate\Support\Collection;
use Tech5s\Promotion\Helpers\FlashSaleDetailHelper;
use Tech5s\Promotion\Models\FlashSale;

class FlashSaleRepository
{
    public $courses;
    public function __construct(FlashSale $flashSale)
    {
        $this->courses = $flashSale->cources;
    }

    public function getListProduct()
    {
        if ($this->courses->count() > 0) {
            $itemCurrent = $this->getItemCurrent();
            $listItem = $this->getItemReal($itemCurrent);
            return $listItem;
            return;
        } else {
            return false;
        }
    }

    public function getItemCurrent()
    {
        $itemCurrent = collect();
        foreach ($this->courses as $course) {
            $itemCurrent[] = $course->id;
        }
        $itemCurrent = $itemCurrent->unique();
        session()->put(FlashSaleDetailHelper::SESSION_PRODUCT_CURRENT, $itemCurrent);
        return $itemCurrent;
    }

    public function getItemReal(Collection $itemCurrent)
    {
        $courses = Course::with('timePackage')->whereIn('id', $itemCurrent)->get();
        $itemReal = collect();
        $itemDelete = collect();

        foreach ($courses as $course) {
            $times = $course->timePackage;
            if ($times->count() > 0) {
                foreach ($times as $time) {
                    $course = $this->courses->first(function ($q) use ($time) {
                        return $q->id == $time->id;
                    });
                    if ($course !== null) {
                        $itemReal[] = $this->createProductItem($course);
                    } else {
                        $itemDelete[] = $this->createProductRemove($course);
                    }
                }
            } else {
                $course = $this->products->first(function ($q) use ($course) {
                    return $q->id == $course->id;
                });

                if ($course !== null) {
                    $itemReal[] = $this->createProductItem($course);
                }
            }
        }
        $listItems = Course::whereIn('id', $itemCurrent)->with('variants', function ($q) use ($itemDelete) {
            if ($itemDelete !== null) {
                $q->whereNotIn('id', $itemDelete->pluck('id'));
            }
        })->get();
        session()->put(FlashSaleDetailHelper::SESSION_PRODUCT_REMOVE, $itemDelete);
        session()->put(FlashSaleDetailHelper::SESSION_PRODUCT_REAL, $itemReal);
        return $listItems;
    }

    public function createProductItem($product)
    {
        return [
            'id' => $product->id,
            'limit' => $product->pivot->limit,
            'qty' =>  $product->pivot->qty,
            'act' =>  $product->pivot->act,
            'percent' =>  $product->pivot->percent,
            'price' =>  $product->pivot->price,
        ];
    }

    public function createProductRemove($product)
    {
        return [
            'id' => $product->id,
            'parent' => $product->parent
        ];
    }
}

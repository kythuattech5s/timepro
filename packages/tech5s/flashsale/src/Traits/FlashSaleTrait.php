<?php
namespace Tech5s\FlashSale\Traits;

use App\Models\CourseCategory;
use Tech5s\Promotion\Helpers\PromotionHelper;
use Tech5s\Promotion\Models\PromotionType;

trait FlashSaleTrait
{
    public function getTypeComparision()
    {
        switch ($this->promotion_type_comparison_id) {
            case 1:
                return 'Bằng';
                break;
            case 2:
                return 'Lớn hơn';
                break;
            case 3:
                return 'Nhỏ hơn';
                break;
            default:
                break;
        }
    }

    public function promotionType()
    {
        return $this->belongsTo(PromotionType::class);
    }

    public function getProductAndCategory($onlyProduct = false)
    {
        list($listItems) = PromotionHelper::createProducts($this);
        if ($onlyProduct) {
            return $listItems;
        }
        $listCourseCategory = CourseCategory::select(['id', 'name'])->whereHas('course', function ($q) use ($listItems) {
            $q->whereIn('courses.id', $listItems->pluck('id'))->where('courses.act', 1);
        })->act()->ord()->get();
        
        return [$listCourseCategory, $listItems];
    }
}

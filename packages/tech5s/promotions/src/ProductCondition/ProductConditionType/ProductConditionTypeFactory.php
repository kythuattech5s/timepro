<?php
namespace Tech5s\Promotion\ProductCondition\ProductConditionType;
use Tech5s\Promotion\Models\ProductConditionType as ProductConditionTypeModel;
class ProductConditionTypeFactory
{
    public static function get(ProductConditionTypeModel $productConditionType)
    {
        $class = "Tech5s\Promotion\ProductCondition\ProductConditionType\\".$productConditionType->type;
        return new $class($productConditionType);
    }
}
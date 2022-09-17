<?php
namespace Tech5s\Promotion\ProductCondition\ProductConditionType;
use Tech5s\Promotion\Models\{ProductCondition,Product,PropertyCategory,Property as PropertyModel};
class Property extends ProductConditionType
{
	public function getConditionTypeCondition()
	{
		$listPropertyCategory = PropertyCategory::get();
		$ret = [];
		foreach ($listPropertyCategory as $itemPropertyCategory) {
			$itemCondition = new ItemCondition($itemPropertyCategory->name,$this->model->type,$itemPropertyCategory->id);
			array_push($ret, $itemCondition);
		}
		return $ret;
	}
	public function getNameShow($mapId = null)
    {
    	$propertyCategory = PropertyCategory::find($mapId);
    	if (!isset($propertyCategory)) {
        	return $this->model->name;
    	}
    	return $propertyCategory->name;
    }
    public function getListItemSelecter($mapId = null)
    {
        return PropertyModel::where('property_category_id',$mapId)->get();
    }
    public function getListProductIdCondition($conditionId,$value,$mapId = null)
    {
        $property = PropertyModel::find($value);
        $productCondition = ProductCondition::find($conditionId);
        $listProductId = $property->products()->get()->pluck('id');
        switch ($productCondition->type) {
            case 'Is':
                return $listProductId;
                break;
            case 'IsNot':
                return Product::whereNotIn('id',$listProductId);
                break;
            default:
            	return [];
                break;
        }
    }
}
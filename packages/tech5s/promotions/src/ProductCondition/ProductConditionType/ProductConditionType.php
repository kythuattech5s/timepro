<?php
namespace Tech5s\Promotion\ProductCondition\ProductConditionType;
use Tech5s\Promotion\Models\{Product,ProductCondition};
class ProductConditionType
{
    protected $model;
    protected $config;
    public function __construct($model)
    {
        $this->model = $model;
        $this->config = $model->getConfig();
    }
    public function getConditionTypeCondition()
    {
        $itemCondition = new ItemCondition($this->model->name,$this->model->type);
        return [$itemCondition];
    }
    public function getNameShow($mapId = null)
    {
        return $this->model->name;
    }
    public function getTypeShow()
    {
        return $this->config['typeShow'] ?? '';
    }
    public function getModel()
    {
        return $this->model;
    }
    public function getConditionList()
    {
        $arrayConditionListId = isset($this->config['conditionList']) ? explode(',', $this->config['conditionList']):[];
        return $this->model->getConditionList($arrayConditionListId);
    }
    public function getListItemSelecter($mapId = null)
    {
        return [];
    }
    public function loadListItemSelecter($mapId = null)
    {
        return [];
    }
    public function getListProductIdCondition($conditionId,$value,$mapId = null)
    {
        $baseProduct = Product::query();
        $productCondition = ProductCondition::find($conditionId);
        switch ($productCondition->type) {
            case 'Is':
                $baseProduct->where('id',$value);
                break;
            case 'IsNot':
                $baseProduct->where('id','!=',$value);
                break;
            case 'IsOneOf':
                $baseProduct->whereIn('id',explode(',',$value));
                break;
            case 'IsNotOneOf':
                $baseProduct->whereNotIn('id',explode(',',$value));
                break;
            default:
                break;
        }
        return $baseProduct->pluck('id');
    }
}
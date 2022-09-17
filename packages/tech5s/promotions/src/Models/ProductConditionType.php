<?php
namespace Tech5s\Promotion\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tech5s\Promotion\ProductCondition\ProductConditionType\ProductConditionTypeFactory;
use Tech5s\Promotion\Helpers\Helper;
class ProductConditionType extends Model
{
    use HasFactory;
    public function getInstance()
    {
        return ProductConditionTypeFactory::get($this);
    }
    public function isValidConfig()
    {
        $config = Helper::extractJson($this->config);
        if (!isset($config['typeShow']) || !isset($config['conditionList'])) {
            return false;
        }
        return true;
    }
    public function getConfig()
    {
        return Helper::extractJson($this->config);
    }
    public function getConditionList($arrayId)
    {
        return ProductCondition::whereIn('id',$arrayId)->get();
    }
}
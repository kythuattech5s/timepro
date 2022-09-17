<?php
namespace Tech5s\Promotion;
use Tech5s\Promotion\Helpers\Helper;
use Tech5s\Promotion\Models\{CatalogPriceRule,ProductConditionType as ProductConditionTypeModel,Product,CatalogPriceRuleProduct};
class CatalogPrice
{
    public function initIndexProductCatalogPrice()
    {
        CatalogPriceRuleProduct::query()->truncate();
        $listCatalogPriceRule = CatalogPriceRule::where('act',1)->where('end','>=',now())->get();
        $ret = [];
    	foreach ($listCatalogPriceRule as $itemCatalogPriceRule) {
            $countItemIndex = $this->indexProduct($itemCatalogPriceRule);
            array_push($ret,['catalog_price_rule_id'=>$itemCatalogPriceRule->id,'countItemIndex'=>$countItemIndex]);
    	}
        return $ret;
    }

    private function indexProduct($itemCatalogPriceRule){
        $baseProduct = Product::query();
        $conditionInfo = Helper::extractJson($itemCatalogPriceRule->conditions);
        $count = [];
        if (isset($conditionInfo['listCondition']) && count($conditionInfo['listCondition']) > 0) {
            foreach ($conditionInfo['listCondition'] as $itemCondition) {
                $productConditionTypeModel = ProductConditionTypeModel::find($itemCondition['type']);
                $productConditionType = $productConditionTypeModel->getInstance();
                $listProductIdCondition = $productConditionType->getListProductIdCondition($itemCondition['condition'],$itemCondition['value'],$itemCondition['mapId']);
                if ($conditionInfo['mainConditionType'] == 1) {
                    if ($conditionInfo['mainConditionValue'] == 0) {
                        $baseProduct->whereNotIn('id',$listProductIdCondition);
                    }else{
                        $baseProduct->whereIn('id',$listProductIdCondition);
                    }
                }else{
                    if ($conditionInfo['mainConditionValue'] == 0) {
                        $baseProduct->orWhereNotIn('id',$listProductIdCondition);
                    }else{
                        $baseProduct->orWhereIn('id',$listProductIdCondition);
                    }
                }
                /**
                 * Kiểm tra có số lượng thì lưu vào mảng để tạo pivot
                 */
                if(isset($itemCondition['count'])){
                    foreach(explode(',',$itemCondition['count']) as $id){
                        array_push($count,$id);
                    }
                }
            }
        }
        $listProduct = $baseProduct->get();
        $dataAdd = [];
        foreach ($listProduct as $key => $itemProduct) {
            $itemDataAdd = [];
            $itemDataAdd['product_id'] = $itemProduct->id;
            $itemDataAdd['catalog_price_rule_id'] = $itemCatalogPriceRule->id;
            if(isset($count[$key])){
                $itemDataAdd['qty_apply'] = $count[$key];
            }
            array_push($dataAdd, $itemDataAdd);
        }
        if (count($dataAdd) > 0) {
            CatalogPriceRuleProduct::insert($dataAdd);
        }
        return count($dataAdd);
    }
    public function getPriceProduct($product)
    {
        $listCatalogPriceRuleProductId = CatalogPriceRuleProduct::where('product_id',$product->id)->pluck('catalog_price_rule_id');

    }
}

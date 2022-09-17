<?php
namespace Tech5s\Promotion\ProductCondition\ProductConditionType;

use Tech5s\Promotion\Models\Product;
use Tech5s\Promotion\Models\ProductCondition;

class Count extends ProductConditionType
{
    public function loadListItemSelecter($mapId = null)
    {
    	$code = request()->code ?? null;
    	$name = request()->name ?? null;
        $listItems = Product::whereDoesntHave('variants')
        					->when($code,function($q) use ($code){
        						$q->where('code','like','%'.$code.'%');
					        })
       						->when($name,function($q) use ($name){
        						$q->where('name','like','%'.$name.'%');
					        })
        					->paginate(10);
        return view('tech5spromotion::admin.product_condition.select_item.count.list_item_selecter',compact('listItems','code','name'));
    }

    public function getListProductIdCondition($conditionId, $value, $mapId = null)
    {
        $baseProduct = Product::query();
        
        $productCondition = ProductCondition::find($conditionId);
            
        switch ($productCondition->type) {
            case 'Is':
                $baseProduct->where('code',$value);
                break;
            case 'IsNot':
                $baseProduct->where('code','!=',$value);
                break;
            case 'IsOneOf':
                $baseProduct->whereIn('code',explode(',',$value));
                break;
            case 'IsNotOneOf':
                $baseProduct->whereNotIn('code',explode(',',$value));
                break;
            default:
                break;
        }

        return $baseProduct->pluck('id');
    }
}

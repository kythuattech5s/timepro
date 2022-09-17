<?php

namespace Tech5s\Promotion\ProductCondition\ProductConditionType;

use App\Models\ProductCategory as BaseProductCategoryModal;
use Tech5s\Promotion\Models\{Product, ProductCondition};

class ProductCategory extends ProductConditionType
{
    private function createProductCategory($listProductCategory)
    {
        $ret = '';
        if ($listProductCategory->count() > 0) {
            $ret .= '<ul>';
            foreach ($listProductCategory as $item) {
                $ret .= '<li class="' . (count($item->recursiveChilds) == 0 ? 'no-child' : '') . '">';
                if (count($item->recursiveChilds) > 0) {
                    $ret .= '<span class="btn-drop-child-cate"><i class="fa fa-plus" aria-hidden="true"></i></span>';
                } else {
                    $ret .= '<span class="dem"></span>';
                }
                $ret .= '<label><input type="checkbox" value="' . $item->id . '"><span>' . $item->name . '</span></label>';
                $ret .= $this->createProductCategory($item->recursiveChilds);
                $ret .= '</li>';
            }
            $ret .= '</ul>';
        }
        return $ret;
    }
    public function loadListItemSelecter($mapId = null)
    {
        $listItems = BaseProductCategoryModal::whereNull('parent')->with('recursiveChilds')->get();
        $html = $this->createProductCategory($listItems);
        return view('tech5spromotion::admin.product_condition.select_item.product_category.list_item_selecter', compact('html'));
    }
    public function getListProductIdCondition($conditionId, $value, $mapId = null)
    {
        $baseProductCategory = BaseProductCategoryModal::query();
        $productCondition = ProductCondition::find($conditionId);
        switch ($productCondition->type) {
            case 'Is':
                $baseProductCategory->where('id', $value);
                break;
            case 'IsNot':
                $baseProductCategory->where('id', '!=', $value);
                break;
            case 'IsOneOf':
                $baseProductCategory->whereIn('id', explode(',', $value));
                break;
            case 'IsNotOneOf':
                $baseProductCategory->whereNotIn('id', explode(',', $value));
                break;
            default:
                break;
        }
        $productCategoryResult = $baseProductCategory->with(['products' => function ($q) {
            $q->with('variants');
        }])->get();
        $ret = [];
        foreach ($productCategoryResult as $itemCate) {
            foreach ($itemCate->products as $itemProduct) {
                foreach ($itemProduct->variants as $itemProductVariant) {
                    array_push($ret, $itemProductVariant->id);
                }
            }
        }
        return array_unique($ret);
    }
}

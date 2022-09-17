<?php
namespace Tech5s\Promotion\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use vanhenry\manager\controller\BaseAdminController;
use Tech5s\Promotion\Models\{ProductConditionType,ProductCondition};
class Controller extends BaseAdminController
{
	public function __construct() {
		parent::__construct();
    	$this->middleware('h_users',['except'=>['viewDetail']]);
    }
    public function loadItemCondition()
    {
    	$listProductConditionType = ProductConditionType::where('act',1)->get();
    	$val = request()->val ?? '';
    	if ($val == '') {
    		return response()->json(['code' => 100,'message' => 'Không tìm thấy kiểu dữ liệu']);
    	}
		$infoCondition = explode('_', $val);
		if (count($infoCondition) == 0) {
    		return response()->json(['code' => 100,'message' => 'Không tìm thấy kiểu dữ liệu']);
    	}
    	$type = $infoCondition[0];
    	$productConditionTypeModal = ProductConditionType::where('type',$type)->first();
    	if (!isset($productConditionTypeModal)) {
    		return response()->json(['code' => 100,'message' => 'Không tìm thấy kiểu điều kiện']);
    	}
    	if (!$productConditionTypeModal->isValidConfig()) {
    		return response()->json(['code' => 100,'message' => $productConditionTypeModal->name.' Sai config. Vui lòng kiểm tra lại.']);
    	}
    	$mapId = $infoCondition[1] ?? null;
    	$productConditionType = $productConditionTypeModal->getInstance();
    	$nameShow = $productConditionType->getNameShow($mapId);
    	$defaultValue = null;
    	return response()->json([
			'code' => 200,
			'message' => 'Thành công',
			'html' => view('tech5spromotion::admin.product_condition.base_item_condition',compact('productConditionType','mapId','nameShow','defaultValue'))->render()
		]);
    }
    public function loadItemSelecter()
    {
    	$idProductConditionType = request()->item ?? 0;
    	$mapId = request()->map ?? null;
    	$productConditionTypeModal = ProductConditionType::find($idProductConditionType);
    	if (!isset($productConditionTypeModal)) {
    		return '<p class="no-item-seleter p-3">Không tìm thấy item nào!</p>';
    	}
    	$productConditionType = $productConditionTypeModal->getInstance();
    	return $productConditionType->loadListItemSelecter($mapId);
    }
}

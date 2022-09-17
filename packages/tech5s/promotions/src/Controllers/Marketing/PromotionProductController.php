<?php
namespace Tech5s\Promotion\Controllers\Marketing;

use Illuminate\Http\Request;
use Tech5s\Promotion\Controllers\Marketing\Abstracts\PromotionProductContruct;
use Tech5s\Promotion\Models\ProductDayConfig;
use Tech5s\Promotion\Models\PromotionProduct;
use vanhenry\manager\controller\BaseAdminController;

class PromotionProductController extends BaseAdminController
{
    public function formAdd()
    {
        $day_configs = ProductDayConfig::all();
        return view('tech5spromotion::marketing.promotion_products.add', compact('day_configs'));
    }

    public function show($id)
    {
        $currentItem = PromotionProduct::find($id);
        $day_configs = ProductDayConfig::all();
        return view('tech5spromotion::marketing.promotion_products.edit', compact('day_configs', 'currentItem'));
    }

    public function copy($id)
    {
        $currentItem = PromotionProduct::find($id);
        $day_configs = ProductDayConfig::all();
        return view('tech5spromotion::marketing.promotion_products.copy', compact('day_configs', 'currentItem'));
    }

    public function store(Request $request)
    {
        $promotion_product = new PromotionProductContruct();
        $promotion_product->setDataPromotion();
        if (($message_check_time = $promotion_product->checkTimeCreate())) {
            return response([
                'code' => 100,
                'message' => $message_check_time,
            ]);
        }
        $promotion_product->save();

        return response([
            'code' => 200,
            'message' => 'Tạo chương trình giảm giá thành công',
            'redirect_url' => base64_decode($request->input('returnurl')),
        ]);
    }

    public function update(Request $request, $id)
    {
        $promotion_product = new PromotionProductContruct($id);
        $promotion_product->setDataPromotion();
        $promotion_product->checkTimeUpdate();
        if (($message_check_time = $promotion_product->checkTimeCreate())) {
            return response([
                'code' => 100,
                'message' => $message_check_time,
            ]);
        }
        $promotion_product->save();

        return response([
            'code' => 200,
            'message' => 'Cập nhật chương tình thành công',
            'redirect_url' => base64_decode($request->input('returnurl')),
        ]);
    }

    public function checkTime(Request $request)
    {

    }

}

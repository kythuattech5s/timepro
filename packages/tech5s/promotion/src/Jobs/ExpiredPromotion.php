<?php

namespace Tech5s\Promotion\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ShopPointRS\Models\PointType;
use VoucherShopHelper;

class ExpiredPromotion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($events)
    {
        foreach ($events as $event) {
            switch ($event['type']) {
                case 'flash_sale':
                    $flashSale = $event['data'];
                    foreach ($flashSale->shopFlashSales as $shopFlashSale) {
                        foreach ($shopFlashSale->shopFlashSaleProductTable as $item) {
                            Product::plusOrMinusAvailable($item->product_id, $item->qty, false);
                        }
                    }
                    break;
                case 'voucher_shop':
                    $voucherShop = $event['data'];
                    if ($voucherShop->voucher_type == VoucherShopHelper::VOUCHER_TYPE_POINT) {
                        $shop = $voucherShop->shop;
                        $shopPoint = $shop->shopPoint;
                        $totalPointUsed = $voucherShop->getPointUsed();
                        $totalPoint = $voucherShop->totalPoint();
                        $point = $totalPoint - $totalPointUsed;
                        $shopPoint->updatePoint($point, true, PointType::REFUND, 'Hoàn ' . $point . ' point còn lại cho shop khi hết thời gian mã giảm giá');
                    }
                    break;
            }
            $event['data']->is_expired = 1;
            $event['data']->save();
        }
    }
}

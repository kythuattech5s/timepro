<?php
namespace Tech5s\Promotion\Controllers;

use DateTime;
use DB;
use Illuminate\Http\Request;
use Shop\Promotion\Models\ShopVoucher;
use Tech5s\Promotion\Models\Combo;
use Tech5s\Promotion\Models\Deal;
use Tech5s\Promotion\Models\FlashSale;
use Tech5s\Promotion\Models\Voucher;

class ExpiredController extends Controller
{
    public function expiredPromotion(Request $request)
    {
        set_time_limit(0);
        $events = collect();

        $deals = Deal::where('expired_at', '<', new DateTime())->whereNull('is_expired')->get();
        foreach ($deals as $deal) {
            $events[] = [
                'type' => 'deal',
                'data' => $deal,
            ];
        }

        $vouchers = Voucher::where('expired_at', '<', new DateTime())->whereNull('is_expired')->get();
        foreach ($vouchers as $voucher) {
            $events[] = [
                'type' => 'voucher',
                'data' => $voucher,
            ];
        }

        $combos = Combo::where('expired_at', '<', new DateTime())->whereNull('is_expired')->get();
        foreach ($combos as $combo) {
            $events[] = [
                'type' => 'combo',
                'data' => $combo,
            ];
        }

        $flash_sales = FlashSale::where('expired_at', '<', new DateTime())->whereNull('is_expired')->get();
        foreach ($flash_sales as $flash_sale) {
            $events[] = [
                'type' => 'flash_sale',
                'data' => $flash_sale,
            ];
        }

        $voucher_shops = ShopVoucher::where('expired_at', '<', new DateTime())->whereNull('is_expired')->get();
        foreach ($voucher_shops as $voucher_shop) {
            $events[] = [
                'type' => 'voucher_shop',
                'data' => $voucher_shop,
            ];
        }

        DB::beginTransaction();

        event('expired.promotion', [$events]);

        DB::commit();
    }
}

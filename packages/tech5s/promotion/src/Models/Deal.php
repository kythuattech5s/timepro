<?php

namespace Tech5s\Promotion\Models;

use App\Models\Product;
use App\Models\Shop;
use Auth;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shop\Promotion\Helpers\DealShopHelper;
use Shop\Promotion\Traits\ScopeStatus;

class Deal extends BaseModel
{
    use HasFactory, ScopeStatus;
    public function productMain()
    {
        return $this->belongsToMany(Product::class, 'deal_product_mains', 'deal_id', 'product_id')->withPivot('act');
    }

    public function productSub()
    {
        return $this->belongsToMany(Product::class, 'deal_product_subs', 'deal_id', 'product_id')
            ->orderByRaw('(CASE WHEN deal_product_subs.ord is not null then deal_product_subs.ord end) DESC')
            ->withPivot('price', 'percent', 'limit', 'act', 'ord');
    }

    public static function getProducts()
    {
        $deals = self::where('start_at', '<=', new DateTime())->where('expired_at', '>=', new DateTime())->where('act', 1)->get();
        $products = Product::whereHas('dealMain', function ($q) use ($deals) {
            $q->whereIn('deal_id', $deals->pluck('id'));
        })->limit(4)->get();
        return $products;
    }

    public static function getData()
    {
        $request = request();
        $listItems = self::query()->where('shop_id', Auth::user()->shop->id);
        switch ($request->input('status')) {
            case 'happenning':
                $listItems->where('start_at', '<=', new DateTime())->where('expired_at', '>=', new DateTime());
                break;
            case 'upcoming':
                $listItems->where('start_at', '>', new DateTime())->where('expired_at', '>', new DateTime());
                break;
            case 'finished':
                $listItems->where('expired_at', '<=', new DateTime())->where('start_at', '<=', new DateTime());
                break;
        }
        $listItems = $listItems->orderBy('id', 'DESC')->paginate(5);
        return $listItems;
    }

    public function getType()
    {
        switch ($this->type) {
            case DealShopHelper::TYPE_DEAL:
                return 'Mua Kèm Deal Sốc';
                break;
            case DealShopHelper::TYPE_GIFT:
                return 'Mua Để Nhận Quà';
                break;
        }
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}

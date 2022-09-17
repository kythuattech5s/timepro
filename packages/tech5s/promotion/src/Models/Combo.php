<?php

namespace Tech5s\Promotion\Models;

use App\Models\Product;
use App\Models\Shop;
use Auth;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tech5s\Promotion\Helpers\ComboHelper;
use Tech5s\Promotion\Traits\Promotion;
use Tech5s\Promotion\Traits\ScopeStatus;

class Combo extends BaseModel
{
    use HasFactory, Promotion, ScopeStatus;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'combo_products', 'combo_id', 'product_id')->withPivot('act');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
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
        $listItems = $listItems->orderBy('created_at', 'DESC')->paginate(5);
        return $listItems;
    }

    public function getDescriptionCombo()
    {
        switch ($this->type) {
            case ComboHelper::TYPE_MONEY:
                return 'Mua ' . $this->qty . ' sản phẩm để được giảm ' . number_format($this->discount, 0, '.', ',') . ' đ';
                break;
            case ComboHelper::TYPE_PERCENT:
                return 'Mua ' . $this->qty . ' sản phẩm để được giảm ' . $this->discount . ' %';
                break;
            case ComboHelper::TYPE_SPECIAL:
                return 'Mua ' . $this->qty . ' sản phẩm chỉ với giá ' . number_format($this->discount, 0, '.', ',') . ' đ';
                break;
        }
    }

    public function getType()
    {
        switch ($this->type) {
            case ComboHelper::TYPE_MONEY:
                return 'Giảm giá theo số tiền';
                break;
            case ComboHelper::TYPE_PERCENT:
                return 'Giảm giá theo phần trăm';
                break;
            case ComboHelper::TYPE_SPECIAL:
                return 'Giảm giá đặc biệt';
                break;
        }
    }
}

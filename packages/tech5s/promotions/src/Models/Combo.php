<?php

namespace Tech5s\Promotion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Product;
use Tech5s\Promotion\Controllers\Marketing\Traits\Promotion;
use ComboHelper;

class Combo extends BaseModel
{
    use HasFactory, Promotion;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'combo_products', 'combo_id', 'product_id')->withPivot('act');
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
}

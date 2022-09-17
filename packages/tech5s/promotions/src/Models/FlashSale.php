<?php

namespace Tech5s\Promotion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Product;
class FlashSale extends BaseModel
{
     use HasFactory;

    public function products(){
        return $this->belongsToMany(Product::class,'flash_sale_products','flash_sale_id','product_id')->withPivot('price','act','qty','limit','percent','qty_in_cart');
    }
}

?>

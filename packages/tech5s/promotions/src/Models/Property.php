<?php
namespace Tech5s\Promotion\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Property extends Model
{
    use HasFactory;
    public function products(){
        return $this->belongsToMany(Product::class,'property_products','properties','product_id');
    }
}
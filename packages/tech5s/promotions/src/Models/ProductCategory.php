<?php
namespace Tech5s\Promotion\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProductCategory extends Model
{
    use HasFactory;
    public function products(){
        return $this->belongsToMany(Product::class);
    }
    public function childs()
    {
        return $this->hasMany(ProductCategory::class, 'parent', 'id');
    }
    public function recursiveChilds()
    {
        return $this->childs()->with('recursiveChilds');
    }
}
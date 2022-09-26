<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use stdClass;

class CourseComboTimePackage extends BaseModel
{
    use HasFactory;

    public function getPrice(){
        return $this->price;
    }
    public function getPriceInfo()
    {
        $priceInfo = new stdClass;
        $priceInfo->price = $this->price;
        $priceInfo->price_old = $this->price_old;
        return $priceInfo;
    }
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CourseComboTimePackage extends BaseModel
{
    use HasFactory;

    public function getPrice(){
        return $this->price;
    }
}
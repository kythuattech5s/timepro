<?php
namespace App\Models;
class OrderDetail extends BaseModel
{
    public function getTypeName()
    {
        switch ($this->type) {
            case 'course':
                return 'Khóa học';
                break;
            case 'vip':
                return 'Gói Vip';
                break;
            default:
                return '';
                break;
        }
    }
}
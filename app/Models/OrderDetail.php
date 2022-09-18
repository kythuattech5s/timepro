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
    public function getRealItem()
    {
        switch ($this->type) {
            case 'course':
                return Course::baseView()->find($this->map_id);
                break;
            case 'vip':
                return CourseCombo::baseView()->find($this->map_id);
                break;
            default:
                break;
        }
    }
}
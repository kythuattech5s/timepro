<?php
namespace App\Models;
class OrderType extends BaseModel
{
    const ORDER_COURSE = 1; // Đơn hàng khóa học
    const ORDER_DEPOSIT_WALLET = 2; // Đơn hàng nạp tiền
}
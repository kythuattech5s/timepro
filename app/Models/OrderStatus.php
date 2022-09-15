<?php
namespace App\Models;
class OrderStatus extends BaseModel
{
    const WAIT_PAYMENT = 1; // Chờ thanh toán
    const PAID = 2; // Đã thanh toán
    const CANCEL = 3; // Đã hủy
}
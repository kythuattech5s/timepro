<?php

namespace Roniejisa\Comment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_SUCCESS = 5;
    const STATUS_RATING = 6;
    const STATUS_EXPIRED_REFUND = 7;
    use HasFactory;
}
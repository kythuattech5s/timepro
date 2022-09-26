<?php

namespace Tech5s\Notify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    use HasFactory;

    const COMMENT_COURSE = 1;
    const REPLY_COURSE = 2;
}

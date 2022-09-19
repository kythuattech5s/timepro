<?php

namespace Tech5s\Notify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationCatalog extends Model
{
    use HasFactory;

    const COMMENT_COURSE = 1;

    public function notifications(){
        return $this->hasMany(Notification::class);
    }
}

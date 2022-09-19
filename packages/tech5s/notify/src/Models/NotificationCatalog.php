<?php

namespace Tech5s\Notify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationCatalog extends Model
{
    use HasFactory;

    public function notifications(){
        return $this->hasMany(Notification::class);
    }
}

<?php

namespace Tech5s\Promotion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function scopeAct($query)
    {
        return $query->where('act', 1);
    }

    public function scopeOrd($query)
    {
        return $query->orderByRaw('(CASE WHEN ord is not null then ord end) DESC')->orderBy('id', 'desc');
    }
}

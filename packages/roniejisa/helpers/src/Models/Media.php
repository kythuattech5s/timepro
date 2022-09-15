<?php

namespace Roniejisa\Helpers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    public function getAllRow()
    {
        return $this->hasMany(MediaTableDetail::class);
    }

    public function childs()
    {
        return $this->hasMany(Media::class, 'parent', 'id')->with('childs');
    }
}

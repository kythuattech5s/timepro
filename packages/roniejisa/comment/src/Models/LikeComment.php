<?php

namespace Roniejisa\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LikeComment extends Model
{
    use HasFactory;

    protected $fillable = ['comment_id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

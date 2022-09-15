<?php

namespace CommentRS\Traits;

use CommentRS\Models\Comment;

trait HasCommentOrder
{
    public function comments()
    {
        return $this->hasMany(Comment::class, 'order_id', 'id');
    }
}

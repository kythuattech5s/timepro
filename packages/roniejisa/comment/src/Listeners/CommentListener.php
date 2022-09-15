<?php
namespace Roniejisa\Comment\Listeners;

use Roniejisa\Comment\Jobs\BuildDataRatingForProduct;

class CommentListener
{
    public function subscribe($events)
    {
        $events->listen('comment.build.data', BuildDataRatingForProduct::class);
    }
}

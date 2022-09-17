<?php
namespace Tech5s\Promotion\Listeners;

use Tech5s\Promotion\Jobs\ExpiredPromotion;

class PromotionListener
{
    public function subscribe($events)
    {
        $events->listen('expired.promotion', ExpiredPromotion::class);
    }
}

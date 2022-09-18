<?php
namespace App\Listeners;
use App\Jobs\SendMailStatic;
class ManagerSubscribe
{
    public function subscribe($events)
    {
        $events->listen('notification.user', function($data,$type,$user){
            $this->sendNotificationUser($data,$type,$user);
        });

        $events->listen('sendmail.static', SendMailStatic::class);
    }

    public function sendNotificationUser($data,$type,$user){
        $user->sendNotification($data,$type);
    }
}

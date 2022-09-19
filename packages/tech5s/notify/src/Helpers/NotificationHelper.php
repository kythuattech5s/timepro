<?php
namespace Tech5s\Notify\Helpers;

use Tech5s\Notify\Notifications\UserNotification;

class NotificationHelper
{
    public static function send($users, array $data, int $type_id)
    {
        \Notification::send($users, new UserNotification([
            'link' => $data['link'],
            'img' => $data['img'],
            'icon' => $data['icon'],
            'title' => $data['title'],
            'body' => $data['body'],
        ], $type_id));
    }
}

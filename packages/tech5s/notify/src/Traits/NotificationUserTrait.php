<?php
namespace Tech5s\Notify\Traits;

use Illuminate\Notifications\Notifiable;
use Tech5s\Notify\Models\Notification;
use Tech5s\Notify\Models\NotificationCatalog;
use Tech5s\Notify\Notifications\UserNotification;

trait NotificationUserTrait
{
    use Notifiable;

    /**
     * @param array $data [string 'link',string 'img',string 'icon',string  'title',string 'body']
     */
    public function sendNotification(array $data, NotificationCatalog $catalog, $type = null)
    {
        $this->notify(new UserNotification([
            'link' => $data['link'] == '' ? 'javascript:void(0)'  : $data['link'],
            'img' => $data['img'] == null ? $catalog->img : $data['img'],
            'icon' => $data['icon'] == null ? $catalog->icon : $data['icon'],
            'title' => $data['title'],
            'body' => $data['body'],
        ], $catalog, $type));
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

}

<?php

namespace Tech5s\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Tech5s\Notify\Channels\CustomDatabase;
use Tech5s\Notify\Models\NotificationCatalog;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;
    public $catalog;
    public $type;

    /**
     * Khởi tạo thông báo
     * @param array $data
     * @param int $type_id
     *
     *
     */
    public function __construct($data, NotificationCatalog $catalog, $type = null)
    {
        $this->data = $data;
        $this->catalog = $catalog;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return [CustomDatabase::class];
    }

    public function toDatabase($notifiable)
    {
        return $this->data;
    }

    public function databaseType($notifiable)
    {
        return get_class($notifiable);
    }
}

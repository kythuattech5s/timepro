<?php

namespace Tech5s\Notify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
        'notification_type_id',
        'notification_catalog_id',
    ];

    public function getType()
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function checkRead()
    {
        return $this->unread() ? 'no-read' : '';
    }

    public function catalog()
    {
        return $this->belongsTo(NotificationCatalog::class, 'notification_catalog_id', 'id');
    }
}

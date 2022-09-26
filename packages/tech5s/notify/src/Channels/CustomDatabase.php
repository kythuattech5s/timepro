<?php

namespace Tech5s\Notify\Channels;

use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class CustomDatabase
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param   $notification
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function send($notifiable, $notification)
    {   
        if ($notifiable instanceof Collection) {
            foreach ($notifiable as $notifiable) {
                $notifiable->routeNotificationFor('database', $notification)->create(
                    $this->buildPayload($notifiable, $notification)
                );
            }
        } else {
            return $notifiable->routeNotificationFor('database', $notification)->create(
                $this->buildPayload($notifiable, $notification)
            );
        }
    }

    /**
     * Get the data for the notification.
     *
     * @param  mixed  $notifiable
     * @param   $notification
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function getData($notifiable, $notification)
    {
        if (method_exists($notification, 'toDatabase')) {
            return is_array($data = $notification->toDatabase($notifiable))
            ? $data : $data->data;
        }

        if (method_exists($notification, 'toArray')) {
            return $notification->toArray($notifiable);
        }

        throw new RuntimeException('Notification is missing toDatabase / toArray method.');
    }

    /**
     * Build an array payload for the DatabaseNotification Model.
     *
     * @param  mixed  $notifiable
     * @param    $notification
     * @return array
     */
    protected function buildPayload($notifiable, $notification)
    {   
        return [
            'id' => $notification->id,
            'type' => method_exists($notification, 'databaseType')
            ? $notification->databaseType($notifiable)
            : get_class($notification),
            'data' => $this->getData($notifiable, $notification),
            'read_at' => null,
            'notification_catalog_id' => $notification->catalog->id,
            'notification_type_id' => $notification->type->id ?? null,
        ];
    }
}

<?php

namespace Mediumart\Orange\Laravel\Notifications;

use Mediumart\Orange\SMS\SMS;
use Illuminate\Notifications\Notification;
use Mediumart\Notifier\Contracts\Channels\Dispatcher;

class OrangeSMSChannel implements Dispatcher
{
    /**
     * @var \Mediumart\Orange\SMS\SMS
     */
    private $client;

    /**
     * OrangeSMSChannel constructor.
     * @param \Mediumart\Orange\SMS\SMS $client
     */
    public function __construct(SMS $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        return $this->sendMessage($notification->toOrange($notifiable));
    }

    /**
     * Send the given notification message.
     * 
     * @param  OrangeMessage $message 
     * @return mixed
     */
    public function sendMessage(OrangeMessage $message)
    {
        return $this->client->to($message->to)
                            ->from($message->from)
                            ->message($message->text)
                            ->send();
    }
}

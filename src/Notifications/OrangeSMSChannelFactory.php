<?php 

namespace Mediumart\Orange\Laravel\Notifications;

use Illuminate\Support\Facades\App;
use Mediumart\Notifier\Contracts\Channels\Factory; 

class OrangeSMSChannelFactory implements Factory
{
    /**
     * Check for the driver capacity.
     *
     * @param  string $driver
     * @return bool
     */
    public static function canHandleNotification($driver)
    {
        return in_array($driver, ['orange']);
    }

    /**
     * Create a new driver instance.
     *
     * @param  $driver
     * @return \Mediumart\Notifier\Contracts\Channels\Dispatcher
     */
    public static function createDriver($driver)
    {
        return static::canHandleNotification($driver)
            ? new OrangeSMSChannel(App::make('orange-sms')) : null;
    }
}

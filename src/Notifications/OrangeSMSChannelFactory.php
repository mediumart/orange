<?php 

namespace Mediumart\Orange\Laravel\Notifications;

use Illuminate\Support\Facades\App;

class OrangeSMSChannelFactory
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
     * @return mixed
     */
    public static function createDriver($driver)
    {
        return static::canHandleNotification($driver)
            ? new OrangeSMSChannel(App::make('orange-sms')) : null;
    }
}

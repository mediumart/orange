# mediumart orange

## Description
A laravel adapter for orange api services.

## Installation

Using composer:
```
$ composer require mediumart/orange
```

If you are using laravel 5 prior to version 5.5, add this to your `config/app.php` inside the `'providers'` array

```php
Mediumart\Orange\Laravel\OrangeServiceProvider::class
```

## Configuration

Next open the `config/services.php` and add a key for the `orange>sms` service like this:

    'orange' => [
        'sms' => [
            'client_id' => '<client_id>',
            'client_secret' => '<client_secret>'
        ]
    ]

Using these credentials, a `token` will be *fetched* and *cached*, and then automatically be *renewed* a few days before its expiration.

## How to use

You can resolve an `SMS` client instance from the `Container` like this:

```php
$sms = app('orange-sms');
```

The documentation on how to use the `$sms` client instance can be found [here](https://github.com/mediumart/orange-sms)

### Using Notifications

There is two way of setting the package up to run with notifications. 

First, like stated in the [laravel documentation](https://laravel.com/docs/5.4/notifications#custom-channels), you may simply return the channel class name from the `via` method of any of your notifications:

```php
use Mediumart\Orange\Laravel\Notifications\OrangeSMSChannel;

/**
 * Get the notification channels.
 *
 * @param  mixed  $notifiable
 * @return array|string
 */
public function via($notifiable)
{
    return [OrangeSMSChannel::class];
}
```

The second method consist on making use of the [mediumart/notifier](https://github.com/mediumart/notifier) library, that ships with this package, and will allow you to return the string `'orange'` as the driver hook, instead of the channel class name from the `via` method like above.

Next, you need a `toOrange` method to return an instance of `\Mediumart\Orange\Laravel\Notifications\OrangeMessage::class`, in any notification that will use the `OrangeSMSChannel` channel.

```php
use Mediumart\Orange\Laravel\Notifications\OrangeMessage;

/**
 * Get the orange sms representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return OrangeMessage
 */
public function toOrange($notifiable)
{
    return (new OrangeMessage)->to('+237690000000')
                              ->from('+237690000000')
                              ->text('Sample text')     
}
```

## License

Mediumart orange is an open-sourced software licensed under the [MIT license](https://github.com/mediumart/orange/blob/master/LICENSE.txt).

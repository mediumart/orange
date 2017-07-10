# mediumart orange

[![Build Status](https://travis-ci.org/mediumart/orange.svg?branch=master)](https://travis-ci.org/mediumart/orange)
[![Latest Stable Version](https://poser.pugx.org/mediumart/orange/v/stable)](https://packagist.org/packages/mediumart/orange)
[![License](https://poser.pugx.org/mediumart/orange/license)](https://packagist.org/packages/mediumart/orange)

## Description
A laravel wrapper/adapter for orange api services.

## Installation

Using composer:

```
$ composer require mediumart/orange
```

If you are using laravel 5.3+ prior to version 5.5, add this to your `config/app.php` inside the `'providers'` array

```php
Mediumart\Orange\Laravel\OrangeServiceProvider::class
```

## SMS Api

### Configuration

Open the `config/services.php` and add a key for the `orange>sms` service like this:

    'orange' => [
        'sms' => [
            'client_id' => '<client_id>',
            'client_secret' => '<client_secret>'
        ]
    ]

Using these credentials, a `token` will be *fetched* and *cached*, and then automatically be *renewed* a few days before its expiration.

### How to use

You can resolve an `SMS` client instance from the `Container` like this:

```php
$sms = app('orange-sms');
```

The documentation on how to use the `$sms` client instance can be found [here](https://github.com/mediumart/orange-sms)

#### Using Notifications

There is two way of setting the package up to run with notifications. 

First, like stated in the [laravel documentation](https://laravel.com/docs/master/notifications#custom-channels), you may simply return the channel class name from the `via` method of any of your notifications:

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

The second method consist on making use of the [mediumart/notifier](https://github.com/mediumart/notifier) library, that will allows you to return a custom hook name(in this case: 'orange') instead of the class name from the `via` method.

```php
/**
 * Get the notification channels.
 *
 * @param  mixed  $notifiable
 * @return array|string
 */
public function via($notifiable)
{
    return ['orange'];
}
```

To use the `mediumart/notifier` library, first install the package:

```
$ composer require mediumart/notifier
```

and add the service provider in the `config/app.php` providers array, if necessary:

```php
Mediumart\Notifier\NotifierServiceProvider::class
```

Then you will need to declare a **public** property(array) named `notificationsChannels` inside your `App\Providers\AppServiceProvider.php` in order to register the channel like this:

```php
/**
 * $notificationsChannels.
 * 
 * @var array
 */
public $notificationsChannels = [
    \Mediumart\Orange\Laravel\Notifications\OrangeSMSChannel::class,
];
```

**Creating the Message**

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

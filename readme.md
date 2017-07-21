# mediumart orange

[![Build Status](https://travis-ci.org/mediumart/orange.svg?branch=master)](https://travis-ci.org/mediumart/orange)
[![Coverage Status](https://coveralls.io/repos/github/mediumart/orange/badge.svg?branch=master)](https://coveralls.io/github/mediumart/orange?branch=master)
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
Mediumart\Orange\OrangeServiceProvider::class
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

Or using type hinting

```php
use Mediumart\Orange\SMS\SMS;

public function index(SMS $sms) 
{
    /.../
}
```

The documentation on how to use the `$sms` client instance can be found [here](https://github.com/mediumart/orange-sms)

## License

Mediumart orange is an open-sourced software licensed under the [MIT license](https://github.com/mediumart/orange/blob/master/LICENSE.txt).

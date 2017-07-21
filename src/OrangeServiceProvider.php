<?php

namespace Mediumart\Orange;

use Mediumart\Orange\SMS\SMS;
use Illuminate\Support\ServiceProvider;
use Mediumart\Orange\SMS\Http\SMSClient;

class OrangeServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register Services boundaries
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('orange-sms-access-token', function ($app) {
            return new AccessToken;
        });

        $this->app->bind('orange-sms-client', function ($app) {
            $token = $app->make('orange-sms-access-token');

            return SMSClient::getInstance($token());
        });

        $this->app->bind('orange-sms', function ($app) {
            return new SMS($app->make('orange-sms-client'));
        });

        $this->app->alias('orange-sms', SMS::class);

        $this->app->alias('orange-sms-client', SMSClient::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['orange-sms', 'orange-sms-client', SMSClient::class, SMS::class];
    }
}

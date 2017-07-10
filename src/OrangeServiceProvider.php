<?php

namespace Mediumart\Orange;

use Carbon\Carbon;
use Mediumart\Orange\SMS\SMS;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Mediumart\Orange\SMS\Http\SMSClient;
use Mediumart\Orange\SMS\Exceptions\InvalidCredentialsException;

class OrangeServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * 90 days.
     * 
     * @var integer
     */
    protected $api_token_default_expires_time_in_seconds = 7776000;

    /**
     * Register Services boundaries
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('orange-sms-client', function($app) {
           return SMSClient::getInstance($this->getClientToken());
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
        return [
            'orange-sms',
            'orange-sms-client',
            SMSClient::class,
            SMS::Class,
        ];
    }

    /**
     * Get the token from the cache.
     *
     * @return mixed
     */
    public function getClientToken()
    {
        return Cache::remember('orange.sms.token', $this->getCacheDuration(), function () {
            $response = $this->authorize();
            return isset($response['access_token']) ? $response['access_token'] : $this->throwsException($response);
        });
    }

    /**
     * Get the token cache duration in minutes.
     * // cache duration: 80 days.
     * 
     * @return integer
     */
    public function getCacheDuration()
    {
        return Carbon::now()->addMinutes(
            ($this->api_token_default_expires_time_in_seconds/60) - (240*60)
        )->diffInMinutes();
    }

    /**
     * Fetch api access_token.
     * 
     * @return array
     */
    public function authorize()
    {
        return SMSClient::authorize(
            config('services.orange.sms.client_id'),
            config('services.orange.sms.client_secret')
        );
    }

    /**
     * Throws exceptions.
     *
     * @param $response
     * @throws \Mediumart\Orange\SMS\Exceptions\InvalidCredentialsException
     */
    protected function throwsException($response)
    {
        if (isset($response['error']) && $response['error'] === 'invalid_client') {
            throw new InvalidCredentialsException($response['error_description']);
        }
    }
}

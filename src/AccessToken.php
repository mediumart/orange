<?php 

namespace Mediumart\Orange;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Mediumart\Orange\SMS\Http\SMSClient;
use Mediumart\Orange\SMS\Exceptions\InvalidCredentialsException;

class AccessToken
{
    /**
     * 90 days in seconds.
     * 
     * @var integer
     */
    protected $defaultExpiresIn = 7776000;

    /**
     * invoke class as a method.
     * 
     * @return string  access_token
     * 
     * @throws InvalidCredentialsException
     */
    public function __invoke()
    {
        return Cache::remember('orange.sms.token', $this->cacheTime(),
            function () {
                if (isset(($response = $this->authorize())['access_token'])) {
                    return $response['access_token'];
                }

                throw new InvalidCredentialsException('Invalid client credentials');
            }
        );
    }

    /**
     * Process Api authorization.
     * 
     * @return array
     */
    public function authorize()
    {
        return SMSClient::authorize(config('services.orange.sms.client_id'), config('services.orange.sms.client_secret'));
    }

    /**
     * Get the token cache time in minutes.
     * // cache duration: 80 days.
     * 
     * @return integer
     */
    protected function cacheTime()
    {
        return Carbon::now()
            ->addMinutes(($this->defaultExpiresIn/60) - (240*60))
                ->diffInMinutes();
    }
}

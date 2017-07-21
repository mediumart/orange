<?php

namespace Mediumart\Orange\Tests;

use Mockery as m;
use Mediumart\Orange\SMS\SMS;
use Mediumart\Orange\AccessToken;
use Mediumart\Orange\SMS\Http\SMSClient;
use Mediumart\Orange\OrangeServiceProvider;

class OrangeServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function register_sms_instance()
    {
        $this->app->instance('orange-sms-access-token', $token = m::mock(AccessToken::class.'[__invoke]'));
        $token->shouldReceive('__invoke')->andReturn($this->token);

        $this->assertInstanceOf(SMS::class, $this->app->make('orange-sms'));

        // test aliases.
        $this->assertInstanceOf(SMS::class, $this->app->make(SMS::class));
        $this->assertInstanceOf(SMSClient::class, $this->app->make(SMSClient::class));
    }

    /** 
     * @test
     */
    public function register_sms_access_token_instance() 
    {
        $this->assertInstanceOf(AccessToken::class, $this->app->make('orange-sms-access-token'));
    }

    /**
     * @test
     */
    public function provided_services()
    {
        $provider = $this->app->getProvider(OrangeServiceProvider::class);
        $this->assertEquals(['orange-sms', 'orange-sms-client', SMSClient::class, SMS::class], $provider->provides());
    }
}

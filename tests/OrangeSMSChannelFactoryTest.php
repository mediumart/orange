<?php

namespace Orange\Laravel\Tests;

use Mockery;
use Mediumart\Orange\SMS\Http\SMSClient;
use Mediumart\Notifier\Contracts\Channels\Dispatcher;
use Mediumart\Orange\Laravel\Notifications\OrangeSMSChannelFactory;

class OrangeSMSChannelFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function can_handle_notification()
    {
        $this->assertTrue(OrangeSMSChannelFactory::canHandleNotification('orange'));
    }

    /**
     * @test
     */
    public function create_driver()
    {
        $this->app->instance('orange-sms-client', Mockery::mock(SMSClient::getInstance()));

        $this->assertInstanceOf(Dispatcher::class, OrangeSMSChannelFactory::createDriver('orange'));
    }
}

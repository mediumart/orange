<?php

namespace Orange\Laravel\Tests;

use Mediumart\Orange\SMS\SMS;
use Mediumart\Orange\SMS\Http\SMSClient;
use Mediumart\Orange\Laravel\Notifications\OrangeMessage;
use Mediumart\Orange\Laravel\Notifications\OrangeSMSChannel;

class OrangeSMSChannelTest extends TestCase
{
    /**
     * @test
     */
    public function can_send_message()
    {
        $SMSClient = \Mockery::mock(SMSClient::getInstance());
        $client = \Mockery::spy(SMS::class.'[send]', [$SMSClient]);
        $client->shouldReceive('send')->andReturn(true);

        $channel = new OrangeSMSChannel($client);
        $this->assertTrue($channel->sendMessage(
            (new OrangeMessage())->to('+237690000000')->from('+237690000000')->text('test')
        ));
    }
}

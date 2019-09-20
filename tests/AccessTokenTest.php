<?php

namespace Mediumart\Orange\Tests;

use Mockery as m;
use Mediumart\Orange\AccessToken;
use Illuminate\Support\Facades\Cache;

class AccessTokenTest extends TestCase
{
    /**
     * @test
     */
    public function cache_get_remember_access_token()
    {
        $accessToken = m::mock(AccessToken::class.'[authorize]');
        $accessToken->shouldReceive('authorize')->andReturn(['access_token' => $this->token]);

        $this->assertEquals($this->token, $accessToken());

        $this->assertTrue(Cache::has('orange.sms.token'));
        $this->assertEquals($this->token, Cache::get('orange.sms.token'));
    }

    /**
     * @test
     */
    public function get_client_token_invalid_credentials_exception()
    {
        $accessToken = m::mock(AccessToken::class.'[authorize]');
        $accessToken->shouldReceive('authorize')->andReturn(['error' => 'error']);

        $this->expectException('\Mediumart\Orange\SMS\Exceptions\InvalidCredentialsException');
        $accessToken();
    }
}

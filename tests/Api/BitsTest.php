<?php

namespace bulgarianhealer\Twitch\Tests\Api;

use bulgarianhealer\Twitch\Tests\TestCases\ApiTestCase;

class BitsTest extends ApiTestCase
{
    public function testUnauthenticated()
    {
        $this->registerResult(
            $result = $this->twitch()->getBitsLeaderboard()
        );

        $this->assertFalse($result->success());
        $this->assertEquals(401, $result->status());
    }
}

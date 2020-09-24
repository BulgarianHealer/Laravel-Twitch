<?php

namespace BulgarianHealer\Twitch\Tests;

use BulgarianHealer\Twitch\Facades\Twitch as TwitchFacade;
use BulgarianHealer\Twitch\Tests\TestCases\TestCase;
use BulgarianHealer\Twitch\Twitch;

class ServiceInstantiationTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(Twitch::class, app(Twitch::class));
    }

    public function testFacade()
    {
        $this->assertInstanceOf(Twitch::class, TwitchFacade::getFacadeRoot());
    }
}

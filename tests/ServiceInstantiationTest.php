<?php

namespace bulgarianhealer\Twitch\Tests;

use bulgarianhealer\Twitch\Facades\Twitch as TwitchFacade;
use bulgarianhealer\Twitch\Tests\TestCases\TestCase;
use bulgarianhealer\Twitch\Twitch;

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

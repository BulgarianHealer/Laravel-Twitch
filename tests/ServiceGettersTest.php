<?php

namespace bulgarianhealer\Twitch\Tests;

use bulgarianhealer\Twitch\Exceptions\RequestRequiresAuthenticationException;
use bulgarianhealer\Twitch\Exceptions\RequestRequiresClientIdException;
use bulgarianhealer\Twitch\Exceptions\RequestRequiresClientSecretException;
use bulgarianhealer\Twitch\Exceptions\RequestRequiresRedirectUriException;
use bulgarianhealer\Twitch\Tests\TestCases\TestCase;
use bulgarianhealer\Twitch\Twitch;

class ServiceGettersTest extends TestCase
{
    public function testClientIdGetterException()
    {
        $this->expectException(RequestRequiresClientIdException::class);

        $twitch = new Twitch;
        $twitch->getClientId();
    }

    public function testClientSecretGetterException()
    {
        $this->expectException(RequestRequiresClientSecretException::class);

        $twitch = new Twitch;
        $twitch->getClientSecret();
    }

    public function testTokenGetterException()
    {
        $this->expectException(RequestRequiresAuthenticationException::class);

        $twitch = new Twitch;
        $twitch->getToken();
    }

    public function testRedirectUriGetterException()
    {
        $this->expectException(RequestRequiresRedirectUriException::class);

        $twitch = new Twitch;
        $twitch->getRedirectUri();
    }
}

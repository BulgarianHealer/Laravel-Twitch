<?php

namespace BulgarianHealer\Twitch\Tests;

use BulgarianHealer\Twitch\Exceptions\RequestRequiresAuthenticationException;
use BulgarianHealer\Twitch\Exceptions\RequestRequiresClientIdException;
use BulgarianHealer\Twitch\Exceptions\RequestRequiresClientSecretException;
use BulgarianHealer\Twitch\Exceptions\RequestRequiresRedirectUriException;
use BulgarianHealer\Twitch\Tests\TestCases\TestCase;
use BulgarianHealer\Twitch\Twitch;

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

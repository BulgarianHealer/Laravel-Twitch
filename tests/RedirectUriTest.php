<?php

namespace BulgarianHealer\Twitch\Tests;

use BulgarianHealer\Twitch\Enums\Scope;
use BulgarianHealer\Twitch\Exceptions\RequestRequiresClientIdException;
use BulgarianHealer\Twitch\Exceptions\RequestRequiresRedirectUriException;
use BulgarianHealer\Twitch\Facades\Twitch as TwitchFacade;
use BulgarianHealer\Twitch\Tests\TestCases\TestCase;

class RedirectUriTest extends TestCase
{
    public function testValidUri()
    {
        $this->assertEquals(
            'https://id.twitch.tv/oauth2/authorize?response_type=code&client_id=abc&scope=' . rawurlencode('bits:read') . '&redirect_uri=' . rawurlencode('http://localhost'),
            TwitchFacade::withClientId('abc')->withRedirectUri('http://localhost')->getOAuthAuthorizeUrl('code', [Scope::BITS_READ])
        );
    }

    public function testMissingRedirectUri()
    {
        $this->expectException(RequestRequiresRedirectUriException::class);

        TwitchFacade::withClientId('abc')->getOAuthAuthorizeUrl();
    }

    public function testMissingClientId()
    {
        $this->expectException(RequestRequiresClientIdException::class);

        TwitchFacade::withRedirectUri('http://localhost')->getOAuthAuthorizeUrl();
    }
}

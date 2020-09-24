<?php

namespace BulgarianHealer\Twitch\Tests\Api;

use BulgarianHealer\Twitch\Enums\GrantType;
use BulgarianHealer\Twitch\Exceptions\RequestRequiresClientSecretException;
use BulgarianHealer\Twitch\Tests\TestCases\ApiTestCase;

class OAuthTest extends ApiTestCase
{
    public function testGetOAuthTokenWithoutSecret()
    {
        $this->expectException(RequestRequiresClientSecretException::class);

        $twitch = $this->twitch();
        $twitch->setClientSecret('');

        $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS);
    }

    public function testGetOAuthTokenWithClientCredentialsFlow()
    {
        $this->skipIfClientSecretMissing();

        $this->registerResult(
            $result = $this->twitch()->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS)
        );

        $this->assertEquals('bearer', $result->data->token_type);
        $this->assertIsString($result->data->access_token);
    }
}

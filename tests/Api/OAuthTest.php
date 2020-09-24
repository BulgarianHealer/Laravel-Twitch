<?php

namespace bulgarianhealer\Twitch\Tests\Api;

use bulgarianhealer\Twitch\Enums\GrantType;
use bulgarianhealer\Twitch\Exceptions\RequestRequiresClientSecretException;
use bulgarianhealer\Twitch\Tests\TestCases\ApiTestCase;

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

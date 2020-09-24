<?php

namespace BulgarianHealer\Twitch\Tests;

use BulgarianHealer\Twitch\Objects\AccessToken;
use BulgarianHealer\Twitch\Tests\TestCases\TestCase;

class AccessTokenExpirationTest extends TestCase
{
    public function testExpiration()
    {
        $this->assertFalse($this->token(time() + 30)->isExpired());
        $this->assertFalse($this->token(time() + time())->isExpired());
        $this->assertFalse($this->token(time() + time() + 30)->isExpired());
        $this->assertTrue($this->token(time() - 30)->isExpired());
        $this->assertTrue($this->token(time() - time())->isExpired());
        $this->assertTrue($this->token(time() - time() - 30)->isExpired());
    }

    private function token(int $expiresAt): AccessToken
    {
        $token = new AccessToken([
            'access_token' => 'foo',
            'expires_in' => time() - $expiresAt,
            'token_type' => 'client_credentials',
        ]);

        $token->expiresAt = $expiresAt;

        return $token;
    }
}

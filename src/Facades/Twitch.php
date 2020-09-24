<?php

namespace BulgarianHealer\Twitch\Facades;

use Illuminate\Support\Facades\Facade;
use BulgarianHealer\Twitch\Twitch as TwitchService;

/**
 * @method static \BulgarianHealer\Twitch\Twitch withClientId(string $clientId)
 * @method static \BulgarianHealer\Twitch\Twitch withClientSecret(string $clientSecret)
 * @method static \BulgarianHealer\Twitch\Twitch withRedirectUri(string $redirectUri)
 */
class Twitch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TwitchService::class;
    }
}

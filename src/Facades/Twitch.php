<?php

namespace bulgarianhealer\Twitch\Facades;

use Illuminate\Support\Facades\Facade;
use bulgarianhealer\Twitch\Twitch as TwitchService;

/**
 * @method static \bulgarianhealer\Twitch\Twitch withClientId(string $clientId)
 * @method static \bulgarianhealer\Twitch\Twitch withClientSecret(string $clientSecret)
 * @method static \bulgarianhealer\Twitch\Twitch withRedirectUri(string $redirectUri)
 */
class Twitch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TwitchService::class;
    }
}

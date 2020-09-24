<?php

namespace BulgarianHealer\Twitch\Concerns\Api;

use BulgarianHealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use BulgarianHealer\Twitch\Concerns\Operations\AbstractValidationTrait;
use BulgarianHealer\Twitch\Helpers\Paginator;
use BulgarianHealer\Twitch\Result;

trait GamesTrait
{
    use AbstractValidationTrait;
    use AbstractOperationsTrait;

    /**
     * Gets games sorted by number of current viewers on Twitch, most popular first.
     * The response has a JSON payload with a data field containing an array of games information elements and a pagination field containing
     * information required to query for more streams.
     *
     * @see https://dev.twitch.tv/docs/api/reference#get-top-games
     *
     * @param array $parameters
     * @param \BulgarianHealer\Twitch\Helpers\Paginator|null $paginator Paginator instance
     * @return \BulgarianHealer\Twitch\Result Result instance
     */
    public function getTopGames(array $parameters = [], Paginator $paginator = null): Result
    {
        return $this->get('games/top', $parameters, $paginator);
    }

    /**
     * Gets game information by game ID or name.
     * The response has a JSON payload with a data field containing an array of games elements.
     *
     * @see https://dev.twitch.tv/docs/api/reference#get-games
     *
     * @param array $parameters
     * @return \BulgarianHealer\Twitch\Result Result instance
     */
    public function getGames(array $parameters = []): Result
    {
        $this->validateAnyRequired($parameters, ['id', 'name']);

        return $this->get('games', $parameters);
    }
}

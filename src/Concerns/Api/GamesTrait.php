<?php

namespace bulgarianhealer\Twitch\Concerns\Api;

use bulgarianhealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use bulgarianhealer\Twitch\Concerns\Operations\AbstractValidationTrait;
use bulgarianhealer\Twitch\Helpers\Paginator;
use bulgarianhealer\Twitch\Result;

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
     * @param \bulgarianhealer\Twitch\Helpers\Paginator|null $paginator Paginator instance
     * @return \bulgarianhealer\Twitch\Result Result instance
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
     * @return \bulgarianhealer\Twitch\Result Result instance
     */
    public function getGames(array $parameters = []): Result
    {
        $this->validateAnyRequired($parameters, ['id', 'name']);

        return $this->get('games', $parameters);
    }
}

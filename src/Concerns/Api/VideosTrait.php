<?php

namespace bulgarianhealer\Twitch\Concerns\Api;

use bulgarianhealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use bulgarianhealer\Twitch\Concerns\Operations\AbstractValidationTrait;
use bulgarianhealer\Twitch\Helpers\Paginator;
use bulgarianhealer\Twitch\Result;

trait VideosTrait
{
    use AbstractValidationTrait;
    use AbstractOperationsTrait;

    /**
     * Gets video information by video ID (one or more), user ID (one only), or game ID (one only).
     *
     * @see https://dev.twitch.tv/docs/api/reference#get-videos
     *
     * @param array $parameters
     * @param \bulgarianhealer\Twitch\Helpers\Paginator|null $paginator
     * @return \bulgarianhealer\Twitch\Result Result instance
     */
    public function getVideos(array $parameters = [], Paginator $paginator = null): Result
    {
        $this->validateAnyRequired($parameters, ['id', 'user_id', 'game_id']);

        return $this->get('videos', $parameters, $paginator);
    }
}

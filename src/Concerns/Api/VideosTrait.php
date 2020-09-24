<?php

namespace BulgarianHealer\Twitch\Concerns\Api;

use BulgarianHealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use BulgarianHealer\Twitch\Concerns\Operations\AbstractValidationTrait;
use BulgarianHealer\Twitch\Helpers\Paginator;
use BulgarianHealer\Twitch\Result;

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
     * @param \BulgarianHealer\Twitch\Helpers\Paginator|null $paginator
     * @return \BulgarianHealer\Twitch\Result Result instance
     */
    public function getVideos(array $parameters = [], Paginator $paginator = null): Result
    {
        $this->validateAnyRequired($parameters, ['id', 'user_id', 'game_id']);

        return $this->get('videos', $parameters, $paginator);
    }
}

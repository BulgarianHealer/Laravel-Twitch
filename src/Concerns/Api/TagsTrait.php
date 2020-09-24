<?php

namespace BulgarianHealer\Twitch\Concerns\Api;

use BulgarianHealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use BulgarianHealer\Twitch\Concerns\Operations\AbstractValidationTrait;
use BulgarianHealer\Twitch\Helpers\Paginator;
use BulgarianHealer\Twitch\Result;

trait TagsTrait
{
    use AbstractValidationTrait;
    use AbstractOperationsTrait;

    /**
     * Gets the list of tags for a specified stream (channel).
     * The response has a JSON payload with a data field containing an array of tag elements.
     *
     * @see https://dev.twitch.tv/docs/api/reference/#get-stream-tags
     *
     * @param array $parameters
     * @return \BulgarianHealer\Twitch\Result
     */
    public function getStreamTags(array $parameters = []): Result
    {
        $this->validateRequired($parameters, ['broadcaster_id']);

        return $this->get('streams/tags', $parameters);
    }

    /**
     * Gets the list of all stream tags defined by Twitch, optionally filtered by tag ID(s).
     *
     * The response has a JSON payload with a data field containing an array of tag elements and a
     * pagination field containing information required to query for more tags.
     *
     * @see https://dev.twitch.tv/docs/api/reference/#get-all-stream-tags
     *
     * @param array $parameters
     * @param \BulgarianHealer\Twitch\Helpers\Paginator|null $paginator
     * @return \BulgarianHealer\Twitch\Result
     */
    public function getAllStreamTags(array $parameters = [], Paginator $paginator = null): Result
    {
        return $this->get('streams/tags', $parameters, $paginator);
    }

    /**
     * Applies specified tags to a specified stream, overwriting any existing tags applied to that stream.
     * If no tags are specified, all tags previously applied to the stream are removed. Automated tags are not
     * affected by this operation.
     *
     * Tags expire 72 hours after they are applied, unless the stream is live within that time period.
     * If the stream is live within the 72-hour window, the 72-hour clock restarts when the stream goes offline.
     * The expiration period is subject to change.
     *
     * @see https://dev.twitch.tv/docs/api/reference/#replace-stream-tags
     *
     * @param array $parameters
     * @param array $body
     * @return \BulgarianHealer\Twitch\Result
     */
    public function replaceStreamTags(array $parameters = [], array $body = []): Result
    {
        $this->validateRequired($parameters, ['broadcaster_id']);

        return $this->put('streams/tags', $parameters, null, $body);
    }
}

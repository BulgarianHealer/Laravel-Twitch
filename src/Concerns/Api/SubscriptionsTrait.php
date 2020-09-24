<?php

namespace BulgarianHealer\Twitch\Concerns\Api;

use BulgarianHealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use BulgarianHealer\Twitch\Concerns\Operations\AbstractValidationTrait;
use BulgarianHealer\Twitch\Helpers\Paginator;
use BulgarianHealer\Twitch\Result;

trait SubscriptionsTrait
{
    use AbstractValidationTrait;
    use AbstractOperationsTrait;

    /**
     * Get all of a broadcaster’s subscriptions.
     *
     * @see https://dev.twitch.tv/docs/api/reference/#get-broadcaster-subscriptions
     *
     * @param array $parameters
     * @param \BulgarianHealer\Twitch\Helpers\Paginator|null $paginator Paginator instance
     * @return \BulgarianHealer\Twitch\Result Result instance
     */
    public function getSubscriptions(array $parameters = [], Paginator $paginator = null): Result
    {
        $this->validateRequired($parameters, ['broadcaster_id']);

        return $this->get('subscriptions', $parameters, $paginator);
    }
}

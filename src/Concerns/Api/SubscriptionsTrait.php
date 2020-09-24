<?php

namespace bulgarianhealer\Twitch\Concerns\Api;

use bulgarianhealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use bulgarianhealer\Twitch\Concerns\Operations\AbstractValidationTrait;
use bulgarianhealer\Twitch\Helpers\Paginator;
use bulgarianhealer\Twitch\Result;

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
     * @param \bulgarianhealer\Twitch\Helpers\Paginator|null $paginator Paginator instance
     * @return \bulgarianhealer\Twitch\Result Result instance
     */
    public function getSubscriptions(array $parameters = [], Paginator $paginator = null): Result
    {
        $this->validateRequired($parameters, ['broadcaster_id']);

        return $this->get('subscriptions', $parameters, $paginator);
    }
}

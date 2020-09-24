<?php

namespace bulgarianhealer\Twitch\Concerns\Api;

use bulgarianhealer\Twitch\Concerns\Operations\AbstractOperationsTrait;
use bulgarianhealer\Twitch\Concerns\Operations\AbstractValidationTrait;
use bulgarianhealer\Twitch\Result;

trait AdsTrait
{
    use AbstractValidationTrait;
    use AbstractOperationsTrait;

    /**
     * Starts a commercial on a specified channel.
     *
     * @see https://dev.twitch.tv/docs/api/reference#start-commercial
     *
     * @param array $parameters
     * @return \bulgarianhealer\Twitch\Result Result instance
     */
    public function startCommercial(array $parameters = []): Result
    {
        $this->validateAnyRequired($parameters, ['broadcaster_id', 'length']);

        return $this->post('channels/commercial', $parameters);
    }
}

<?php

namespace bulgarianhealer\Twitch\Concerns\Operations;

use bulgarianhealer\Twitch\Helpers\Paginator;
use bulgarianhealer\Twitch\Result;

trait AbstractOperationsTrait
{
    abstract public function get(string $path = '', array $parameters = [], Paginator $paginator = null): Result;

    abstract public function post(string $path = '', array $parameters = [], Paginator $paginator = null, array $body = null): Result;

    abstract public function put(string $path = '', array $parameters = [], Paginator $paginator = null, array $body = null): Result;

    abstract public function patch(string $path = '', array $parameters = [], Paginator $paginator = null, array $body = null): Result;

    abstract public function delete(string $path = '', array $parameters = [], Paginator $paginator = null, array $body = null): Result;
}

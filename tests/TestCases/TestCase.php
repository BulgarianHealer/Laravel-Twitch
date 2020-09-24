<?php

namespace bulgarianhealer\Twitch\Tests\TestCases;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use Orchestra\Testbench\TestCase as BaseTestCase;
use bulgarianhealer\Twitch\Facades\Twitch as TwitchFacade;
use bulgarianhealer\Twitch\Providers\TwitchServiceProvider;
use bulgarianhealer\Twitch\Twitch;
use stdClass;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TwitchServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Twitch' => TwitchFacade::class,
        ];
    }

    protected function getClientSecret()
    {
        return getenv('CLIENT_SECRET');
    }

    protected function getClientId()
    {
        return getenv('CLIENT_ID');
    }

    protected function getMockedService($mockedResponse): Twitch
    {
        $twitch = new Twitch;

        $twitch->setClientId('foo');

        $twitch->setRequestClient(new Client([
            'handler' => new MockHandler([
                $mockedResponse,
            ]),
        ]));

        return $twitch;
    }

    protected function assertHasProperty(string $property, stdClass $object): void
    {
        static::assertThat(property_exists($object, $property), static::isTrue(), 'Asserting that an object has a property');
    }

    protected function assertHasProperties(array $properties, stdClass $object): void
    {
        foreach ($properties as $property) {
            $this->assertHasProperty($property, $object);
        }
    }
}

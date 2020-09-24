<?php

namespace BulgarianHealer\Twitch\Tests;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use BulgarianHealer\Twitch\Result;
use BulgarianHealer\Twitch\Tests\TestCases\TestCase;

class ResultExceptionTest extends TestCase
{
    public function testRequestExceptionEmptyBody()
    {
        $request = new Request('GET', '/');

        $response = new Response(404, []);

        $result = new Result($response, new RequestException('Not Found', $request, $response));

        $this->assertFalse($result->success());
        $this->assertEquals('Not Found', $result->error());
    }

    public function testRequestExceptionMissingMessage()
    {
        $request = new Request('GET', '/');

        $response = new Response(404, [], json_encode([
            'data' => [],
        ]));

        $result = new Result($response, new RequestException('Not Found', $request, $response));

        $this->assertFalse($result->success());
        $this->assertEquals('Not Found', $result->error());
    }

    public function testRequestExceptionNullMessage()
    {
        $request = new Request('GET', '/');

        $response = new Response(404, [], json_encode([
            'data' => [],
            'message' => null,
        ]));

        $result = new Result($response, new RequestException('Not Found', $request, $response));

        $this->assertFalse($result->success());
        $this->assertEquals('Not Found', $result->error());
    }

    public function testRequestExceptionWithMessage()
    {
        $request = new Request('GET', '/');

        $response = new Response(404, [], json_encode([
            'data' => [],
            'message' => 'No Data',
        ]));

        $result = new Result($response, new RequestException('Not Found', $request, $response));

        $this->assertFalse($result->success());
        $this->assertEquals('No Data', $result->error());
    }

    public function testRequestExceptionMalformedMessage()
    {
        $request = new Request('GET', '/');

        $response = new Response(404, [], json_encode([
            'data' => [],
            'message' => ['No Data'],
        ]));

        $result = new Result($response, new RequestException('Not Found', $request, $response));

        $this->assertFalse($result->success());
        $this->assertEquals('Not Found', $result->error());
    }
}

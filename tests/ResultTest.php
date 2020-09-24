<?php

namespace bulgarianhealer\Twitch\Tests;

use GuzzleHttp\Psr7\Response;
use bulgarianhealer\Twitch\Result;
use bulgarianhealer\Twitch\Tests\TestCases\TestCase;

class ResultTest extends TestCase
{
    public function testValidResponseResult()
    {
        $data = ['user' => '123'];

        $response = new Response(200, [], json_encode([
            'data' => [$data],
            'total' => 1,
            'pagination' => ['cursor' => 'abc'],
        ]));

        $result = new Result($response);

        $this->assertTrue($result->success());
        $this->assertEquals([(object) $data], $result->data());
        $this->assertEquals((object) $data, $result->shift());
        $this->assertEquals(1, $result->count());
    }

    public function testEmptyResponseResult()
    {
        $response = new Response(200, [], json_encode([
            'data' => [],
            'total' => 1,
            'pagination' => ['cursor' => 'abc'],
        ]));

        $result = new Result($response);

        $this->assertTrue($result->success());
        $this->assertEquals([], $result->data());
        $this->assertEquals(null, $result->shift());
        $this->assertEquals(0, $result->count());
    }

    public function testUnexpectedResponseResult()
    {
        $response = new Response(200, [], json_encode([
            'foo' => 'bar',
        ]));

        $result = new Result($response);

        $this->assertTrue($result->success());
        $this->assertEquals((object) ['foo' => 'bar'], $result->data());
        $this->assertEquals(null, $result->shift());
        $this->assertEquals(0, $result->count());
    }

    public function testNonJsonResponseResult()
    {
        $response = new Response(200, [], '<title>foo</title>');

        $result = new Result($response);

        $this->assertTrue($result->success());
        $this->assertEquals([], $result->data());
        $this->assertEquals(null, $result->shift());
        $this->assertEquals(0, $result->count());
    }

    public function testProcessDefaultPayload()
    {
        $data = [
            ['user' => 1],
            ['user' => 2],
            ['user' => 3],
        ];

        $response = new Response(200, [], json_encode([
            'total' => 3,
            'data' => $data,
            'pagination' => ['cursor' => 'abc'],
        ]));

        $result = new Result($response);

        $this->assertTrue($result->success());
        $this->assertEquals(3, $result->count());

        $this->assertEquals(array_map(function ($item) {
            return (object) $item;
        }, $data), $result->data());
    }

    public function testOAuthResponsePayload()
    {
        $data = [
            'access_token' => 'access_token',
            'refresh_token' => 'refresh_token',
            'expires_in' => 10,
            'scope' => ['user:read'],
            'token_type' => 'bearer',
        ];

        $response = new Response(200, [], json_encode($data));

        $result = new Result($response);

        $this->assertTrue($result->success());
        $this->assertEquals((object) $data, $result->data());
        $this->assertEquals(null, $result->shift());
        $this->assertEquals(0, $result->count());
    }
}

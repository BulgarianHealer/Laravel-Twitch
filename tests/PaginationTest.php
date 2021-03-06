<?php

namespace bulgarianhealer\Twitch\Tests;

use GuzzleHttp\Psr7\Response;
use bulgarianhealer\Twitch\Helpers\Paginator;
use bulgarianhealer\Twitch\Result;
use bulgarianhealer\Twitch\Tests\TestCases\TestCase;

class PaginationTest extends TestCase
{
    public function testResultPaginatorInstance()
    {
        $response = new Response(200, [], json_encode([
            'total' => 1,
            'data' => [['user' => 1]],
            'pagination' => [
                'cursor' => 'abc123',
            ],
        ]));

        $result = new Result($response);

        $this->assertInstanceOf(Paginator::class, $result->paginator);
        $this->assertInstanceOf(Paginator::class, $result->next());
        $this->assertInstanceOf(Paginator::class, $result->back());
    }

    public function testPaginatorActions()
    {
        $response = new Response(200, [], json_encode([
            'total' => 1,
            'data' => [['user' => 1]],
            'pagination' => [
                'cursor' => 'abc123',
            ],
        ]));

        $result = new Result($response);

        $this->assertInstanceOf(Paginator::class, $result->paginator);

        $this->assertEquals('after', $result->next()->action);
        $this->assertEquals('before', $result->back()->action);
    }

    public function testContinuosNextPagination()
    {
        $firstService = $this->getMockedService(
            new Response(200, [], json_encode([
                'total' => 1,
                'data' => [['user' => 1]],
                'pagination' => [
                    'cursor' => 'abc123',
                ],
            ]))
        );

        $firstResult = $firstService->getStreams([]);

        $this->assertInstanceOf(Paginator::class, $firstResult->paginator);
        $this->assertTrue($firstResult->hasMoreResults());

        $service = $this->getMockedService(
            new Response(200, [], json_encode([
                'total' => 1,
                'data' => [['user' => 2]],
                'pagination' => [
                    'cursor' => 'abc123',
                ],
            ]))
        );

        $secondResult = $service->getStreams([], $firstResult->next());

        $this->assertInstanceOf(Paginator::class, $secondResult->paginator);
        $this->assertTrue($secondResult->hasMoreResults());
    }

    public function testEmptyPagination()
    {
        $firstService = $this->getMockedService(
            new Response(200, [], json_encode([
                'total' => 1,
                'data' => [['user' => 1]],
                'pagination' => [
                    'cursor' => 'abc123',
                ],
            ]))
        );

        $firstResult = $firstService->getStreams([]);

        $this->assertInstanceOf(Paginator::class, $firstResult->paginator);
        $this->assertTrue($firstResult->hasMoreResults());

        $service = $this->getMockedService(
            new Response(200, [], json_encode([
                'total' => 1,
                'data' => [['user' => 2]],
                'pagination' => (object) [],
            ]))
        );

        $secondResult = $service->getStreams([], $firstResult->next());

        $this->assertInstanceOf(Paginator::class, $secondResult->paginator);
        $this->assertFalse($secondResult->hasMoreResults());
    }

    public function testNullPagination()
    {
        $firstService = $this->getMockedService(
            new Response(200, [], json_encode([
                'total' => 1,
                'data' => [['user' => 1]],
                'pagination' => [
                    'cursor' => 'abc123',
                ],
            ]))
        );

        $firstResult = $firstService->getStreams([]);

        $this->assertInstanceOf(Paginator::class, $firstResult->paginator);
        $this->assertTrue($firstResult->hasMoreResults());

        $service = $this->getMockedService(
            new Response(200, [], json_encode([
                'total' => 1,
                'data' => [['user' => 2]],
                'pagination' => null,
            ]))
        );

        $secondResult = $service->getStreams([], $firstResult->next());

        $this->assertInstanceOf(Paginator::class, $secondResult->paginator);
        $this->assertFalse($secondResult->hasMoreResults());
    }

    public function testMissingPagination()
    {
        $firstService = $this->getMockedService(
            new Response(200, [], json_encode([
                'total' => 1,
                'data' => [['user' => 1]],
                'pagination' => [
                    'cursor' => 'abc123',
                ],
            ]))
        );

        $firstResult = $firstService->getStreams([]);

        $this->assertInstanceOf(Paginator::class, $firstResult->paginator);
        $this->assertTrue($firstResult->hasMoreResults());

        $service = $this->getMockedService(
            new Response(200, [], json_encode([
                'total' => 1,
                'data' => [['user' => 2]],
            ]))
        );

        $secondResult = $service->getStreams([], $firstResult->next());

        $this->assertInstanceOf(Paginator::class, $secondResult->paginator);
        $this->assertFalse($secondResult->hasMoreResults());
    }
}

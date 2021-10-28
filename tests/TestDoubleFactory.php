<?php

declare(strict_types=1);

namespace Marein\NchanGuzzle\Tests;

use GuzzleHttp\ClientInterface;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Marein\Nchan\Http\Url;
use Marein\NchanGuzzle\GuzzleResponseAdapter;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * This class reduces duplication to create test doubles,
 * because every (http) method on the GuzzleAdapter should have the same test cases.
 */
final class TestDoubleFactory
{
    public TestCase $testCase;

    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    public function createSuccessfulGuzzleClient(string $method): ClientInterface
    {
        $client = $this->testCase->getMockBuilder(ClientInterface::class)->getMock();

        $client
            ->expects($this->testCase::once())
            ->method('send')
            ->with($this->createPsrRequest($method))
            ->willReturn($this->createPsrResponse(200));

        return $client;
    }

    public function createThrowingGuzzleClient(Throwable $throwable): ClientInterface
    {
        $client = $this->testCase->getMockBuilder(ClientInterface::class)->getMock();

        $client
            ->expects($this->testCase::once())
            ->method('send')
            ->willThrowException($throwable);

        return $client;
    }

    public function createNchanRequest(): Request
    {
        return new Request(
            new Url('http://localhost/publish'),
            [
                'Content-Type' => 'application/json'
            ],
            ''
        );
    }

    public function createNchanResponse(int $status): Response
    {
        return new GuzzleResponseAdapter(
            $this->createPsrResponse($status)
        );
    }

    public function createPsrRequest(string $method): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request(
            $method,
            'http://localhost/publish',
            [
                'Content-Type' => 'application/json'
            ],
            ''
        );
    }

    public function createPsrResponse(int $status): ResponseInterface
    {
        return new \GuzzleHttp\Psr7\Response(
            $status,
            [],
            ''
        );
    }
}

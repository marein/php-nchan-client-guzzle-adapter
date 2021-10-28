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
    /**
     * @var TestCase
     */
    public TestCase $testCase;

    /**
     * DoubleFactory constructor.
     *
     * @param TestCase $testCase
     */
    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * Factory for successful guzzle client.
     *
     * @param string $method
     *
     * @return ClientInterface
     */
    public function createSuccessfulGuzzleClient(string $method): ClientInterface
    {
        $client = $this->testCase->getMockBuilder(ClientInterface::class)->getMock();

        $client
            ->expects($this->testCase::once())
            ->method('send')
            ->with($this->createPsrRequest($method))
            ->willReturn($this->createPsrResponse(200));

        /** @var ClientInterface $client */
        return $client;
    }

    /**
     * Factory for throwing guzzle client.
     *
     * @param Throwable $throwable
     *
     * @return ClientInterface
     */
    public function createThrowingGuzzleClient(Throwable $throwable): ClientInterface
    {
        $client = $this->testCase->getMockBuilder(ClientInterface::class)->getMock();

        $client
            ->expects($this->testCase::once())
            ->method('send')
            ->willThrowException($throwable);

        /** @var ClientInterface $client */
        return $client;
    }

    /**
     * Factory for nchan request.
     *
     * @return Request
     */
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

    /**
     * Factory for nchan response.
     *
     * @param int $status
     *
     * @return Response
     */
    public function createNchanResponse(int $status): Response
    {
        return new GuzzleResponseAdapter(
            $this->createPsrResponse($status)
        );
    }

    /**
     * Factory for psr request.
     *
     * @param string $method
     *
     * @return RequestInterface
     */
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

    /**
     * Factory for psr response.
     *
     * @param int $status
     *
     * @return ResponseInterface
     */
    public function createPsrResponse(int $status): ResponseInterface
    {
        return new \GuzzleHttp\Psr7\Response(
            $status,
            [],
            ''
        );
    }
}

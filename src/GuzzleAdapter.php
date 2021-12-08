<?php

declare(strict_types=1);

namespace Marein\NchanGuzzle;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;

final class GuzzleAdapter implements Client
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function get(Request $request): Response
    {
        return $this->request('GET', $request);
    }

    public function post(Request $request): Response
    {
        return $this->request('POST', $request);
    }

    public function delete(Request $request): Response
    {
        return $this->request('DELETE', $request);
    }

    /**
     * @throws NchanException
     */
    private function request(string $method, Request $request): Response
    {
        try {
            $response = $this->client->send(
                new \GuzzleHttp\Psr7\Request(
                    $method,
                    $request->url()->toString(),
                    $request->headers(),
                    $request->body()
                )
            );

            return new GuzzleResponseAdapter($response);
        } catch (BadResponseException $exception) {
            return new GuzzleResponseAdapter(
                $exception->getResponse()
            );
        } catch (Exception $exception) {
            throw new NchanException(
                $exception->getMessage(),
                (int)$exception->getCode(),
                $exception
            );
        }
    }
}

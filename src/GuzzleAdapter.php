<?php
declare(strict_types=1);

namespace Marein\NchanGuzzle;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;
use Psr\Http\Message\ResponseInterface;

final class GuzzleAdapter implements Client
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * GuzzleAdapter constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function get(Request $request): Response
    {
        return $this->request('GET', $request);
    }

    /**
     * @inheritdoc
     */
    public function post(Request $request): Response
    {
        return $this->request('POST', $request);
    }

    /**
     * @inheritdoc
     */
    public function delete(Request $request): Response
    {
        return $this->request('DELETE', $request);
    }

    /**
     * Perform the request via guzzle.
     *
     * @param string  $method
     * @param Request $request
     *
     * @return Response
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
            if ($exception->hasResponse()) {
                /** @var ResponseInterface $response */
                $response = $exception->getResponse();

                return new GuzzleResponseAdapter($response);
            }

            throw new NchanException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        } catch (\Exception $exception) {
            throw new NchanException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }
}

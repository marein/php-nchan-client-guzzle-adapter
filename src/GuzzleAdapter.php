<?php
declare(strict_types=1);

namespace Marein\NchanGuzzle;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Http\Client;
use Marein\Nchan\Http\Request;
use Marein\Nchan\Http\Response;

class GuzzleAdapter implements Client
{
    /**
     * @var ClientInterface
     */
    private $client;

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
            $response = $this->client->send(new \GuzzleHttp\Psr7\Request(
                $method,
                $request->url(),
                $request->headers(),
                $request->body()
            ));

            return new GuzzleResponseAdapter($response);
        } catch (BadResponseException $exception) {
            return new GuzzleResponseAdapter($exception->getResponse());
        } catch (\Exception $exception) {
            throw new NchanException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }
}

<?php

namespace Marein\NchanGuzzle;

use Marein\Nchan\Http\Response;
use Psr\Http\Message\ResponseInterface;

class GuzzleResponseAdapter implements Response
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * GuzzleResponseAdapter constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @inheritdoc
     */
    public function statusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @inheritdoc
     */
    public function body(): string
    {
        return $this->response->getBody();
    }
}
<?php

declare(strict_types=1);

namespace Marein\NchanGuzzle;

use Marein\Nchan\Http\Response;
use Psr\Http\Message\ResponseInterface;

final class GuzzleResponseAdapter implements Response
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function statusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function body(): string
    {
        return (string)$this->response->getBody();
    }
}

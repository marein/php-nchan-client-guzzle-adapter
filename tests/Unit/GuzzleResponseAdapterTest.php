<?php

declare(strict_types=1);

namespace Marein\NchanGuzzle\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use Marein\NchanGuzzle\GuzzleResponseAdapter;
use PHPUnit\Framework\TestCase;

final class GuzzleResponseAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldTranslate(): void
    {
        $response = new GuzzleResponseAdapter(
            new Response(
                200,
                [],
                'body'
            )
        );

        $this->assertSame(200, $response->statusCode());
        $this->assertSame('body', $response->body());
    }
}

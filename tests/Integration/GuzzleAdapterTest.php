<?php
declare(strict_types=1);

namespace Marein\NchanGuzzle\Tests\Integration;

use GuzzleHttp\ClientInterface;
use Marein\Nchan\Exception\NchanException;
use Marein\Nchan\Nchan;
use Marein\NchanGuzzle\GuzzleAdapter;
use PHPUnit\Framework\TestCase;

final class GuzzleAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeUsedAsClient(): void
    {
        $this->expectException(NchanException::class);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('send')
            ->willThrowException(new \Exception());

        $nchan = new Nchan(
            'http://127.0.0.1/',
            new GuzzleAdapter($client)
        );

        $nchan->channel('publish')->delete();
    }
}

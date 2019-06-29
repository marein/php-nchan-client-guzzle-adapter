<?php
declare(strict_types=1);

namespace Marein\NchanGuzzle\Tests\Unit;

use GuzzleHttp\Exception\BadResponseException;
use Marein\Nchan\Exception\NchanException;
use Marein\NchanGuzzle\GuzzleAdapter;
use Marein\NchanGuzzle\Tests\TestDoubleFactory;
use PHPUnit\Framework\TestCase;

final class GuzzleAdapterTest extends TestCase
{
    /**
     * @var TestDoubleFactory
     */
    private $testDoubleFactory;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->testDoubleFactory = new TestDoubleFactory($this);
    }

    /**
     * @test
     */
    public function itShouldMakeGetRequest(): void
    {
        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createSuccessfulGuzzleClient('GET')
        );

        $this->assertEquals(
            $this->testDoubleFactory->createNchanResponse(200),
            $guzzleAdapter->get($this->testDoubleFactory->createNchanRequest())
        );
    }

    /**
     * @test
     */
    public function itShouldHandleBadResponseExceptionOnGetRequest(): void
    {
        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(
                new BadResponseException(
                    'message',
                    $this->testDoubleFactory->createPsrRequest('GET'),
                    $this->testDoubleFactory->createPsrResponse(403)
                )
            )
        );

        $this->assertEquals(
            $this->testDoubleFactory->createNchanResponse(403),
            $guzzleAdapter->get($this->testDoubleFactory->createNchanRequest())
        );
    }

    /**
     * @test
     */
    public function itShouldHandleBadResponseExceptionWithoutResponseOnGetRequest(): void
    {
        $this->expectException(NchanException::class);

        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(
                new BadResponseException(
                    'message',
                    $this->testDoubleFactory->createPsrRequest('GET'),
                    null
                )
            )
        );

        $guzzleAdapter->get($this->testDoubleFactory->createNchanRequest());
    }

    /**
     * @test
     */
    public function itShouldTranslateAnyExceptionOnGetRequest(): void
    {
        $this->expectException(NchanException::class);

        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(new \Exception())
        );

        $guzzleAdapter->get($this->testDoubleFactory->createNchanRequest());
    }

    /**
     * @test
     */
    public function itShouldMakePostRequest(): void
    {
        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createSuccessfulGuzzleClient('POST')
        );

        $this->assertEquals(
            $this->testDoubleFactory->createNchanResponse(200),
            $guzzleAdapter->post($this->testDoubleFactory->createNchanRequest())
        );
    }

    /**
     * @test
     */
    public function itShouldHandleBadResponseExceptionOnPostRequest(): void
    {
        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(
                new BadResponseException(
                    'message',
                    $this->testDoubleFactory->createPsrRequest('POST'),
                    $this->testDoubleFactory->createPsrResponse(403)
                )
            )
        );

        $this->assertEquals(
            $this->testDoubleFactory->createNchanResponse(403),
            $guzzleAdapter->post($this->testDoubleFactory->createNchanRequest())
        );
    }

    /**
     * @test
     */
    public function itShouldHandleBadResponseExceptionWithoutResponseOnPostRequest(): void
    {
        $this->expectException(NchanException::class);

        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(
                new BadResponseException(
                    'message',
                    $this->testDoubleFactory->createPsrRequest('POST'),
                    null
                )
            )
        );

        $guzzleAdapter->post($this->testDoubleFactory->createNchanRequest());
    }

    /**
     * @test
     */
    public function itShouldTranslateAnyExceptionOnPostRequest(): void
    {
        $this->expectException(NchanException::class);

        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(new \Exception())
        );

        $guzzleAdapter->post($this->testDoubleFactory->createNchanRequest());
    }

    /**
     * @test
     */
    public function itShouldMakeDeleteRequest(): void
    {
        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createSuccessfulGuzzleClient('DELETE')
        );

        $this->assertEquals(
            $this->testDoubleFactory->createNchanResponse(200),
            $guzzleAdapter->delete($this->testDoubleFactory->createNchanRequest())
        );
    }

    /**
     * @test
     */
    public function itShouldHandleBadResponseExceptionOnDeleteRequest(): void
    {
        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(
                new BadResponseException(
                    'message',
                    $this->testDoubleFactory->createPsrRequest('DELETE'),
                    $this->testDoubleFactory->createPsrResponse(403)
                )
            )
        );

        $this->assertEquals(
            $this->testDoubleFactory->createNchanResponse(403),
            $guzzleAdapter->delete($this->testDoubleFactory->createNchanRequest())
        );
    }

    /**
     * @test
     */
    public function itShouldHandleBadResponseExceptionWithoutResponseOnDeleteRequest(): void
    {
        $this->expectException(NchanException::class);

        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(
                new BadResponseException(
                    'message',
                    $this->testDoubleFactory->createPsrRequest('DELETE'),
                    null
                )
            )
        );

        $guzzleAdapter->delete($this->testDoubleFactory->createNchanRequest());
    }

    /**
     * @test
     */
    public function itShouldTranslateAnyExceptionOnDeleteRequest(): void
    {
        $this->expectException(NchanException::class);

        $guzzleAdapter = new GuzzleAdapter(
            $this->testDoubleFactory->createThrowingGuzzleClient(new \Exception())
        );

        $guzzleAdapter->delete($this->testDoubleFactory->createNchanRequest());
    }
}

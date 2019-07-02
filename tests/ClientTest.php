<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests;

use Avtocod\B2BApi\Client;
use Avtocod\B2BApi\Settings;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PackageVersions\Versions;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ConnectException;
use Avtocod\B2BApi\Exceptions\BadRequestException;
use Avtocod\B2BApi\Exceptions\BadResponseException;

class ClientTest extends AbstractTestCase
{
    /**
     * @var Guzzle
     */
    protected $guzzle;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Settings
     */
    protected $settings;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client(
            $this->settings = new Settings('TEST_TOKEN'),
            $this->guzzle = new Guzzle([
                'handler' => HandlerStack::create($this->guzzle_handler),
            ])
        );
    }

    /**
     * @small
     *
     * @return void
     */
    public function testGetVersion(): void
    {
        $this->assertSame($version = Versions::getVersion('avtocod/b2b-api-php'), $this->client->getVersion(false));

        $this->assertSame(\mb_substr($version, 0, (int) \mb_strpos($version, '@')), $this->client->getVersion());
    }

    /**
     * @small
     *
     * @return void
     */
    public function testDevPing(): void
    {
        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . \sprintf('dev/ping?value=%d', \time()),
            'get',
            new Response(
                200, ['content-type' => 'application/json;charset=utf-8'], \json_encode((object) [
                    'value' => $value = (string) \time(),
                    'in'    => $in = $this->faker->numberBetween(0, 100),
                    'out'   => $out = (\time() * 1000),
                    'delay' => $delay = ($out + 1),
                ])
            )
        );

        $response = $this->client->devPing();

        $this->assertSame($value, $response->getValue());
        $this->assertSame($in, $response->getIn());
        $this->assertSame($out, $response->getOut());
        $this->assertSame($delay, $response->getDelay());
    }

    /**
     * @small
     *
     * @return void
     */
    public function testDevPingWithWrongJson(): void
    {
        $this->expectException(BadResponseException::class);
        $this->expectExceptionMessageRegExp('~syntax~i');

        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . \sprintf('dev/ping?value=%d', \time()),
            'get',
            new Response(
                200, ['content-type' => 'application/json;charset=utf-8'], '{"foo":]'
            )
        );

        $this->client->devPing();
    }

    /**
     * @small
     *
     * @return void
     */
    public function testDevPingWithServerError(): void
    {
        $this->expectException(BadRequestException::class);

        $this->guzzle_handler->onUriRequested(
            $uri = $this->settings->getBaseUri() . \sprintf('dev/ping?value=%d', \time()),
            $method = 'get',
            new ConnectException(
                'cURL error 7: Failed to connect to host: Connection refused ...', new Request($method, $uri)
            )
        );

        $this->client->devPing();
    }
}

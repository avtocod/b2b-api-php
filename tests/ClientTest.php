<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests;

use DateTime;
use Avtocod\B2BApi\Client;
use Avtocod\B2BApi\Settings;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PackageVersions\Versions;
use GuzzleHttp\Client as Guzzle;
use Avtocod\B2BApi\DateTimeFactory;
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

    /**
     * @small
     *
     * @return void
     */
    public function testDevToken(): void
    {
        $this->guzzle_handler->onUriRequested( // dev/token?user=test&pass=test&is_hash=false&date=2019-07-03T06%3A39%3A46%2B00%3A00&age=60
            $this->settings->getBaseUri() . 'dev/token?' . \http_build_query([
                'user'    => $user = 'test@test',
                'pass'    => $pass = 'test',
                'is_hash' => ($is_hash = true)
                    ? 'true'
                    : 'false',
                'date'    => DateTimeFactory::toIso8601Zulu($date = new DateTime),
                'age'     => $age = 60,
            ]),
            'get',
            new Response(
                200, ['content-type' => 'application/json;charset=utf-8'], \json_encode((object) [
                    'user'             => $user,
                    'pass'             => $pass,
                    'pass_hash'        => $pass_hash = \base64_encode(\md5($pass, true)),
                    'date'             => $response_date = DateTimeFactory::toIso8601Zulu($date),
                    'stamp'            => $stamp = $date->getTimestamp(),
                    'age'              => $age,
                    'salt'             => $not_available = 'NOT:AVAILABLE:DURING:TESTING',
                    'salted_pass_hash' => $not_available,
                    'raw_token'        => $not_available,
                    'token'            => $not_available,
                    'header'           => $not_available,
                ])
            )
        );

        $response = $this->client->devToken($user, $pass, $is_hash, $date, $age);

        $this->assertSame($user, $response->getUser());
        $this->assertSame($pass, $response->getPassword());
        $this->assertSame($pass_hash, $response->getPasswordHash());
        $this->assertSame($response_date, DateTimeFactory::toIso8601Zulu($response->getDate()));
        $this->assertSame($stamp, $response->getStamp());
        $this->assertSame($age, $response->getAge());
    }
}

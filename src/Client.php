<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi;

use Closure;
use DateTime;
use GuzzleHttp\Psr7\Request;
use PackageVersions\Versions;
use GuzzleHttp\Client as Guzzle;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Avtocod\B2BApi\Responses\UserResponse;
use GuzzleHttp\Exception\RequestException;
use Avtocod\B2BApi\Responses\DevPingResponse;
use Avtocod\B2BApi\Responses\DevTokenResponse;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use Avtocod\B2BApi\Exceptions\BadRequestException;

final class Client implements ClientInterface
{
    protected const TOKEN_PREFIX = 'AR-REST';

    /**
     * @var GuzzleInterface
     */
    protected $guzzle;

    /**
     * @var Settings
     */
    protected $settings;

    /**
     * @var Closure|null
     */
    protected $events_handler;

    /**
     * Create a new client instance.
     *
     * @param Settings             $settings
     * @param GuzzleInterface|null $guzzle
     * @param Closure|null         $events_handler
     */
    public function __construct(Settings $settings,
                                ?GuzzleInterface $guzzle = null,
                                ?Closure $events_handler = null)
    {
        $this->settings       = $settings;
        $this->guzzle         = $guzzle ?? new Guzzle;
        $this->events_handler = $events_handler;
    }

    /**
     * Set events handler.
     *
     * @param Closure $events_handler
     *
     * @return $this
     */
    public function setEventsHandler(Closure $events_handler): self
    {
        $this->events_handler = $events_handler;

        return $this;
    }

    /**
     * @return Settings
     */
    public function getSettings(): Settings
    {
        return $this->settings;
    }

    /**
     * {@inheritdoc}
     */
    public function devPing(): DevPingResponse
    {
        return DevPingResponse::fromHttpResponse(
            $this->doRequest(new Request('get', 'dev/ping'), [
                'query' => [
                    'value' => \time(),
                ],
            ])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function devToken(string $username,
                             string $password,
                             bool $is_hash = false,
                             ?DateTime $date_from = null,
                             int $age = 60): DevTokenResponse
    {
        return DevTokenResponse::fromHttpResponse(
            $this->doRequest(new Request('get', 'dev/token'), [
                'query' => [
                    'user'    => $username,
                    'pass'    => $password,
                    'is_hash' => $is_hash
                        ? 'true'
                        : 'false',
                    'date'    => DateTimeFactory::toIso8601Zulu($date_from ?? new DateTime),
                    'age'     => \max(1, $age),
                ],
            ])
        );
    }

    /**
     * Retrieve information about current user.
     *
     * @param bool $detailed
     *
     * @return UserResponse
     */
    public function user(bool $detailed = false): UserResponse
    {
        return UserResponse::fromHttpResponse(
            $this->doRequest(new Request('get', 'user'), [
                'query' => [
                    '_detailed' => $detailed
                        ? 'true'
                        : 'false',
                ],
            ])
        );
    }

    /**
     * @param bool $without_hash
     *
     * @return string
     */
    public function getVersion(bool $without_hash = true): string
    {
        $version = Versions::getVersion('avtocod/b2b-api-php');

        if ($without_hash === true && \is_int($delimiter_position = \mb_strpos($version, '@'))) {
            return \mb_substr($version, 0, (int) $delimiter_position);
        }

        return $version;
    }

    /**
     * @param object $event
     *
     * @return void
     */
    protected function dispatchEvent($event): void
    {
        if ($this->events_handler instanceof Closure) {
            $this->events_handler->__invoke($event);
        }
    }

    /**
     * @param RequestInterface $request
     * @param array            $options
     *
     * @throws BadRequestException
     *
     * @return ResponseInterface
     */
    protected function doRequest(RequestInterface $request, array $options = []): ResponseInterface
    {
        $options = \array_replace($this->settings->getGuzzleOptions(), $options);

        $options['base_uri'] = $this->settings->getBaseUri();

        $options['headers'] = \array_replace([
            'Authorization' => static::TOKEN_PREFIX . ' ' . $this->settings->getAuthToken(),
            'User-Agent'    => $this->getDefaultUserAgent(),
        ], $options['headers'] ?? []);

        $this->dispatchEvent(new Events\BeforeRequestSendingEvent($request, $options));

        try {
            $started_at = \microtime(true);
            $response   = $this->guzzle->send($request, $options);
        } catch (RequestException $e) {
            $this->dispatchEvent(new Events\RequestFailedEvent(
                $exception_request = $e->getRequest(),
                $exception_response = $e->getResponse()
            ));

            throw new BadRequestException($exception_request, $exception_response, $e->getMessage(), 0, $e);
        }

        $this->dispatchEvent(new Events\AfterRequestSendingEvent(
            $request,
            $response,
            (int) \round((\microtime(true) - $started_at) * 1000) // in microseconds
        ));

        return $response;
    }

    /**
     * @return string
     */
    protected function getDefaultUserAgent(): string
    {
        static $user_agent = null;

        if ($user_agent === null) {
            $user_agent = 'b2b-api-php/' . $this->getVersion();

            if (\function_exists('curl_version') && \extension_loaded('curl')) {
                $user_agent .= ' curl/' . (\curl_version()['version'] ?? '0.0.0');
            }

            $user_agent .= ' PHP/' . PHP_VERSION;
        }

        return $user_agent;
    }
}

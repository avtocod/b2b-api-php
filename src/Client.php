<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi;

use DateTime;
use GuzzleHttp\Psr7\Request;
use PackageVersions\Versions;
use GuzzleHttp\Client as Guzzle;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Avtocod\B2BApi\Responses\DevPingResponse;
use Avtocod\B2BApi\Responses\DevTokenResponse;
use Avtocod\B2BApi\Exceptions\BadRequestException;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Client implements ClientInterface
{
    /**
     * @var GuzzleInterface
     */
    protected $guzzle;

    /**
     * @var Settings
     */
    protected $settings;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Create a new client instance.
     *
     * @param Settings                      $settings
     * @param GuzzleInterface|null          $guzzle
     * @param EventDispatcherInterface|null $dispatcher
     */
    public function __construct(Settings $settings,
                                ?GuzzleInterface $guzzle = null,
                                ?EventDispatcherInterface $dispatcher = null)
    {
        $this->settings   = $settings;
        $this->guzzle     = $guzzle ?? new Guzzle;
        $this->dispatcher = $dispatcher ?? new EventDispatcher;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher;
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
            'Authorization' => $this->settings->getAuthToken(),
            'User-Agent'    => $this->getDefaultUserAgent(),
        ], $options['headers'] ?? []);

        $this->dispatcher->dispatch(new Events\BeforeRequestSendingEvent($request, $options));

        try {
            $started_at = \microtime(true);
            $response   = $this->guzzle->send($request, $options);
        } catch (RequestException $exception) {
            $this->dispatcher->dispatch(new Events\RequestFailedEvent(
                $exception_request = $exception->getRequest(),
                $exception_response = $exception->getResponse()
            ));

            throw new BadRequestException($exception_request, $exception_response);
        }

        $this->dispatcher->dispatch(new Events\AfterRequestSendingEvent(
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

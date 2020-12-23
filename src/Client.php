<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi;

use Closure;
use DateTime;
use GuzzleHttp\Psr7\Request;
use PackageVersions\Versions;
use GuzzleHttp\Client as Guzzle;
use Avtocod\B2BApi\Params\UserParams;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Avtocod\B2BApi\Params\DevPingParams;
use Avtocod\B2BApi\Params\DevTokenParams;
use Avtocod\B2BApi\Responses\UserResponse;
use GuzzleHttp\Exception\RequestException;
use Avtocod\B2BApi\Params\UserReportParams;
use GuzzleHttp\Exception\TransferException;
use Avtocod\B2BApi\Params\UserBalanceParams;
use Avtocod\B2BApi\Params\UserReportsParams;
use Avtocod\B2BApi\Responses\DevPingResponse;
use Avtocod\B2BApi\Responses\DevTokenResponse;
use Avtocod\B2BApi\Params\UserReportMakeParams;
use GuzzleHttp\RequestOptions as GuzzleOptions;
use Avtocod\B2BApi\Params\UserReportTypesParams;
use Avtocod\B2BApi\Responses\UserReportResponse;
use Avtocod\B2BApi\Responses\UserBalanceResponse;
use Avtocod\B2BApi\Responses\UserReportsResponse;
use Avtocod\B2BApi\Exceptions\BadRequestException;
use Avtocod\B2BApi\Params\UserReportRefreshParams;
use GuzzleHttp\ClientInterface as GuzzleInterface;
use Avtocod\B2BApi\Responses\UserReportMakeResponse;
use Avtocod\B2BApi\Responses\UserReportTypesResponse;
use Avtocod\B2BApi\Responses\UserReportRefreshResponse;

class Client implements ClientInterface, WithSettingsInterface, WithEventsHandlerSetterInterface
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
     * {@inheritdoc}
     *
     * @return $this
     */
    public function setEventsHandler(Closure $events_handler): self
    {
        $this->events_handler = $events_handler;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings(): Settings
    {
        return $this->settings;
    }

    /**
     * {@inheritdoc}
     */
    public function devPing(?DevPingParams $params = null): DevPingResponse
    {
        return DevPingResponse::fromHttpResponse(
            $this->doRequest(new Request('get', 'dev/ping'), [
                'query' => [
                    'value' => $params instanceof DevPingParams && \is_string($value = $params->getValue())
                            ? $value
                            : ((string) \time()),
                ],
            ])
        );
    }

    /**
     * Get client (package) version.
     *
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
     * {@inheritdoc}
     */
    public function devToken(DevTokenParams $params): DevTokenResponse
    {
        return DevTokenResponse::fromHttpResponse(
            $this->doRequest(new Request('get', 'dev/token'), [
                'query' => [
                    'user'    => $params->getUsername(),
                    'pass'    => $params->getPassword(),
                    'is_hash' => $params->isPasswordHashed() === true
                        ? 'true'
                        : 'false',
                    'date'    => DateTimeFactory::toIso8601ZuluWithoutMs($params->getDateFrom() ?? new DateTime),
                    'age'     => \max(1, $params->getTokenLifetime() ?? 60),
                ],
            ])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function user(?UserParams $params = null): UserResponse
    {
        return UserResponse::fromHttpResponse(
            $this->doRequest(new Request('get', 'user'), [
                'query' => [
                    '_detailed' => $params instanceof UserParams && $params->isDetailed() === true
                        ? 'true'
                        : 'false',
                ],
            ])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function userBalance(UserBalanceParams $params): UserBalanceResponse
    {
        return UserBalanceResponse::fromHttpResponse(
            $this->doRequest(new Request('get', \sprintf('user/balance/%s', \urlencode($params->getReportTypeUid()))), [
                'query' => [
                    '_detailed' => $params->isDetailed() === true
                        ? 'true'
                        : 'false',
                ],
            ])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function userReportTypes(?UserReportTypesParams $params = null): UserReportTypesResponse
    {
        $query = [
            '_can_generate' => 'false',
            '_content'      => 'false',
            '_query'        => '_all',
            '_size'         => 20,
            '_offset'       => 0,
            '_page'         => 1,
            '_sort'         => '-created_at',
            '_calc_total'   => 'false',
        ];

        // Modify query, if needed
        if ($params instanceof UserReportTypesParams) {
            if (\is_bool($can_generate = $params->isCanGenerate())) {
                $query['_can_generate'] = $can_generate ? 'true' : 'false';
            }

            if (\is_bool($with_content = $params->isWithContent())) {
                $query['_content'] = $with_content ? 'true' : 'false';
            }

            if (\is_string($filter_query = $params->getQuery())) {
                $query['_query'] = $filter_query;
            }

            if (\is_int($per_page = $params->getPerPage())) {
                $query['_size'] = \max(1, $per_page);
            }

            if (\is_int($offset = $params->getOffset())) {
                $query['_offset'] = \max(0, $offset);
            }

            if (\is_int($page = $params->getPage())) {
                $query['_page'] = \max(1, $page);
            }

            if (\is_string($sort_by = $params->getSortBy())) {
                $query['_sort'] = $sort_by;
            }

            if (\is_bool($is_calc_total = $params->isCalcTotal())) {
                $query['_calc_total'] = $is_calc_total ? 'true' : 'false';
            }
        }

        return UserReportTypesResponse::fromHttpResponse(
            $this->doRequest(new Request('get', 'user/report_types'), ['query' => $query])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function userReports(?UserReportsParams $params = null): UserReportsResponse
    {
        $query = [
            '_content'    => 'false',
            '_query'      => '_all',
            '_size'       => 20,
            '_offset'     => 0,
            '_page'       => 1,
            '_sort'       => '-created_at',
            '_calc_total' => 'false',
            '_detailed'   => 'false',
        ];

        // Modify query, if needed
        if ($params instanceof UserReportsParams) {
            if (\is_bool($with_content = $params->isWithContent())) {
                $query['_content'] = $with_content ? 'true' : 'false';
            }

            if (\is_string($filter_query = $params->getQuery())) {
                $query['_query'] = $filter_query;
            }

            if (\is_int($per_page = $params->getPerPage())) {
                $query['_size'] = \max(1, $per_page);
            }

            if (\is_int($offset = $params->getOffset())) {
                $query['_offset'] = \max(0, $offset);
            }

            if (\is_int($page = $params->getPage())) {
                $query['_page'] = \max(1, $page);
            }

            if (\is_string($sort_by = $params->getSortBy())) {
                $query['_sort'] = $sort_by;
            }

            if (\is_bool($is_calc_total = $params->isCalcTotal())) {
                $query['_calc_total'] = $is_calc_total ? 'true' : 'false';
            }

            if (\is_bool($is_detailed = $params->isDetailed())) {
                $query['_detailed'] = $is_detailed ? 'true' : 'false';
            }
        }

        return UserReportsResponse::fromHttpResponse(
            $this->doRequest(new Request('get', 'user/reports'), ['query' => $query])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function userReport(UserReportParams $params): UserReportResponse
    {
        return UserReportResponse::fromHttpResponse(
            $this->doRequest(new Request('get', \sprintf('user/reports/%s', \urlencode($params->getReportUid()))), [
                'query' => [
                    '_content'  => $params->isIncludeContent() === true || $params->isIncludeContent() === null
                        ? 'true'
                        : 'false',
                    '_detailed' => $params->isDetailed() === true || $params->isDetailed() === null
                        ? 'true'
                        : 'false',
                ],
            ])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function userReportMake(UserReportMakeParams $params): UserReportMakeResponse
    {
        $request_body = [
            'queryType' => $params->getType(),
            'query'     => $params->getValue(),
        ];

        $options = [];

        if (\is_bool($is_force = $params->isForce())) {
            $options['FORCE'] = $is_force;
        }

        if (\is_string($on_update = $params->getOnUpdateUrl())) {
            $options['webhook']['on_update'] = $on_update;
        }

        if (\is_string($on_complete = $params->getOnCompleteUrl())) {
            $options['webhook']['on_complete'] = $on_complete;
        }

        if (\is_string($idempotence_key = $params->getIdempotenceKey())) {
            $request_body['idempotenceKey'] = $idempotence_key;
        }

        if (\is_array($data = $params->getData())) {
            $request_body['data'] = (object) $data;
        }

        $request_body['options'] = (object) \array_replace($options, $params->getOptions() ?? []);

        return UserReportMakeResponse::fromHttpResponse(
            $this->doRequest(
                new Request('post', \sprintf('user/reports/%s/_make', \urlencode($params->getReportTypeUid()))),
                [GuzzleOptions::JSON => (object) $request_body]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function userReportRefresh(UserReportRefreshParams $params): UserReportRefreshResponse
    {
        return UserReportRefreshResponse::fromHttpResponse(
            $this->doRequest(new Request('post', \sprintf('user/reports/%s/_refresh', \urlencode($params->getReportUid()))), [
                GuzzleOptions::JSON => (object) ($params->getOptions() ?? []),
            ])
        );
    }

    /**
     * @param RequestInterface     $request
     * @param array<string, mixed> $options
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
        } catch (TransferException $e) {
            $this->dispatchEvent(new Events\RequestFailedEvent(
                $exception_request = $e instanceof RequestException
                    ? $e->getRequest()
                    : $request,
                $exception_response = $e instanceof RequestException
                    ? $e->getResponse()
                    : null
            ));

            throw new BadRequestException($exception_request, $exception_response, null, null, $e);
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
        $user_agent = 'b2b-api-php/' . $this->getVersion();

        if (\function_exists('curl_version') && \extension_loaded('curl')) {
            $user_agent .= ' curl/' . (((array) \curl_version())['version'] ?? 'UNKNOWN');
        }

        return $user_agent . ' PHP/' . PHP_VERSION;
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
}

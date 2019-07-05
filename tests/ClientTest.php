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

/**
 * @coversDefaultClass \Avtocod\B2BApi\Client
 */
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
     * @covers ::getVersion
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
     * @covers ::devPing
     * @covers ::doRequest
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
     * @covers ::devPing
     * @covers ::doRequest
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
     * @covers ::devPing
     * @covers ::doRequest
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
     * @covers ::devToken
     * @covers ::doRequest
     *
     * @return void
     */
    public function testDevToken(): void
    {
        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . 'dev/token?' . \http_build_query([
                'user'    => $user = 'test@test',
                'pass'    => $pass = 'test',
                'is_hash' => ($is_hash = true)
                    ? 'true'
                    : 'false',
                'date'    => DateTimeFactory::toIso8601Zulu($date = new DateTime),
                'age'     => $age = \random_int(1, 100),
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

    /**
     * @small
     *
     * @covers ::devToken
     * @covers ::doRequest
     *
     * @return void
     */
    public function testDevTokenWithWrongJson(): void
    {
        self::markTestIncomplete();
    }

    /**
     * @small
     *
     * @covers ::devToken
     * @covers ::doRequest
     *
     * @return void
     */
    public function testDevTokenWithServerError(): void
    {
        self::markTestIncomplete();
    }

    /**
     * @small
     *
     * @covers ::user
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUser(): void
    {
        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . 'user?_detailed=false',
            'get',
            new Response(
                200, ['content-type' => 'application/json;charset=utf-8'], \json_encode((object) [
                    'state' => $state = 'ok',
                    'size'  => $size = 1,
                    'stamp' => $stamp = DateTimeFactory::toIso8601Zulu(new DateTime),
                    'data'  => [
                        (object) [
                            'login'       => $login = 'default@test',
                            'email'       => $email = 'default@test',
                            'contacts'    => $contacts = '+7 (800) 888 88 88',
                            'state'       => $user_state = 'ACTIVE',
                            'domain_uid'  => $domain_uid = 'domain',
                            'roles'       => $roles = 'ADMIN,DOMAIN_ADMIN,ALL_REPORTS_READ,ALL_REPORTS_WRITE',
                            'uid'         => $uid = 'username@domain',
                            'name'        => $name = 'Иванов Иван Иванович',
                            'comment'     => $comment = '',
                            'tags'        => $tags = '',
                            'created_at'  => $created_at = '2017-06-08T13:05:27.384Z',
                            'created_by'  => $created_by = 'system',
                            'updated_at'  => $updated_at = '2017-08-09T05:29:10.004Z',
                            'updated_by'  => $updated_by = 'system',
                            'active_from' => $active_from = '1900-01-01T00:00:00.000Z',
                            'active_to'   => $active_to = '3000-01-01T00:00:00.000Z',
                            'id'          => $id = \random_int(1, 100),
                            'deleted'     => $deleted = false,
                            'pass_hash'   => $pass_hash = '7815696ecbf1c96e6894b779456d330e',
                        ],
                    ],
                ])
            )
        );

        $response = $this->client->user();

        $this->assertSame($state, $response->getState());
        $this->assertSame($size, $response->getSize());
        $this->assertSame($stamp, DateTimeFactory::toIso8601Zulu($response->getStamp()));

        $user = $response->getData()[0];

        $this->assertSame($login, $user->getLogin());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($contacts, $user->getContacts());
        $this->assertSame($user_state, $user->getState());
        $this->assertSame($domain_uid, $user->getDomainUid());
        $this->assertNull($user->getDomain());
        $this->assertSame(\explode(',', $roles), $user->getRoles());
        $this->assertSame($uid, $user->getUid());
        $this->assertSame($name, $user->getName());
        $this->assertSame($comment, $user->getComment());
        $this->assertIsArray($user->getTags());
        $this->assertEmpty($user->getTags());
        $this->assertSame($created_at, DateTimeFactory::toIso8601Zulu($user->getCreatedAt()));
        $this->assertSame($created_by, $user->getCreatedBy());
        $this->assertSame($updated_at, DateTimeFactory::toIso8601Zulu($user->getUpdatedAt()));
        $this->assertSame($updated_by, $user->getUpdatedBy());
        $this->assertSame($active_from, DateTimeFactory::toIso8601Zulu($user->getActiveFrom()));
        $this->assertSame($active_to, DateTimeFactory::toIso8601Zulu($user->getActiveTo()));
        $this->assertSame($id, $user->getId());
        $this->assertSame($deleted, $user->isDeleted());
        $this->assertSame($pass_hash, $user->getPassHash());
    }

    /**
     * @small
     *
     * @covers ::user
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserDetailed(): void
    {
        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . 'user?_detailed=true',
            'get',
            new Response(
                200, ['content-type' => 'application/json;charset=utf-8'], \json_encode((object) [
                    'state' => $state = 'ok',
                    'size'  => $size = 1,
                    'stamp' => $stamp = DateTimeFactory::toIso8601Zulu(new DateTime),
                    'data'  => [
                        (object) [
                            'login'       => $login = 'default@test',
                            'email'       => $email = 'default@test',
                            'contacts'    => $contacts = '+7 (800) 888 88 88',
                            'state'       => $user_state = 'ACTIVE',
                            'domain_uid'  => $domain_uid = 'domain',
                            'domain'      => (object) [
                                'state'       => $domain_state = 'ACTIVE',
                                'roles'       => $domain_roles = 'CLIENT,USER',
                                'uid'         => $domain_uid,
                                'name'        => $domain_name = 'Some name',
                                'comment'     => $domain_comment = 'Some comment',
                                'tags'        => $domain_tags = 'SomeTag',
                                'created_at'  => $domain_created_at = '2017-06-08T13:05:27.363Z',
                                'created_by'  => $domain_created_by = 'system',
                                'updated_at'  => $domain_updated_at = '2019-03-06T08:28:22.989Z',
                                'updated_by'  => $domain_updated_by = 'system',
                                'active_from' => $domain_active_from = '1900-01-01T00:00:00.000Z',
                                'active_to'   => $domain_active_to = '3000-01-01T00:00:00.000Z',
                            ],
                            'roles'       => $roles = 'ADMIN,DOMAIN_ADMIN,ALL_REPORTS_READ,ALL_REPORTS_WRITE',
                            'uid'         => $uid = 'username@domain',
                            'name'        => $name = 'Иванов Иван Иванович',
                            'comment'     => $comment = '',
                            'tags'        => $tags = '',
                            'created_at'  => $created_at = '2017-06-08T13:05:27.384Z',
                            'created_by'  => $created_by = 'system',
                            'updated_at'  => $updated_at = '2017-08-09T05:29:10.004Z',
                            'updated_by'  => $updated_by = 'system',
                            'active_from' => $active_from = '1900-01-01T00:00:00.000Z',
                            'active_to'   => $active_to = '3000-01-01T00:00:00.000Z',
                        ],
                    ],
                ])
            )
        );

        $response = $this->client->user(true);

        $this->assertSame($state, $response->getState());
        $this->assertSame($size, $response->getSize());
        $this->assertSame($stamp, DateTimeFactory::toIso8601Zulu($response->getStamp()));

        $user = $response->getData()[0];

        $this->assertSame($login, $user->getLogin());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($contacts, $user->getContacts());
        $this->assertSame($user_state, $user->getState());
        $this->assertSame($domain_uid, $user->getDomainUid());
        $this->assertSame(\explode(',', $roles), $user->getRoles());
        $this->assertSame($uid, $user->getUid());
        $this->assertSame($name, $user->getName());
        $this->assertSame($comment, $user->getComment());
        $this->assertIsArray($user->getTags());
        $this->assertEmpty($user->getTags());
        $this->assertSame($created_at, DateTimeFactory::toIso8601Zulu($user->getCreatedAt()));
        $this->assertSame($created_by, $user->getCreatedBy());
        $this->assertSame($updated_at, DateTimeFactory::toIso8601Zulu($user->getUpdatedAt()));
        $this->assertSame($updated_by, $user->getUpdatedBy());
        $this->assertSame($active_from, DateTimeFactory::toIso8601Zulu($user->getActiveFrom()));
        $this->assertSame($active_to, DateTimeFactory::toIso8601Zulu($user->getActiveTo()));
        $this->assertNull($user->getId());
        $this->assertNull($user->isDeleted());
        $this->assertNull($user->getPassHash());

        $user_domain = $user->getDomain();

        $this->assertSame($domain_state, $user_domain->getState());
        $this->assertSame(\explode(',', $domain_roles), $user_domain->getRoles());
        $this->assertSame($domain_uid, $user_domain->getUid());
        $this->assertSame($domain_name, $user_domain->getName());
        $this->assertSame($domain_comment, $user_domain->getComment());
        $this->assertSame(\explode(',', $domain_tags), $user_domain->getTags());
        $this->assertSame($domain_created_at, DateTimeFactory::toIso8601Zulu($user_domain->getCreatedAt()));
        $this->assertSame($domain_created_by, $user_domain->getCreatedBy());
        $this->assertSame($domain_updated_at, DateTimeFactory::toIso8601Zulu($user_domain->getUpdatedAt()));
        $this->assertSame($domain_updated_by, $user_domain->getUpdatedBy());
        $this->assertSame($domain_active_from, DateTimeFactory::toIso8601Zulu($user_domain->getActiveFrom()));
        $this->assertSame($domain_active_to, DateTimeFactory::toIso8601Zulu($user_domain->getActiveTo()));
    }

    /**
     * @small
     *
     * @covers ::user
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserWithWrongJson(): void
    {
        self::markTestIncomplete();
    }

    /**
     * @small
     *
     * @covers ::user
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserWithServerError(): void
    {
        self::markTestIncomplete();
    }

    /**
     * @small
     *
     * @covers ::userBalance
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserBalance(): void
    {
        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . \sprintf(
                'user/balance/%s?_detailed=false', \urlencode($report_type_uid = 'foo@bar')
            ),
            'get',
            new Response(
                200, ['content-type' => 'application/json;charset=utf-8'], \json_encode((object) [
                    'state' => $state = 'ok',
                    'size'  => $size = 3,
                    'stamp' => $stamp = DateTimeFactory::toIso8601Zulu(new DateTime),
                    'data'  => $data = [
                        (object) [
                            'report_type_uid' => $report_type_uid,
                            'balance_type'    => $day_type = 'DAY',
                            'quote_init'      => $day_init = \random_int(1, 100),
                            'quote_up'        => $day_up = \random_int(1, 100),
                            'quote_use'       => $day_use = \random_int(1, 100),
                        ],
                        (object) [
                            'report_type_uid' => $report_type_uid,
                            'balance_type'    => $month_type = 'MONTH',
                            'quote_init'      => $month_init = \random_int(1, 100),
                            'quote_up'        => $month_up = \random_int(1, 100),
                            'quote_use'       => $month_use = \random_int(1, 100),
                        ],
                        (object) [
                            'report_type_uid' => $report_type_uid,
                            'balance_type'    => $total_type = 'TOTAL',
                            'quote_init'      => $total_init = \random_int(1, 100),
                            'quote_up'        => $total_up = \random_int(1, 100),
                            'quote_use'       => $total_use = \random_int(1, 100),
                            'created_at'      => $total_created_at = '2017-10-23T08:20:57.264Z',
                            'updated_at'      => $total_updated_at = '2017-10-23T08:43:48.632Z',
                        ],
                    ],
                ])
            )
        );

        $response = $this->client->userBalance($report_type_uid);

        $this->assertSame($state, $response->getState());
        $this->assertSame($size, $response->getSize());
        $this->assertCount($size, $data);
        $this->assertCount($size, $response->getData());
        $this->assertSame($stamp, DateTimeFactory::toIso8601Zulu($response->getStamp()));

        $daily = $response->getByType($day_type);

        $this->assertSame($report_type_uid, $daily->getReportTypeUid());
        $this->assertSame($day_type, $daily->getBalanceType());
        $this->assertSame($day_init, $daily->getQuoteInit());
        $this->assertSame($day_up, $daily->getQuoteUp());
        $this->assertSame($day_use, $daily->getQuoteUse());
        $this->assertNull($daily->getCreatedAt());
        $this->assertNull($daily->getUpdatedAt());

        $monthly = $response->getByType($month_type);

        $this->assertSame($report_type_uid, $monthly->getReportTypeUid());
        $this->assertSame($month_type, $monthly->getBalanceType());
        $this->assertSame($month_init, $monthly->getQuoteInit());
        $this->assertSame($month_up, $monthly->getQuoteUp());
        $this->assertSame($month_use, $monthly->getQuoteUse());
        $this->assertNull($daily->getCreatedAt());
        $this->assertNull($daily->getUpdatedAt());

        $totally = $response->getByType($total_type);

        $this->assertSame($report_type_uid, $totally->getReportTypeUid());
        $this->assertSame($total_type, $totally->getBalanceType());
        $this->assertSame($total_init, $totally->getQuoteInit());
        $this->assertSame($total_up, $totally->getQuoteUp());
        $this->assertSame($total_use, $totally->getQuoteUse());
        $this->assertSame($total_created_at, DateTimeFactory::toIso8601Zulu($totally->getCreatedAt()));
        $this->assertSame($total_updated_at, DateTimeFactory::toIso8601Zulu($totally->getUpdatedAt()));
    }

    /**
     * @small
     *
     * @covers ::userBalance
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserBalanceDetailed(): void
    {
        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . \sprintf(
                'user/balance/%s?_detailed=true', \urlencode($report_type_uid = 'foo@bar')
            ),
            'get',
            new Response(
                200, ['content-type' => 'application/json;charset=utf-8'], \json_encode((object) [
                    'state' => $state = 'ok',
                    'size'  => $size = 3,
                    'stamp' => $stamp = DateTimeFactory::toIso8601Zulu(new DateTime),
                    'data'  => $data = [
                        (object) [
                            'report_type_uid' => $report_type_uid,
                            'balance_type'    => $day_type = 'DAY',
                            'quote_init'      => $day_init = \random_int(1, 100),
                            'quote_up'        => $day_up = \random_int(1, 100),
                            'quote_use'       => $day_use = \random_int(1, 100),
                        ],
                        (object) [
                            'report_type_uid' => $report_type_uid,
                            'balance_type'    => $month_type = 'MONTH',
                            'quote_init'      => $month_init = \random_int(1, 100),
                            'quote_up'        => $month_up = \random_int(1, 100),
                            'quote_use'       => $month_use = \random_int(1, 100),
                        ],
                        (object) [
                            'report_type_uid' => $report_type_uid,
                            'balance_type'    => $total_type = 'TOTAL',
                            'quote_init'      => $total_init = \random_int(1, 100),
                            'quote_up'        => $total_up = \random_int(1, 100),
                            'quote_use'       => $total_use = \random_int(1, 100),
                            'created_at'      => $total_created_at = '2017-10-23T08:20:57.264Z',
                            'updated_at'      => $total_updated_at = '2017-10-23T08:43:48.632Z',
                        ],
                    ],
                ])
            )
        );

        $response = $this->client->userBalance($report_type_uid, true);

        $this->assertSame($state, $response->getState());
        $this->assertSame($size, $response->getSize());
        $this->assertCount($size, $data);
        $this->assertCount($size, $response->getData());
        $this->assertSame($stamp, DateTimeFactory::toIso8601Zulu($response->getStamp()));

        $daily = $response->getByType($day_type);

        $this->assertSame($report_type_uid, $daily->getReportTypeUid());
        $this->assertSame($day_type, $daily->getBalanceType());
        $this->assertSame($day_init, $daily->getQuoteInit());
        $this->assertSame($day_up, $daily->getQuoteUp());
        $this->assertSame($day_use, $daily->getQuoteUse());
        $this->assertNull($daily->getCreatedAt());
        $this->assertNull($daily->getUpdatedAt());

        $monthly = $response->getByType($month_type);

        $this->assertSame($report_type_uid, $monthly->getReportTypeUid());
        $this->assertSame($month_type, $monthly->getBalanceType());
        $this->assertSame($month_init, $monthly->getQuoteInit());
        $this->assertSame($month_up, $monthly->getQuoteUp());
        $this->assertSame($month_use, $monthly->getQuoteUse());
        $this->assertNull($daily->getCreatedAt());
        $this->assertNull($daily->getUpdatedAt());

        $totally = $response->getByType($total_type);

        $this->assertSame($report_type_uid, $totally->getReportTypeUid());
        $this->assertSame($total_type, $totally->getBalanceType());
        $this->assertSame($total_init, $totally->getQuoteInit());
        $this->assertSame($total_up, $totally->getQuoteUp());
        $this->assertSame($total_use, $totally->getQuoteUse());
        $this->assertSame($total_created_at, DateTimeFactory::toIso8601Zulu($totally->getCreatedAt()));
        $this->assertSame($total_updated_at, DateTimeFactory::toIso8601Zulu($totally->getUpdatedAt()));
    }

    /**
     * @small
     *
     * @covers ::userBalance
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserBalanceWithUnknownReportTypeUid(): void
    {
        $report_type_uid = 'foo@bar';

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessageRegExp("~DataSeekObjectError\:.*Отсутствие объекта.*{$report_type_uid}~i");

        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . \sprintf(
                'user/balance/%s?_detailed=true', \urlencode($report_type_uid)
            ),
            'get',
            new Response(
                500, ['content-type' => 'application/json;charset=utf-8'], \json_encode((object) [
                'state' => $state = 'fail',
                'stamp' => $stamp = DateTimeFactory::toIso8601Zulu(new DateTime),
                'event' => (object) [
                    'uid'     => '',
                    'stamp'   => $stamp,
                    'cls'     => 'Data',
                    'type'    => 'DataSeekObjectError',
                    'name'    => 'Отсутствие объекта с заданным идентификатором',
                    'message' => "Отсутствует объект типа api.model.Report_Type с UID {$report_type_uid}",
                    'data'    => (object) [
                        'entity_type' => 'api.model.Report_Type',
                        'entity_uid'  => 'short_report_V1@avtocod1',
                    ],
                    'events'  => [],
                ],
            ]))
        );

        $this->client->userBalance($report_type_uid, true);
    }

    /**
     * @small
     *
     * @covers ::userBalance
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserBalanceWithWrongJson(): void
    {
        $this->expectException(BadResponseException::class);
        $this->expectExceptionMessageRegExp('~syntax~i');

        $this->guzzle_handler->onUriRequested(
            $this->settings->getBaseUri() . \sprintf(
                'user/balance/%s?_detailed=false', \urlencode($report_type_uid = 'foo@bar')
            ),
            'get',
            new Response(
                200, ['content-type' => 'application/json;charset=utf-8'], '{"foo":]'
            )
        );

        $this->client->userBalance($report_type_uid);
    }

    /**
     * @small
     *
     * @covers ::userBalance
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserBalanceWithServerError(): void
    {
        $this->expectException(BadRequestException::class);

        $this->guzzle_handler->onUriRequested(
            $uri = $this->settings->getBaseUri() . \sprintf(
                    'user/balance/%s?_detailed=false', \urlencode($report_type_uid = 'foo@bar')
                ),
            $method = 'get',
            new ConnectException(
                'cURL error 7: Failed to connect to host: Connection refused ...', new Request($method, $uri)
            )
        );

        $this->client->userBalance($report_type_uid);
    }

    /**
     * @small
     *
     * @covers ::userReportTypes
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserReportTypes(): void
    {
        $this->guzzle_handler->onUriRegexpRequested(
            '~' . preg_quote($this->settings->getBaseUri() . 'user/report_types', '/') . '.*~i',
            'get',
            new Response(
                200,
                ['content-type' => 'application/json;charset=utf-8'],
                \file_get_contents(__DIR__ . '/stubs/user__report_types__with_content_and_total.json')
            ),
            true
        );

        $response = $this->client->userReportTypes();

        $this->assertCount(11, $response->getData());
        $this->assertSame(11, $response->getTotal());

        $this->assertNull($response->getByUid('foo@bar'));

        $report_type = $response->getByUid('some_report_uid_4_test@some_domain_uid');

        $this->assertSame('some_report_uid_4_test@some_domain_uid', $report_type->getUid());
        $this->assertSame('', $report_type->getComment());
        $this->assertSame('Краткий отчет 7', $report_type->getName());
        $this->assertSame([], $report_type->getTags());
        $this->assertSame('PUBLISHED', $report_type->getState());
        $this->assertSame(90000000, $report_type->getMaxAge());
        $this->assertSame('some_domain_uid', $report_type->getDomainUid());
        $this->assertSame(['base', 'images.avtonomer', 'references.base'], $report_type->getContent()->getSources());
        $this->assertCount(19, $report_type->getContent()->getFields());
        $this->assertSame(0, $report_type->getDayQuote());
        $this->assertSame(0, $report_type->getMonthQuote());
        $this->assertSame(0, $report_type->getTotalQuote());
        $this->assertSame(201, $report_type->getMinPriority());
        $this->assertSame(204, $report_type->getMaxPriority());
        $this->assertSame(1000, $report_type->getPeriodPriority());
        $this->assertSame(2, $report_type->getMaxRequest());
        $this->assertEquals(
            DateTimeFactory::createFromIso8601Zulu('2017-06-08T13:05:27.377Z'), $report_type->getCreatedAt()
        );
        $this->assertSame('system', $report_type->getCreatedBy());
        $this->assertEquals(
            DateTimeFactory::createFromIso8601Zulu('2019-03-06T08:28:23.025Z'), $report_type->getUpdatedAt()
        );
        $this->assertSame('system', $report_type->getUpdatedBy());
        $this->assertEquals(
            DateTimeFactory::createFromIso8601Zulu('1900-01-01T00:00:00.000Z'), $report_type->getActiveFrom()
        );
        $this->assertEquals(
            DateTimeFactory::createFromIso8601Zulu('3000-01-01T00:00:00.000Z'), $report_type->getActiveTo()
        );
    }

    /**
     * @small
     *
     * @covers ::userReportTypes
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserReportTypesWithMinimalData(): void
    {
        $this->guzzle_handler->onUriRegexpRequested(
            '~' . preg_quote($this->settings->getBaseUri() . 'user/report_types', '/') . '.*~i',
            'get',
            new Response(
                200,
                ['content-type' => 'application/json;charset=utf-8'],
                \file_get_contents(__DIR__ . '/stubs/user__report_types__minimal.json')
            ),
            true
        );

        $response = $this->client->userReportTypes();

        $this->assertCount(11, $response->getData());
        $this->assertNull($response->getTotal());

        $this->assertNull($response->getByUid('foo@bar'));

        $report_type = $response->getByUid('some_report_uid_11@some_domain_uid');

        $this->assertSame('some_report_uid_11@some_domain_uid', $report_type->getUid());
        $this->assertSame('', $report_type->getComment());
        $this->assertSame('Краткий отчет 7', $report_type->getName());
        $this->assertSame(['SOME_TAG', 'AND_ONE_MORE'], $report_type->getTags());
        $this->assertSame('PUBLISHED', $report_type->getState());
        $this->assertSame(90000000, $report_type->getMaxAge());
        $this->assertSame('some_domain_uid', $report_type->getDomainUid());
        $this->assertNull($report_type->getContent());
        $this->assertSame(0, $report_type->getDayQuote());
        $this->assertSame(0, $report_type->getMonthQuote());
        $this->assertSame(1110, $report_type->getTotalQuote());
        $this->assertSame(201, $report_type->getMinPriority());
        $this->assertSame(204, $report_type->getMaxPriority());
        $this->assertSame(1000, $report_type->getPeriodPriority());
        $this->assertSame(2, $report_type->getMaxRequest());
        $this->assertEquals(
            DateTimeFactory::createFromIso8601Zulu('2017-06-08T13:05:27.377Z'), $report_type->getCreatedAt()
        );
        $this->assertSame('system', $report_type->getCreatedBy());
        $this->assertEquals(
            DateTimeFactory::createFromIso8601Zulu('2019-03-06T08:28:23.025Z'), $report_type->getUpdatedAt()
        );
        $this->assertSame('manager', $report_type->getUpdatedBy());
        $this->assertEquals(
            DateTimeFactory::createFromIso8601Zulu('1900-01-01T00:00:00.000Z'), $report_type->getActiveFrom()
        );
        $this->assertEquals(
            DateTimeFactory::createFromIso8601Zulu('3000-01-01T00:00:00.000Z'), $report_type->getActiveTo()
        );
    }

    /**
     * @small
     *
     * @covers ::userBalance
     * @covers ::doRequest
     *
     * @return void
     */
    public function testUserReportTypesWithOutdatedToken(): void
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessageRegExp('~SecurityAuthTimeoutedStamp\:.*просрочен~i');

        $this->guzzle_handler->onUriRegexpRequested(
            '~' . preg_quote($this->settings->getBaseUri() . 'user/report_types', '/') . '.*~i',
            'get',
            new Response(
                403, ['content-type' => 'application/json;charset=utf-8'], \json_encode((object) [
                'uid'     => '',
                'stamp'   => $stamp = DateTimeFactory::toIso8601Zulu(new DateTime),
                'cls'     => 'Security',
                'type'    => 'SecurityAuthTimeoutedStamp',
                'name'    => 'Метка времени просрочена',
                'message' => 'Метка времени Thu Jan 05 16:45:23 UTC 2017 просрочена - income_age:5, ' .
                             'server_time:Fri Jul 05 14:55:44 UTC 2019',
                'data'    => (object) [
                    'income_stamp' => '2017-01-05T16:45:23.000Z',
                    'income_age'   => 5,
                    'server_time'  => '2019-07-05T14:55:44.604Z',
                ],
                'events'  => [],
            ])),
            true
        );

        $this->client->userReportTypes();
    }
}

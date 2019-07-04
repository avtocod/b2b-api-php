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
        $this->guzzle_handler->onUriRequested(
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

    /**
     * @small
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
     * @return void
     */
    public function testDevTokenWithServerError(): void
    {
        self::markTestIncomplete();
    }

    /**
     * @small
     *
     * @return void
     */
    public function testUserInfo(): void
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
                            'id'          => $id = 123,
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
     * @return void
     */
    public function testUserInfoDetailed(): void
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
}

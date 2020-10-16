<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Feature;

use Dotenv\Dotenv;
use Avtocod\B2BApi\Client;
use Avtocod\B2BApi\Settings;
use Avtocod\B2BApi\Params\UserParams;
use Avtocod\B2BApi\Params\DevPingParams;
use Avtocod\B2BApi\Params\DevTokenParams;
use Avtocod\B2BApi\Tokens\Auth\AuthToken;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Params\UserReportParams;
use Avtocod\B2BApi\Params\UserBalanceParams;
use Avtocod\B2BApi\Params\UserReportsParams;
use Avtocod\B2BApi\Responses\Entities\Balance;
use Avtocod\B2BApi\Params\UserReportMakeParams;
use Avtocod\B2BApi\Params\UserReportTypesParams;
use Avtocod\B2BApi\Params\UserReportRefreshParams;

/**
 * @coversNothing
 */
class ClientTest extends AbstractTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $report_type;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

        $this->username    = \getenv('B2B_USER');
        $this->password    = \getenv('B2B_PASSWORD');
        $this->domain      = \getenv('B2B_DOMAIN');
        $this->report_type = \getenv('B2B_REPORT_TYPE');

        $this->client = new Client(new Settings(AuthToken::generate($this->username, $this->password, $this->domain)));
    }

    /**
     * @return void
     */
    public function testDevPing(): void
    {
        $this->assertSame(
            $value = 'feature test' . \random_int(1, 9999),
            $this->client->devPing((new DevPingParams)->setValue($value))->getValue()
        );
    }

    /**
     * @return void
     */
    public function testDevToken(): void
    {
        // Prepare params to request without domain
        $params = new DevTokenParams($this->username, $this->password);
        $params
            ->setPasswordHashed(false)
            ->setDateFrom($now = new \DateTimeImmutable)
            ->setTokenLifetime($age = 60);

        $response = $this->client->devToken($params);

        $this->assertSame($this->username, $response->getUser());
        $this->assertSame(
            AuthToken::generate($this->username, $this->password, null, $age, $now->getTimestamp()),
            $response->getToken()
        );

        // Prepare params to request with domain
        $params = new DevTokenParams($this->username . '@' . $this->domain, $this->password);
        $params
            ->setPasswordHashed(false)
            ->setDateFrom($now)
            ->setTokenLifetime($age);

        $response = $this->client->devToken($params);

        $this->assertSame($this->username . '@' . $this->domain, $response->getUser());
        $this->assertSame(
            AuthToken::generate($this->username, $this->password, $this->domain, $age, $now->getTimestamp()),
            $response->getToken()
        );
    }

    /**
     * @return void
     */
    public function testUser(): void
    {
        $this->assertSame(
            $uid = $this->username . '@' . $this->domain,
            $this->client->user(new UserParams)->getByUid($uid)->getUid()
        );
    }

    /**
     * @return void
     */
    public function testUserBalance(): void
    {
        $this->assertSame(
            $this->report_type,
            $this->client
                ->userBalance(new UserBalanceParams($this->report_type))
                ->getByType(Balance::TOTALLY)
                ->getReportTypeUid()
        );
    }

    /**
     * @return void
     */
    public function testUserReportTypes(): void
    {
        $this->assertSame(
            $this->domain,
            $this->client->userReportTypes(new UserReportTypesParams)->getByUid($this->report_type)->getDomainUid()
        );
    }

    /**
     * @return void
     */
    public function testUserReports(): void
    {
        $response = $this->client->userReports(new UserReportsParams);

        $this->assertGreaterThanOrEqual(1, $response->getSize());

        foreach ($response->getData() as $report) {
            $this->assertSame($this->domain, $report->getDomainUid());
        }
    }

    /**
     * @return void
     */
    public function testUserReport(): void
    {
        $reports    = $this->client->userReports(new UserReportsParams);
        $report_uid = $reports->first()->getUid();

        $report = $this->client->userReport(new UserReportParams($report_uid));

        $this->assertSame(1, $report->getSize());

        $this->assertNotEmpty($report->first()->getContent()->getContent());
        $this->assertNotEmpty($report->first()->getContent()->getByPath('identifiers'));
    }

    /**
     * @return void
     */
    public function testUserReportMake(): void
    {
        $this->assertStringContainsString(
            $vin = 'Z94CB41AAGR323020',
            $this->client
                ->userReportMake((new UserReportMakeParams($this->report_type, 'VIN', $vin))->setForce(true))
                ->first()
                ->getReportUid()
        );
    }

    /**
     * @small
     *
     * @return void
     */
    public function testUserReportRefresh(): void
    {
        $reports    = $this->client->userReports(new UserReportsParams);
        $report_uid = $reports->first()->getUid();
        $response   = $this->client->userReportRefresh(new UserReportRefreshParams($report_uid));

        $this->assertSame(
            $report_uid, $response->first()->getReportUid()
        );

        $this->assertTrue($response->first()->isNew());
    }
}

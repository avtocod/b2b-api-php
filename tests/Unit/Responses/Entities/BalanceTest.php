<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\Balance;

/**
 * @group  entities
 *
 * @covers \Avtocod\B2BApi\Responses\Entities\Balance<extended>
 */
class BalanceTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Balance::class, [], true);

        $balance = new Balance(
            $report_type_uid = $attributes['report_type_uid'],
            $balance_type = $attributes['balance_type'],
            $quote_init = $attributes['quote_init'],
            $quote_up = $attributes['quote_up'],
            $quote_use = $attributes['quote_use'],
            $created_at = DateTimeFactory::createFromIso8601Zulu($attributes['created_at']),
            $updated_at = DateTimeFactory::createFromIso8601Zulu($attributes['updated_at'])
        );

        $this->assertSame($report_type_uid, $balance->getReportTypeUid());
        $this->assertSame($balance_type, $balance->getBalanceType());
        $this->assertSame($quote_init, $balance->getQuoteInit());
        $this->assertSame($quote_up, $balance->getQuoteUp());
        $this->assertSame($quote_use, $balance->getQuoteUse());
        $this->assertSame($created_at, $balance->getCreatedAt());
        $this->assertSame($updated_at, $balance->getUpdatedAt());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Balance::class, [], true);

        $balance = Balance::fromArray([
            'report_type_uid' => $report_type_uid = $attributes['report_type_uid'],
            'balance_type'    => $balance_type = $attributes['balance_type'],
            'quote_init'      => $quote_init = $attributes['quote_init'],
            'quote_up'        => $quote_up = $attributes['quote_up'],
            'quote_use'       => $quote_use = $attributes['quote_use'],
            'created_at'      => $created_at = $attributes['created_at'],
            'updated_at'      => $updated_at = $attributes['updated_at'],
        ]);

        $this->assertSame($report_type_uid, $balance->getReportTypeUid());
        $this->assertSame($balance_type, $balance->getBalanceType());
        $this->assertSame($quote_init, $balance->getQuoteInit());
        $this->assertSame($quote_up, $balance->getQuoteUp());
        $this->assertSame($quote_use, $balance->getQuoteUse());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($created_at), $balance->getCreatedAt());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($updated_at), $balance->getUpdatedAt());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(Balance::class, [], true);

        $balance = Balance::fromArray([
            'report_type_uid' => $report_type_uid = $attributes['report_type_uid'],
            'balance_type'    => $balance_type = $attributes['balance_type'],
            'quote_init'      => $quote_init = $attributes['quote_init'],
            'quote_up'        => $quote_up = $attributes['quote_up'],
            'quote_use'       => $quote_use = $attributes['quote_use'],
        ]);

        $this->assertSame($report_type_uid, $balance->getReportTypeUid());
        $this->assertSame($balance_type, $balance->getBalanceType());
        $this->assertSame($quote_init, $balance->getQuoteInit());
        $this->assertSame($quote_up, $balance->getQuoteUp());
        $this->assertSame($quote_use, $balance->getQuoteUse());
        $this->assertNull($balance->getCreatedAt());
        $this->assertNull($balance->getUpdatedAt());
    }
}

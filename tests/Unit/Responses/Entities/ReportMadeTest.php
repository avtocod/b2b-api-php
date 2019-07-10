<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\ReportMade;

/**
 * @covers \Avtocod\B2BApi\Responses\Entities\ReportMade
 */
class ReportMadeTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportMade::class, [], true);

        $made = new ReportMade(
            $report_uid = $attributes['report_uid'],
            $is_new = $attributes['is_new'],
            $process_request_uid = $attributes['process_request_uid'],
            $suggest_get = DateTimeFactory::createFromIso8601Zulu($attributes['suggest_get'])
        );

        $this->assertSame($report_uid, $made->getReportUid());
        $this->assertSame($is_new, $made->isNew());
        $this->assertSame($process_request_uid, $made->getProcessRequestUid());
        $this->assertSame($suggest_get, $made->getSuggestGet());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportMade::class, [], true);

        $made = ReportMade::fromArray([
            'uid'                 => $report_uid = $attributes['report_uid'],
            'isnew'               => $is_new = $attributes['is_new'],
            'process_request_uid' => $process_request_uid = $attributes['process_request_uid'],
            'suggest_get'         => $suggest_get = $attributes['suggest_get'],
        ]);

        $this->assertSame($report_uid, $made->getReportUid());
        $this->assertSame($is_new, $made->isNew());
        $this->assertSame($process_request_uid, $made->getProcessRequestUid());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($suggest_get), $made->getSuggestGet());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportMade::class, [], true);

        $made = ReportMade::fromArray([
            'uid'         => $report_uid = $attributes['report_uid'],
            'isnew'       => $is_new = $attributes['is_new'],
            'suggest_get' => $suggest_get = $attributes['suggest_get'],
        ]);

        $this->assertSame($report_uid, $made->getReportUid());
        $this->assertSame($is_new, $made->isNew());
        $this->assertEquals(DateTimeFactory::createFromIso8601Zulu($suggest_get), $made->getSuggestGet());
    }
}

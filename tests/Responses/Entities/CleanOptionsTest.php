<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Responses\Entities;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\CleanOptions;

/**
 * @group  entities
 *
 * @covers \Avtocod\B2BApi\Responses\Entities\CleanOptions<extended>
 */
class CleanOptionsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(CleanOptions::class, [], true);

        $balance = new CleanOptions(
            $process_response = $attributes['process_response'],
            $process_request = $attributes['process_request'],
            $report_log = $attributes['report_log']
        );

        $this->assertSame($process_response, $balance->getProcessResponse());
        $this->assertSame($process_request, $balance->getProcessRequest());
        $this->assertSame($report_log, $balance->getReportLog());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(CleanOptions::class, [], true);

        $balance = CleanOptions::fromArray([
            'Process_Response' => $process_response = $attributes['process_response'],
            'Process_Request'  => $process_request = $attributes['process_request'],
            'ReportLog'        => $report_log = $attributes['report_log'],
        ]);

        $this->assertSame($process_response, $balance->getProcessResponse());
        $this->assertSame($process_request, $balance->getProcessRequest());
        $this->assertSame($report_log, $balance->getReportLog());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        $balance = CleanOptions::fromArray([]);

        $this->assertNull($balance->getProcessResponse());
        $this->assertNull($balance->getProcessRequest());
        $this->assertNull($balance->getReportLog());
    }
}

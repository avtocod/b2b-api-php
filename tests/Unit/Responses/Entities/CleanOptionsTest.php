<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

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

        $clean_options = new CleanOptions(
            $process_response = $attributes['process_response'],
            $process_request = $attributes['process_request'],
            $report_log = $attributes['report_log']
        );

        $this->assertSame($process_response, $clean_options->getProcessResponse());
        $this->assertSame($process_request, $clean_options->getProcessRequest());
        $this->assertSame($report_log, $clean_options->getReportLog());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(CleanOptions::class, [], true);

        $clean_options = CleanOptions::fromArray([
            'Process_Response' => $process_response = $attributes['process_response'],
            'Process_Request'  => $process_request = $attributes['process_request'],
            'ReportLog'        => $report_log = $attributes['report_log'],
        ]);

        $this->assertSame($process_response, $clean_options->getProcessResponse());
        $this->assertSame($process_request, $clean_options->getProcessRequest());
        $this->assertSame($report_log, $clean_options->getReportLog());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        $clean_options = CleanOptions::fromArray([]);

        $this->assertNull($clean_options->getProcessResponse());
        $this->assertNull($clean_options->getProcessRequest());
        $this->assertNull($clean_options->getReportLog());
    }
}

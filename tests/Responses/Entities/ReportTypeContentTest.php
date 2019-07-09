<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Responses\Entities;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\ReportTypeContent;

/**
 * @covers \Avtocod\B2BApi\Responses\Entities\ReportTypeContent
 */
class ReportTypeContentTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportTypeContent::class, [], true);

        $report_type_content = new ReportTypeContent(
            $sources = $attributes['sources'],
            $fields = $attributes['fields']
        );

        $this->assertSame($sources, $report_type_content->getSources());
        $this->assertSame($fields, $report_type_content->getFields());
    }

    /**
     * @return void
     */
    public function testConstructingFromArray(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportTypeContent::class, [], true);

        $report_type_content = ReportTypeContent::fromArray([
            'sources' => $sources = $attributes['sources'],
            'fields'  => $fields = $attributes['fields'],
        ]);

        $this->assertSame($sources, $report_type_content->getSources());
        $this->assertSame($fields, $report_type_content->getFields());
    }
}

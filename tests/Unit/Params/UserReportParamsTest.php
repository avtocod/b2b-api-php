<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Params;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Params\UserReportParams;

/**
 * @covers \Avtocod\B2BApi\Params\UserReportParams
 */
class UserReportParamsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testRequiredProperties(): void
    {
        $params = new UserReportParams(
            $report_uid = $this->faker->word
        );

        $this->assertSame($report_uid, $params->getReportUid());
    }

    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        $params = new UserReportParams($this->faker->word);
        $params
            ->setIncludeContent($is_include_content = $this->faker->boolean)
            ->setDetailed($is_detailed = $this->faker->boolean);

        $this->assertSame($is_include_content, $params->isIncludeContent());
        $this->assertSame($is_detailed, $params->isDetailed());
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        $params = new UserReportParams($this->faker->word);

        $this->assertNull($params->isIncludeContent());
        $this->assertNull($params->isDetailed());
    }
}

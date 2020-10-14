<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Params;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Params\UserBalanceParams;

/**
 * @covers \Avtocod\B2BApi\Params\UserBalanceParams
 */
class UserBalanceParamsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testRequiredProperties(): void
    {
        $params = new UserBalanceParams(
            $report_type_uid = $this->faker->word
        );

        $this->assertSame($report_type_uid, $params->getReportTypeUid());
    }

    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        $params = new UserBalanceParams($this->faker->word);
        $params->setDetailed($is_detailed = $this->faker->boolean);

        $this->assertSame($is_detailed, $params->isDetailed());
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        $params = new UserBalanceParams($this->faker->word);

        $this->assertFalse($params->isDetailed());
    }
}

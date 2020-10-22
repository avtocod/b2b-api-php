<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Params;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Params\UserReportRefreshParams;

/**
 * @covers \Avtocod\B2BApi\Params\UserReportRefreshParams
 */
class UserReportRefreshParamsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testRequiredProperties(): void
    {
        $params = new UserReportRefreshParams(
            $report_uid = $this->faker->word
        );

        $this->assertSame($report_uid, $params->getReportUid());
    }

    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        $params = new UserReportRefreshParams($this->faker->word);
        $params
            ->setOptions([
                ($key_one = $this->faker->word) => $this->faker->randomDigitNotNull,
                ($key_two = $this->faker->word) => $this->faker->word,
            ]);

        $this->assertArrayHasKey($key_one, $params->getOptions());
        $this->assertArrayHasKey($key_two, $params->getOptions());
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        $params = new UserReportRefreshParams($this->faker->word);

        $this->assertNull($params->getOptions());
    }
}

<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Params;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Params\ReportMakeParams;

/**
 * @covers \Avtocod\B2BApi\Params\ReportMakeParams
 */
class ReportMakeParamsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testRequiredProperties(): void
    {
        $params = new ReportMakeParams(
            $report_type_uid = $this->faker->word,
            $type = $this->faker->word,
            $value = $this->faker->word
        );

        $this->assertSame($report_type_uid, $params->getReportTypeUid());
        $this->assertSame($type, $params->getType());
        $this->assertSame($value, $params->getValue());
    }

    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        $params = new ReportMakeParams($this->faker->word, $this->faker->word, $this->faker->word);
        $params
            ->setOptions([
                ($key_one = $this->faker->word) => $this->faker->randomDigitNotNull,
                ($key_two = $this->faker->word) => $this->faker->word,
            ])
            ->setForce($is_force = $this->faker->boolean)
            ->setOnUpdateUrl($on_update = $this->faker->url)
            ->setOnCompleteUrl($on_complete = $this->faker->url)
            ->setData($data = $this->faker->words(3))
            ->setIdempotenceKey($idempotence_key = $this->faker->word);

        $this->assertSame($is_force, $params->isForce());
        $this->assertSame($idempotence_key, $params->getIdempotenceKey());
        $this->assertSame($on_update, $params->getOnUpdateUrl());
        $this->assertSame($on_complete, $params->getOnCompleteUrl());
        $this->assertSame($data, (array) $params->getData());

        $this->assertArrayHasKey($key_one, $params->getOptions());
        $this->assertArrayHasKey($key_two, $params->getOptions());
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        $params = new ReportMakeParams($this->faker->word, $this->faker->word, $this->faker->word);

        $this->assertFalse($params->isForce());
        $this->assertNull($params->getIdempotenceKey());
        $this->assertNull($params->getOnUpdateUrl());
        $this->assertNull($params->getOnCompleteUrl());
        $this->assertNull($params->getData());
    }
}

<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Params;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Params\DevPingParams;

/**
 * @covers \Avtocod\B2BApi\Params\DevPingParams
 */
class DevPingParamsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        $params = new DevPingParams;
        $params->setValue($ivalue = $this->faker->word);

        $this->assertSame($ivalue, $params->getValue());
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        $params = new DevPingParams;

        $this->assertNull($params->getValue());
    }
}

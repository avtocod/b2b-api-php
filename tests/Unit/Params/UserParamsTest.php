<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Params;

use Avtocod\B2BApi\Params\UserParams;
use Avtocod\B2BApi\Tests\AbstractTestCase;

/**
 * @covers \Avtocod\B2BApi\Params\UserParams
 */
class UserParamsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        $params = new UserParams;
        $params->setDetailed($is_detailed = $this->faker->boolean);

        $this->assertSame($is_detailed, $params->isDetailed());
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        $params = new UserParams;

        $this->assertNull($params->isDetailed());
    }
}

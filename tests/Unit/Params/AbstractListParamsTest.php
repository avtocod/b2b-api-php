<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Params;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Params\AbstractListParams;

/**
 * @covers \Avtocod\B2BApi\Params\AbstractListParams
 */
class AbstractListParamsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        /** @var AbstractListParams $params */
        $params = $this->getMockForAbstractClass('\Avtocod\B2BApi\Params\AbstractListParams');
        $params
            ->setQuery($query = $this->faker->word)
            ->setPage($page = $this->faker->randomDigitNotNull)
            ->setPerPage($per_page = $this->faker->randomDigitNotNull)
            ->setOffset($offset = $this->faker->randomDigitNotNull)
            ->setSortBy($sort_by = $this->faker->word)
            ->setWithContent($include_content = $this->faker->boolean)
            ->setCalcTotal($calc_total = $this->faker->boolean);

        $this->assertSame($query, $params->getQuery());
        $this->assertSame($page, $params->getPage());
        $this->assertSame($per_page, $params->getPerPage());
        $this->assertSame($offset, $params->getOffset());
        $this->assertSame($sort_by, $params->getSortBy());
        $this->assertSame($include_content, $params->isWithContent());
        $this->assertSame($calc_total, $params->isCalcTotal());
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        /** @var AbstractListParams $params */
        $params = $this->getMockForAbstractClass('\Avtocod\B2BApi\Params\AbstractListParams');

        $this->assertSame('_all', $params->getQuery());
        $this->assertSame(1, $params->getPage());
        $this->assertSame(20, $params->getPerPage());
        $this->assertSame(0, $params->getOffset());
        $this->assertSame('-created_at', $params->getSortBy());
        $this->assertFalse($params->isWithContent());
        $this->assertFalse($params->isCalcTotal());
    }
}

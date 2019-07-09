<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Responses\Entities;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\ReportQuery;

/**
 * @covers \Avtocod\B2BApi\Responses\Entities\ReportQuery
 */
class ReportQueryTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportQuery::class, [], true);

        $query = new ReportQuery(
            $type = $attributes['type'],
            $body = $attributes['body'],
            $data = $attributes['data']
        );

        $this->assertSame($type, $query->getType());
        $this->assertSame($body, $query->getBody());
        $this->assertSame($data, $query->getData());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportQuery::class, [], true);

        $query = ReportQuery::fromArray([
            'type' => $type = $attributes['type'],
            'body' => $body = $attributes['body'],
            'data' => $data = $attributes['data'],
        ]);

        $this->assertSame($type, $query->getType());
        $this->assertSame($body, $query->getBody());
        $this->assertSame($data, $query->getData());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        $query = ReportQuery::fromArray([]);

        $this->assertNull($query->getBody());
        $this->assertNull($query->getType());
        $this->assertNull($query->getData());
    }
}

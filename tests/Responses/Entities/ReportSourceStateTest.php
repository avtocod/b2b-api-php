<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Responses\Entities;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Responses\Entities\ReportSourceState;

/**
 * @covers \Avtocod\B2BApi\Responses\Entities\ReportSourceState
 */
class ReportSourceStateTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportSourceState::class, [], true);

        $instance = new ReportSourceState(
            $name = $attributes['_id'],
            $state = $attributes['state'],
            $data = $attributes['data']
        );

        $this->assertSame($name, $instance->getName());
        $this->assertSame($state, $instance->getState());
        $this->assertSame($data, $instance->getData());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayAllValues(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportSourceState::class, [], true);

        $instance = ReportSourceState::fromArray([
            'name'  => $name = $attributes['_id'],
            'state' => $state = $attributes['state'],
            'data'  => $data = $attributes['data'],
        ]);

        $this->assertSame($name, $instance->getName());
        $this->assertSame($state, $instance->getState());
        $this->assertSame($data, $instance->getData());
    }

    /**
     * @return void
     */
    public function testConstructingFromArrayRequiredValuesOnly(): void
    {
        /** @var array $attributes */
        $attributes = EntitiesFactory::make(ReportSourceState::class, [], true);

        $instance = ReportSourceState::fromArray([
            'name'  => $name = $attributes['_id'],
            'state' => $state = $attributes['state'],
        ]);

        $this->assertSame($name, $instance->getName());
        $this->assertSame($state, $instance->getState());
        $this->assertNull($instance->getData());
    }
}

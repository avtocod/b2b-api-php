<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Responses\Entities;

use Avtocod\B2BApi\Responses\Entities\ReportSourceState;
use Avtocod\B2BApi\Responses\Entities\ReportState;
use Avtocod\B2BApi\Tests\AbstractTestCase;

/**
 * @covers \Avtocod\B2BApi\Responses\Entities\ReportState
 */
class ReportStateTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testGetters(): void
    {
        $instance = new ReportState([$report_source_state = EntitiesFactory::make(ReportSourceState::class)]);

        $this->assertSame($report_source_state, $instance->getSourceStates()[0]);
    }

    /**
     * @return void
     */
    public function testByNameGetters(): void
    {
        /** @var ReportSourceState $report_source_state */
        $instance = new ReportState([$report_source_state = EntitiesFactory::make(ReportSourceState::class)]);

        $this->assertSame($report_source_state, $instance->getSourceStateByName($report_source_state->getName()));
        $this->assertNull($instance->getSourceStateByName($this->faker->word));
    }

    /**
     * @small
     *
     * @return void
     */
    public function testConstructingFromArray(): void
    {
        /** @var ReportSourceState $report_source_state */
        $instance = ReportState::fromArray([
            'sources' => [$report_source_state = EntitiesFactory::make(ReportSourceState::class, [], true)]
        ]);

        $this->assertSame($report_source_state['_id'], $instance->getSourceStates()[0]->getName());
    }
}

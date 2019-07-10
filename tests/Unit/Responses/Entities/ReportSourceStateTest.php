<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Responses\Entities;

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
    public function testConstants(): void
    {
        $this->assertSame('ERROR', ReportSourceState::ERROR);
        $this->assertSame('OK', ReportSourceState::SUCCESS);
        $this->assertSame('PROGRESS', ReportSourceState::PROGRESS);
    }

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
    public function testProgressState(): void
    {
        /** @var ReportSourceState $instance */
        $instance = EntitiesFactory::make(ReportSourceState::class, [
            'state' => 'PROGRESS',
        ]);

        $this->assertTrue($instance->isInProgress());
        $this->assertFalse($instance->isCompleted());
        $this->assertFalse($instance->isSuccess());
        $this->assertFalse($instance->isErrored());
    }

    /**
     * @return void
     */
    public function testErrorState(): void
    {
        /** @var ReportSourceState $instance */
        $instance = EntitiesFactory::make(ReportSourceState::class, [
            'state' => 'ERROR',
        ]);

        $this->assertFalse($instance->isInProgress());
        $this->assertTrue($instance->isCompleted());
        $this->assertFalse($instance->isSuccess());
        $this->assertTrue($instance->isErrored());
    }

    /**
     * @return void
     */
    public function testOkState(): void
    {
        /** @var ReportSourceState $instance */
        $instance = EntitiesFactory::make(ReportSourceState::class, [
            'state' => 'OK',
        ]);

        $this->assertFalse($instance->isInProgress());
        $this->assertTrue($instance->isCompleted());
        $this->assertTrue($instance->isSuccess());
        $this->assertFalse($instance->isErrored());
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

<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests;

use Avtocod\B2BApi\DateTimeFactory;
use DateTime;

/**
 * @group datetime
 *
 * @covers \Avtocod\B2BApi\DateTimeFactory<extended>
 */
class DateTimeFactoryTest extends AbstractTestCase
{
    /**
     * @small
     *
     * @return void
     */
    public function testCreateFromIso8601ZuluWithZeroMicroseconds(): void
    {
        $datetime = DateTimeFactory::createFromIso8601Zulu('2017-01-05T16:45:23.000Z');

        $this->assertSame('2017', $datetime->format('Y'));
        $this->assertSame('01', $datetime->format('m'));
        $this->assertSame('05', $datetime->format('d'));
        $this->assertSame('16', $datetime->format('H'));
        $this->assertSame('45', $datetime->format('i'));
        $this->assertSame('23', $datetime->format('s'));
        $this->assertSame('000', $datetime->format('v'));
    }

    /**
     * @small
     *
     * @return void
     */
    public function testCreateFromIso8601ZuluWithSixZeroMicroseconds(): void
    {
        $datetime = DateTimeFactory::createFromIso8601Zulu('2017-01-05T16:45:23.000000Z');

        $this->assertSame('2017', $datetime->format('Y'));
        $this->assertSame('01', $datetime->format('m'));
        $this->assertSame('05', $datetime->format('d'));
        $this->assertSame('16', $datetime->format('H'));
        $this->assertSame('45', $datetime->format('i'));
        $this->assertSame('23', $datetime->format('s'));
        $this->assertSame('000', $datetime->format('v'));
    }

    /**
     * @small
     *
     * @return void
     */
    public function testCreateFromIso8601ZuluWithMicroseconds(): void
    {
        $datetime = DateTimeFactory::createFromIso8601Zulu('2017-01-05T16:45:23.332Z');

        $this->assertSame('2017', $datetime->format('Y'));
        $this->assertSame('01', $datetime->format('m'));
        $this->assertSame('05', $datetime->format('d'));
        $this->assertSame('16', $datetime->format('H'));
        $this->assertSame('45', $datetime->format('i'));
        $this->assertSame('23', $datetime->format('s'));
        $this->assertSame('332', $datetime->format('v'));
    }

    /**
     * @small
     *
     * @return void
     */
    public function testCreateFromIso8601ZuluWithSixMicroseconds(): void
    {
        $datetime = DateTimeFactory::createFromIso8601Zulu('2017-01-05T16:45:23.332123Z');

        $this->assertSame('2017', $datetime->format('Y'));
        $this->assertSame('01', $datetime->format('m'));
        $this->assertSame('05', $datetime->format('d'));
        $this->assertSame('16', $datetime->format('H'));
        $this->assertSame('45', $datetime->format('i'));
        $this->assertSame('23', $datetime->format('s'));
        $this->assertSame('332', $datetime->format('v'));
    }

    /**
     * @small
     *
     * @return void
     */
    public function testToIso8601ZuluWitMicroseconds(): void
    {
        $date_time = DateTime::createFromFormat('Y-m-d H:i:s u', '2009-02-15 15:16:17 123');

        $this->assertSame('2009-02-15T15:16:17.123Z', DateTimeFactory::toIso8601Zulu($date_time));
    }

    /**
     * @small
     *
     * @return void
     */
    public function testToIso8601ZuluWithoutMicroseconds(): void
    {
        $date_time = DateTime::createFromFormat('Y-m-d H:i:s', '2009-02-15 15:16:17');

        $this->assertSame('2009-02-15T15:16:17.000Z', DateTimeFactory::toIso8601Zulu($date_time));
    }
}

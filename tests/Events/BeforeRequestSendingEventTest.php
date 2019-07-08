<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Events;

use GuzzleHttp\Psr7\Request;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Events\BeforeRequestSendingEvent;

/**
 * @covers \Avtocod\B2BApi\Events\BeforeRequestSendingEvent
 */
class BeforeRequestSendingEventTest extends AbstractTestCase
{
    /**
     * @small
     *
     * @return void
     */
    public function testGetters(): void
    {
        $event = new BeforeRequestSendingEvent(
            $request = new Request('get', 'http://goo.gl'),
            $options = ['foo' => 'bar']
        );

        $this->assertSame($request, $event->getRequest());
        $this->assertSame($options, $event->getOptions());
    }
}

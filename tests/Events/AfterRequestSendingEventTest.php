<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Events;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Events\AfterRequestSendingEvent;

/**
 * @covers \Avtocod\B2BApi\Events\AfterRequestSendingEvent
 */
class AfterRequestSendingEventTest extends AbstractTestCase
{
    /**
     * @small
     *
     * @return void
     */
    public function testGetters(): void
    {
        $event = new AfterRequestSendingEvent(
            $request = new Request('get', 'http://goo.gl'),
            $response = new Response,
            $duration = \random_int(1, 1000)
        );

        $this->assertSame($request, $event->getRequest());
        $this->assertSame($response, $event->getResponse());
        $this->assertSame($duration, $event->getDuration());
    }
}

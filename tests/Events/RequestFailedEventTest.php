<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Events;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Events\RequestFailedEvent;

/**
 * @covers \Avtocod\B2BApi\Events\RequestFailedEvent
 */
class RequestFailedEventTest extends AbstractTestCase
{
    /**
     * @small
     *
     * @return void
     */
    public function testGetters(): void
    {
        $event = new RequestFailedEvent(
            $request = new Request('get', 'http://goo.gl'),
            $response = new Response
        );

        $this->assertSame($request, $event->getRequest());
        $this->assertSame($response, $event->getResponse());
    }
}

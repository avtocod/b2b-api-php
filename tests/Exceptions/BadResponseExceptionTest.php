<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Exceptions;

use RuntimeException;
use GuzzleHttp\Psr7\Response;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Avtocod\B2BApi\Exceptions\B2BApiExceptionInterface;

/**
 * @covers \Avtocod\B2BApi\Exceptions\BadResponseException
 */
class BadResponseExceptionTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testInstanceAndGetters(): void
    {
        $exception = new BadResponseException($response = new Response, $message = 'foo');

        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertInstanceOf(B2BApiExceptionInterface::class, $exception);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($response, $exception->getHttpResponse());
    }

    /**
     * @return void
     */
    public function testFabrics(): void
    {
        $response = new Response;

        $this->assertRegExp('~Server.*wrong json~i', ($e = BadResponseException::wrongJson($response))->getMessage());
        $this->assertSame($response, $e->getHttpResponse());
    }
}

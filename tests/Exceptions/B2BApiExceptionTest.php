<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Exceptions;

use Avtocod\B2BApi\Exceptions\B2BApiException;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use RuntimeException;

/**
 * @covers \Avtocod\B2BApi\Exceptions\B2BApiException
 */
class B2BApiExceptionTest extends AbstractTestCase
{
    /**
     * @small
     *
     * @return void
     */
    public function testInstance(): void
    {
        $this->assertInstanceOf(RuntimeException::class, new B2BApiException);
    }
}

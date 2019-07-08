<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Exceptions;

use Exception;
use RuntimeException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Exceptions\BadRequestException;
use Avtocod\B2BApi\Exceptions\B2BApiExceptionInterface;

/**
 * @covers \Avtocod\B2BApi\Exceptions\BadRequestException
 */
class BadRequestExceptionTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testInstanceAndGetters(): void
    {
        $exception = new BadRequestException(
            $request = new Request('get', $this->faker->url),
            $response = new Response,
            $message = $this->faker->word,
            $code = \random_int(1, 100),
            $prev = new Exception()
        );

        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertInstanceOf(B2BApiExceptionInterface::class, $exception);

        $this->assertSame($request, $exception->getHttpRequest());
        $this->assertSame($response, $exception->getHttpResponse());
        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($prev, $exception->getPrevious());
    }

    /**
     * @return void
     */
    public function testErrorMessageExtractingUsingB2BApiGenericSystemError(): void
    {
        $exception = new BadRequestException(
            $request = new Request('get', $this->faker->url),
            $response = new Response(500, [], \file_get_contents(__DIR__ . '/../stubs/generic_system_error_500.json'))
        );

        $this->assertRegExp(
            '~GenericSystemError\:\s.+ошибка.+DataAccessResourceFailureException~iu',
            $exception->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testErrorMessageExtractingUsingB2BApiMissingReportTypeError(): void
    {
        $exception = new BadRequestException(
            $request = new Request('get', $this->faker->url),
            $response = new Response(500, [], \file_get_contents(__DIR__ . '/../stubs/report_type_not_found_500.json'))
        );

        $this->assertRegExp(
            '~DataSeekObjectError\:\s.?Отсутствие.+Report_Type~iu',
            $exception->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testErrorMessageExtractingUsingB2BApiWrongJsonError(): void
    {
        $exception = new BadRequestException(
            $request = new Request('get', $this->faker->url),
            $response = new Response(500, [], \file_get_contents(__DIR__ . '/../stubs/wrong_json_passed_400.json'))
        );

        $this->assertRegExp(
            '~Bad Request\:\s.*HttpMessageNotReadableException.+Bad Request~iu',
            $exception->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testErrorMessageExtractingUsingB2BApiWrongAuthTokenError(): void
    {
        $exception = new BadRequestException(
            $request = new Request('get', $this->faker->url),
            $response = new Response(500, [], \file_get_contents(__DIR__ . '/../stubs/wrong_token_error_400.json'))
        );

        $this->assertRegExp(
            '~SecurityAuthMalformedToken\:\sНеверная структура.+Неверная структура~iu',
            $exception->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testPrevExceptionMessageGetting(): void
    {
        $exception = new BadRequestException(
            $request = new Request('get', $this->faker->url),
            $response = new Response(500),
            $message = null,
            $code = null,
            $previous = new Exception('foo bar')
        );

        $this->assertSame($previous->getMessage(), $exception->getMessage());
    }

    /**
     * @return void
     */
    public function testMessagePassing(): void
    {
        $exception = new BadRequestException(
            $request = new Request('get', $this->faker->url),
            $response = new Response(500),
            $message = 'foo bar',
            $code = null,
            $previous = new Exception('bar baz')
        );

        $this->assertSame($message, $exception->getMessage());
    }
}

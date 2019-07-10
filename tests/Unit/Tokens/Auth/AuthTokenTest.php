<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Tokens\Auth;

use Avtocod\B2BApi\Tokens\Auth\AuthToken;
use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Exceptions\TokenParserException;

/**
 * @covers \Avtocod\B2BApi\Tokens\Auth\AuthToken
 */
class AuthTokenTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testParsing(): void
    {
        $tokens = [
            'dGVzdEB0ZXN0OjE0ODM2MzQ3MjM6NTpaVGZBTzQramFDdmhWMCs2elk1dWFnPT0=',
        ];

        foreach ($tokens as $token) {
            $info = AuthToken::parse($token);

            $this->assertSame('test@test', $info->getUser());
            $this->assertSame(1483634723, $info->getTimestamp());
            $this->assertSame(5, $info->getAge());
            $this->assertSame('ZTfAO4+jaCvhV0+6zY5uag==', $info->getSaltedHash());
        }
    }

    /**
     * @return void
     */
    public function testParsingThrowsAnExceptionWhenPassedWrongToken(): void
    {
        foreach (['asdadad', 'DFSDF fsdfsf', ''] as $wrong_token) {
            $throws = false;

            try {
                AuthToken::parse($wrong_token);
            } catch (TokenParserException $e) {
                $this->assertRegExp('~Cannot.*parse~i', $e->getMessage());

                $throws = true;
            }

            $this->assertTrue($throws);
        }
    }

    /**
     * @return void
     */
    public function testGeneration(): void
    {
        $this->assertSame(
            'dGVzdEB0ZXN0OjE0ODM2MzQ3MjM6NTpaVGZBTzQramFDdmhWMCs2elk1dWFnPT0=',
            AuthToken::generate(
                $username = 'test',
                $password = '123',
                $domain = 'test',
                $age = 5,
                $timestamp = 1483634723
            )
        );

        $parsed = AuthToken::parse(AuthToken::generate(
            $username = 'test',
            $password = '123',
            $domain = null,
            $age = 5,
            $timestamp = null
        ));

        $this->assertSame($username, $parsed->getUser());
        $this->assertSame($age, $parsed->getAge());
        $this->assertEquals(time(), $parsed->getTimestamp(), '', 1);
    }
}

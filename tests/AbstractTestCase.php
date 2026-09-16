<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests;

use Faker\Generator as Faker;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use AvtoDev\GuzzleUrlMock\UrlsMockHandler;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @var Faker
     */
    protected $faker;

    /**
     * @var UrlsMockHandler
     */
    protected $guzzle_handler;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();

        $this->guzzle_handler = new UrlsMockHandler;

        // Setup default responses
        foreach (['get', 'post', 'put', 'delete', 'head', 'update'] as $method) {
            $this->guzzle_handler->onUriRegexpRequested("~(?'{$method}').*~iu", $method, new Response(
                404, [], 'Response mocked for testing'
            ));
        }
    }

    /**
     * @param string $pattern
     * @param string $string
     * @param string $message
     *
     * @return void
     */
    protected function assertMatchesRegExp(string $pattern, string $string, string $message = ''): void
    {
        if (\method_exists($this, 'assertMatchesRegularExpression')) {
            $this->assertMatchesRegularExpression($pattern, $string, $message);

            return;
        }

        $this->assertRegExp($pattern, $string, $message);
    }
}

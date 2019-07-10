<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests;

use Faker\Generator as Faker;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tarampampam\GuzzleUrlMock\UrlsMockHandler;

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
}

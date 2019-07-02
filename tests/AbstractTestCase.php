<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests;

use Faker\Generator as Faker;
use PHPUnit\Framework\TestCase;

class AbstractTestCase extends TestCase
{
    /**
     * @var Faker
     */
    protected $faker;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();;
    }
}

<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Params;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Params\DevTokenParams;

/**
 * @covers \Avtocod\B2BApi\Params\DevTokenParams
 */
class DevTokenParamsTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testRequiredProperties(): void
    {
        $params = new DevTokenParams($username = $this->faker->word, $password = $this->faker->word);

        $this->assertSame($username, $params->getUsername());
        $this->assertSame($password, $params->getPassword());
    }

    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        $params = new DevTokenParams($this->faker->word, $this->faker->word);
        $params
            ->setPasswordHashed($is_password_hashed = $this->faker->boolean)
            ->setDateFrom($date = new \DateTimeImmutable)
            ->setTokenLifetime($token_lifetime = $this->faker->randomDigitNotNull);

        $this->assertSame($is_password_hashed, $params->isPasswordHashed());
        $this->assertSame($date, $params->getDateFrom());
        $this->assertSame($token_lifetime, $params->getTokenLifetime());
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        $params = new DevTokenParams($this->faker->word, $this->faker->word);

        $this->assertFalse($params->isPasswordHashed());
        $this->assertNull($params->getDateFrom());
        $this->assertSame(60, $params->getTokenLifetime());
    }
}

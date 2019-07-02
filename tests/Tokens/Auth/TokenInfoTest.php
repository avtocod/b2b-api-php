<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Tokens\Auth;

use Avtocod\B2BApi\Tokens\Auth\TokenInfo;
use Avtocod\B2BApi\Tests\AbstractTestCase;

/**
 * @covers \Avtocod\B2BApi\Tokens\Auth\TokenInfo<extended>
 */
class TokenInfoTest extends AbstractTestCase
{
    /**
     * @small
     *
     * @return void
     */
    public function testBasicGetters(): void
    {
        $token_info = new TokenInfo(
            $user = "{$this->faker->userName}@{$this->faker->company}",
            $timestamp = $this->faker->randomNumber(),
            $age = $this->faker->randomNumber(),
            $salted_hash = $this->faker->sha1
        );

        $this->assertSame($user, $token_info->getUser());
        $this->assertSame($timestamp, $token_info->getTimestamp());
        $this->assertSame($age, $token_info->getAge());
        $this->assertSame($salted_hash, $token_info->getSaltedHash());
    }

    /**
     * @small
     *
     * @return void
     */
    public function testDomainAndUsernameGetters(): void
    {
        foreach (\range(1, 50) as $i) {
            $username = $this->faker->randomElement([
                $this->faker->userName,
                $this->faker->domainName,
                $this->faker->firstName,
            ]);

            $domain = $this->faker->randomElement([
                $this->faker->company,
                $this->faker->domainName,
                $this->faker->lastName,
            ]);

            $token_info = new TokenInfo(
                "{$username}@{$domain}",
                $this->faker->randomNumber(),
                $this->faker->randomNumber(),
                $this->faker->sha1
            );

            $this->assertSame($username, $token_info->getUsername());
            $this->assertSame($domain, $token_info->getDomainName());
        }

        $token_info = new TokenInfo(
            $this->faker->userName,
            $this->faker->randomNumber(),
            $this->faker->randomNumber(),
            $this->faker->sha1
        );

        $this->assertNull($token_info->getUsername());
        $this->assertNull($token_info->getDomainName());
    }
}

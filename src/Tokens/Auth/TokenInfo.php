<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tokens\Auth;

class TokenInfo
{
    protected const USERNAME_AND_DOMAIN_DELIMITER = '@';

    /**
     * @var string
     */
    protected $user;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var int
     */
    protected $age;

    /**
     * @var string
     */
    protected $salted_hash;

    /**
     * Create a new TokenInfo instance.
     *
     * @param string $user        Like `user@domain`
     * @param int    $timestamp
     * @param int    $age
     * @param string $salted_hash
     */
    public function __construct(string $user, int $timestamp, int $age, string $salted_hash)
    {
        $this->user        = $user;
        $this->timestamp   = $timestamp;
        $this->age         = $age;
        $this->salted_hash = $salted_hash;
    }

    /**
     * Get token username (like `user@domain`).
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Extract and return domain name (without username).
     *
     * @return string|null
     */
    public function getDomainName(): ?string
    {
        if (\mb_strpos($this->user, static::USERNAME_AND_DOMAIN_DELIMITER) !== false) {
            $domain = (string) \mb_substr(
                $this->user,
                \mb_strpos($this->user, static::USERNAME_AND_DOMAIN_DELIMITER) + 1,
                null
            );

            if ($domain !== '') {
                return $domain;
            }
        }

        return null;
    }

    /**
     * Extract and return username (without domain) from user.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        if (\mb_strpos($this->user, static::USERNAME_AND_DOMAIN_DELIMITER) !== false) {
            $username = (string) \mb_substr(
                $this->user,
                0,
                \mb_strpos($this->user, static::USERNAME_AND_DOMAIN_DELIMITER)
            );

            if ($username !== '') {
                return $username;
            }
        }

        return null;
    }

    /**
     * Get token timestamp.
     *
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * Get token age.
     *
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * Get token salted hash.
     *
     * @return string
     */
    public function getSaltedHash(): string
    {
        return $this->salted_hash;
    }
}

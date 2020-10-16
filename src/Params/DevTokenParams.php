<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

use DateTime;

final class DevTokenParams
{
    /**
     * User identifier (e.g.: `test@test`).
     *
     * @var string
     */
    private $username;

    /**
     * User password.
     *
     * @var string
     */
    private $password;

    /**
     * True, if user password hashed.
     *
     * @var bool
     */
    private $is_password_hashed = false;

    /**
     * Token availability start date.
     *
     * @var DateTime|null
     */
    private $date_from = null;

    /**
     * Token lifetime (in seconds).
     *
     * @var int
     */
    private $token_lifetime = 60;

    /**
     * @param string $username User identifier (e.g.: `test@test`)
     * @param string $password User password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Get user identifier (e.g.: `test@test`).
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get user password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function isPasswordHashed(): bool
    {
        return $this->is_password_hashed;
    }

    /**
     * @param bool $is_password_hashed
     *
     * @return $this
     */
    public function setPasswordHashed(bool $is_password_hashed): self
    {
        $this->is_password_hashed = $is_password_hashed;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateFrom(): ?DateTime
    {
        return $this->date_from;
    }

    /**
     * @param DateTime|null $date_from
     *
     * @return $this
     */
    public function setDateFrom(?DateTime $date_from): self
    {
        $this->date_from = $date_from;

        return $this;
    }

    /**
     * @return int
     */
    public function getTokenLifetime(): int
    {
        return $this->token_lifetime;
    }

    /**
     * @param int $token_lifetime
     *
     * @return $this
     */
    public function setTokenLifetime(int $token_lifetime): self
    {
        $this->token_lifetime = $token_lifetime;

        return $this;
    }
}

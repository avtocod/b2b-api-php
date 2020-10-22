<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

use DateTime;

class DevTokenParams
{
    /**
     * User identifier (e.g.: `test@test`).
     *
     * @var string
     */
    protected $username;

    /**
     * User password.
     *
     * @var string
     */
    protected $password;

    /**
     * True, if user password hashed.
     *
     * @var bool|null
     */
    protected $is_password_hashed;

    /**
     * Token availability start date.
     *
     * @var DateTime|null
     */
    protected $date_from;

    /**
     * Token lifetime (in seconds).
     *
     * @var int|null
     */
    protected $token_lifetime;

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
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return bool|null
     */
    public function isPasswordHashed(): ?bool
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
     * @param DateTime $date_from
     *
     * @return $this
     */
    public function setDateFrom(DateTime $date_from): self
    {
        $this->date_from = $date_from;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTokenLifetime(): ?int
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

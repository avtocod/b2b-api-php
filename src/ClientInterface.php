<?php

namespace Avtocod\B2BApi;

use DateTime;
use Avtocod\B2BApi\Responses\UserResponse;
use Avtocod\B2BApi\Responses\DevPingResponse;
use Avtocod\B2BApi\Responses\DevTokenResponse;
use Avtocod\B2BApi\Exceptions\BadRequestException;
use Avtocod\B2BApi\Exceptions\BadResponseException;

interface ClientInterface
{
    /**
     * Test connection.
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return DevPingResponse
     */
    public function devPing(): DevPingResponse;

    /**
     * Debug token generation.
     *
     * @param string        $username  User identifier (e.g.: `test@test`)
     * @param string        $password  User password
     * @param bool          $is_hash   Password hashed?
     * @param DateTime|null $date_from Token availability start date
     * @param int           $age       Token lifetime (in seconds)
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return DevTokenResponse
     */
    public function devToken(string $username,
                             string $password,
                             bool $is_hash = false,
                             ?DateTime $date_from = null,
                             int $age = 60): DevTokenResponse;

    /**
     * Retrieve information about current user.
     *
     * @param bool $detailed
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserResponse
     */
    public function user(bool $detailed = false): UserResponse;
}

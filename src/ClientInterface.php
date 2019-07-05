<?php

namespace Avtocod\B2BApi;

use DateTime;
use Avtocod\B2BApi\Responses\UserResponse;
use Avtocod\B2BApi\Responses\DevPingResponse;
use Avtocod\B2BApi\Responses\DevTokenResponse;
use Avtocod\B2BApi\Responses\UserBalanceResponse;
use Avtocod\B2BApi\Exceptions\BadRequestException;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Avtocod\B2BApi\Responses\UserReportTypesResponse;

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

    /**
     * Retrieve balance information for report type.
     *
     * @param string $report_type_uid E.g.: `report_type@domain`
     * @param bool   $detailed
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserBalanceResponse
     */
    public function userBalance(string $report_type_uid, bool $detailed = false): UserBalanceResponse;

    /**
     * Retrieve report types data.
     *
     * @param bool   $can_generate User nac generate reports for report type?
     * @param bool   $content      Include report content rules
     * @param string $query
     * @param int    $size         Maximum entries per page
     * @param int    $offset       Pagination offset
     * @param int    $page         Page number
     * @param string $sort         Sorting rules
     * @param bool   $calc_total   Calculate total report types count
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportTypesResponse
     */
    public function userReportTypes(bool $can_generate = false,
                                    bool $content = false,
                                    string $query = '_all',
                                    int $size = 20,
                                    int $offset = 0,
                                    int $page = 1,
                                    string $sort = '-created_at',
                                    bool $calc_total = false): UserReportTypesResponse;
}

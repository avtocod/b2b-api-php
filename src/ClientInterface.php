<?php

namespace Avtocod\B2BApi;

use DateTime;
use Avtocod\B2BApi\Responses\UserResponse;
use Avtocod\B2BApi\Responses\DevPingResponse;
use Avtocod\B2BApi\Responses\DevTokenResponse;
use Avtocod\B2BApi\Responses\UserReportResponse;
use Avtocod\B2BApi\Responses\UserBalanceResponse;
use Avtocod\B2BApi\Responses\UserReportsResponse;
use Avtocod\B2BApi\Exceptions\BadRequestException;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Avtocod\B2BApi\Responses\UserReportMakeResponse;
use Avtocod\B2BApi\Responses\UserReportTypesResponse;
use Avtocod\B2BApi\Responses\UserReportRefreshResponse;

interface ClientInterface
{
    /**
     * Test connection.
     *
     * @param string $value Any string value (server must returns it back)
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return DevPingResponse
     */
    public function devPing(?string $value = null): DevPingResponse;

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
    public function userBalance(string $report_type_uid,
                                bool $detailed = false): UserBalanceResponse;

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

    /**
     * Get reports list.
     *
     * @param bool   $content    Include reports content into response
     * @param string $query
     * @param int    $size       Maximum entries per page
     * @param int    $offset     Pagination offset
     * @param int    $page       Page number
     * @param string $sort       Sorting rules
     * @param bool   $calc_total Calculate total reports count
     * @param bool   $detailed
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportsResponse
     */
    public function userReports(bool $content = false,
                                string $query = '_all',
                                int $size = 20,
                                int $offset = 0,
                                int $page = 1,
                                string $sort = '-created_at',
                                bool $calc_total = false,
                                bool $detailed = false): UserReportsResponse;

    /**
     * Get report by unique report ID.
     *
     * @param string $report_uid Report unique ID (e.g.: `some_report_uid_YV1KS9614S107357Y@domain`)
     * @param bool   $content    Include content into response
     * @param bool   $detailed
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportResponse
     */
    public function userReport(string $report_uid,
                               bool $content = true,
                               bool $detailed = true): UserReportResponse;

    /**
     * Make report.
     *
     * @param string      $report_type_uid Unique report type ID (e.g.: `some_report_uid` or `some_report_uid@domain`)
     * @param string      $type            Request type (e.g.: `VIN`, `GRZ`, `STS`, `PTS`, `CHASSIS`, `BODY`, etc.)
     * @param string      $value           Request body (e.g.: `Z94CB41AAGR323020` (VIN-code), `А111АА177` (GRZ-code))
     * @param array|null  $options         Additional request options
     * @param bool|null   $is_force        Force update report, if it already was generated previously
     * @param string|null $on_update       Call (using `post` method) when report content updated
     * @param string|null $on_complete     Call (using `post` method) when report generation completed
     * @param array|null  $data            Additional request data
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportMakeResponse
     */
    public function userReportMake(string $report_type_uid,
                                   string $type,
                                   string $value,
                                   ?array $options = [],
                                   ?bool $is_force = false,
                                   ?string $on_update = null,
                                   ?string $on_complete = null,
                                   array $data = []): UserReportMakeResponse;

    /**
     * Refresh existing report.
     *
     * @param string     $report_uid Report unique ID (e.g.: `some_report_uid_YV1KS9614S107357Y@domain`)
     * @param array|null $options    Additional request options
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportRefreshResponse
     */
    public function userReportRefresh(string $report_uid, ?array $options = []): UserReportRefreshResponse;
}

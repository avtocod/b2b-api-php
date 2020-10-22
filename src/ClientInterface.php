<?php

namespace Avtocod\B2BApi;

use Avtocod\B2BApi\Params\UserParams;
use Avtocod\B2BApi\Params\DevPingParams;
use Avtocod\B2BApi\Params\DevTokenParams;
use Avtocod\B2BApi\Responses\UserResponse;
use Avtocod\B2BApi\Params\UserReportParams;
use Avtocod\B2BApi\Params\UserBalanceParams;
use Avtocod\B2BApi\Params\UserReportsParams;
use Avtocod\B2BApi\Responses\DevPingResponse;
use Avtocod\B2BApi\Responses\DevTokenResponse;
use Avtocod\B2BApi\Params\UserReportMakeParams;
use Avtocod\B2BApi\Params\UserReportTypesParams;
use Avtocod\B2BApi\Responses\UserReportResponse;
use Avtocod\B2BApi\Responses\UserBalanceResponse;
use Avtocod\B2BApi\Responses\UserReportsResponse;
use Avtocod\B2BApi\Exceptions\BadRequestException;
use Avtocod\B2BApi\Params\UserReportRefreshParams;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Avtocod\B2BApi\Responses\UserReportMakeResponse;
use Avtocod\B2BApi\Responses\UserReportTypesResponse;
use Avtocod\B2BApi\Responses\UserReportRefreshResponse;

interface ClientInterface
{
    /**
     * Test connection.
     *
     * @param DevPingParams|null $params
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return DevPingResponse
     */
    public function devPing(?DevPingParams $params = null): DevPingResponse;

    /**
     * Debug token generation.
     *
     * @param DevTokenParams $params
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return DevTokenResponse
     */
    public function devToken(DevTokenParams $params): DevTokenResponse;

    /**
     * Retrieve information about current user.
     *
     * @param UserParams|null $params
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserResponse
     */
    public function user(?UserParams $params = null): UserResponse;

    /**
     * Retrieve balance information for report type.
     *
     * @param UserBalanceParams $params
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserBalanceResponse
     */
    public function userBalance(UserBalanceParams $params): UserBalanceResponse;

    /**
     * Retrieve report types data.
     *
     * @param UserReportTypesParams|null $params
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportTypesResponse
     */
    public function userReportTypes(?UserReportTypesParams $params = null): UserReportTypesResponse;

    /**
     * Get reports list.
     *
     * @param UserReportsParams|null $params
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportsResponse
     */
    public function userReports(?UserReportsParams $params = null): UserReportsResponse;

    /**
     * Get report by unique report ID.
     *
     * @param UserReportParams $params
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportResponse
     */
    public function userReport(UserReportParams $params): UserReportResponse;

    /**
     * Make report.
     *
     * @param UserReportMakeParams $params Object with data to make report
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportMakeResponse
     */
    public function userReportMake(UserReportMakeParams $params): UserReportMakeResponse;

    /**
     * Refresh existing report.
     *
     * @param UserReportRefreshParams $params
     *
     * @throws BadRequestException
     * @throws BadResponseException
     *
     * @return UserReportRefreshResponse
     */
    public function userReportRefresh(UserReportRefreshParams $params): UserReportRefreshResponse;
}

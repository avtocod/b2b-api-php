<?php

namespace Avtocod\B2BApi;

use Avtocod\B2BApi\Exceptions\BadRequestException;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Avtocod\B2BApi\Responses\DevPingResponse;

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
}

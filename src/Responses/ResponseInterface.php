<?php

namespace Avtocod\B2BApi\Responses;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

interface ResponseInterface
{
    /**
     * Create self from HTTP response.
     *
     * @param HttpResponseInterface $response
     *
     * @return self
     */
    public static function fromHttpResponse(HttpResponseInterface $response);
}

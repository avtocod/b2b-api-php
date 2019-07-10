<?php

namespace Avtocod\B2BApi\Responses;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

interface ResponseInterface
{
    /**
     * Response status - all is ok.
     */
    public const STATE_SUCCESS = 'ok';

    /**
     * Response status - something goes wrong.
     */
    public const STATE_FAILED = 'fail';

    /**
     * Create self from HTTP response.
     *
     * @param HttpResponseInterface $response
     *
     * @return self
     */
    public static function fromHttpResponse(HttpResponseInterface $response);
}

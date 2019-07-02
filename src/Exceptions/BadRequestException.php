<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Exceptions;

use Throwable;
use RuntimeException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BadRequestException extends RuntimeException
{
    /**
     * @var RequestInterface
     */
    protected $http_request;

    /**
     * @var ResponseInterface|null
     */
    protected $http_response;

    /**
     * Create a new exception instance.
     *
     * @param RequestInterface       $http_request
     * @param ResponseInterface|null $http_response
     * @param string                 $message
     * @param int                    $code
     * @param Throwable|null         $previous
     */
    public function __construct(RequestInterface $http_request,
                                ?ResponseInterface $http_response = null,
                                string $message = 'Unsuccessful request',
                                int $code = 0,
                                ?Throwable $previous = null)
    {
        $this->http_request  = $http_request;
        $this->http_response = $http_response;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return RequestInterface
     */
    public function getHttpRequest(): RequestInterface
    {
        return $this->http_request;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getHttpResponse(): ?ResponseInterface
    {
        return $this->http_response;
    }
}

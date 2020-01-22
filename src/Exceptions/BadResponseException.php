<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Exceptions;

use Throwable;
use RuntimeException;
use Psr\Http\Message\ResponseInterface;

class BadResponseException extends RuntimeException implements B2BApiExceptionInterface
{
    /**
     * @var ResponseInterface
     */
    protected $http_response;

    /**
     * Create a new exception instance.
     *
     * @param ResponseInterface $http_response
     * @param string            $message
     * @param int               $code
     * @param Throwable|null    $previous
     */
    public function __construct(ResponseInterface $http_response,
                                string $message,
                                int $code = 0,
                                ?Throwable $previous = null)
    {
        $this->http_response = $http_response;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param ResponseInterface $http_response
     * @param string|null       $message
     * @param Throwable|null    $prev
     *
     * @return self
     */
    public static function wrongJson(ResponseInterface $http_response,
                                     ?string $message = null,
                                     ?Throwable $prev = null): self
    {
        return new static($http_response, $message ?? 'Server sent wrong json', 0, $prev);
    }

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->http_response;
    }
}

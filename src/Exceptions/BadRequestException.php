<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Exceptions;

use Throwable;
use RuntimeException;
use Tarampampam\Wrappers\Json;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;

class BadRequestException extends RuntimeException implements B2BApiExceptionInterface
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
     * @param string|null            $message
     * @param int|null               $code
     * @param Throwable|null         $previous
     */
    public function __construct(RequestInterface $http_request,
                                ?ResponseInterface $http_response = null,
                                ?string $message = null,
                                ?int $code = null,
                                ?Throwable $previous = null)
    {
        $this->http_request    = $http_request;
        $this->http_response   = $http_response;
        $service_error_message = null;
        $http_code             = null;

        if ($http_response instanceof ResponseInterface) {
            $service_error_message = $this->extractErrorMessageFromResponse($http_response);
            $http_code             = $http_response->getStatusCode();
        }

        $previous_exception_message = $previous instanceof Throwable && $previous->getMessage() !== ''
            ? $previous->getMessage()
            : null;

        parent::__construct(
            $message ?? $service_error_message ?? $previous_exception_message ?? 'Unsuccessful request',
            $code ?? $http_code ?? 0,
            $previous
        );
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

    /**
     * Extract service error information from response.
     *
     * @param ResponseInterface $response
     *
     * @return string|null
     */
    protected function extractErrorMessageFromResponse(ResponseInterface $response): ?string
    {
        try {
            $as_array = (array) Json::decode((string) $response->getBody());

            if (isset($as_array['type'], $as_array['name'], $as_array['message'])) {
                return "{$as_array['type']}: {$as_array['name']} ({$as_array['message']})";
            }

            if (isset($as_array['error'], $as_array['exception'], $as_array['message'])) {
                return "{$as_array['error']}: {$as_array['exception']} ({$as_array['message']})";
            }

            if (isset($as_array['event']) && \is_array($event = $as_array['event'])) {
                $type    = $event['type'] ?? null;
                $name    = $event['name'] ?? null;
                $message = $event['message'] ?? null;

                return "{$type}: {$name} ({$message})";
            }
        } catch (JsonEncodeDecodeException $e) {
            //
        }

        return null;
    }
}

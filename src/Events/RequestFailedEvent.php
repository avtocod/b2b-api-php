<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Events;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class RequestFailedEvent
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface|null
     */
    private $response;

    /**
     * Create a new event instance.
     *
     * @param RequestInterface       $request
     * @param ResponseInterface|null $response
     */
    public function __construct(RequestInterface $request, ?ResponseInterface $response = null)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}

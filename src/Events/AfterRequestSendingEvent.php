<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Events;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class AfterRequestSendingEvent
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var int
     */
    private $duration;

    /**
     * Create a new event instance.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param int               $duration Request duration time (in microseconds)
     */
    public function __construct(RequestInterface $request, ResponseInterface $response, int $duration)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->duration = $duration;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }
}

<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Events;

use Psr\Http\Message\RequestInterface;

final class BeforeRequestSendingEvent
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $options;

    /**
     * Create a new event instance.
     *
     * @param RequestInterface $request
     * @param array            $options
     */
    public function __construct(RequestInterface $request, array $options)
    {
        $this->request = $request;
        $this->options = $options;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}

<?php

namespace Avtocod\B2BApi;

use Closure;

interface WithEventsHandlerSetterInterface
{
    /**
     * Set events handler.
     *
     * @param Closure $events_handler
     */
    public function setEventsHandler(Closure $events_handler);
}

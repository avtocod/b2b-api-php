<?php

declare(strict_types = 1);

namespace GuzzleHttp\Promise;

/**
 * guzzlehttp/promises 2.x removed namespaced helper functions.
 * avto-dev/guzzle-url-mock 1.5.x (PHP 7.2) still calls them.
 *
 * @param mixed $value
 *
 * @return PromiseInterface
 */
function promise_for($value): PromiseInterface
{
    return Create::promiseFor($value);
}

/**
 * @param mixed $reason
 *
 * @return PromiseInterface
 */
function rejection_for($reason): PromiseInterface
{
    return Create::rejectionFor($reason);
}

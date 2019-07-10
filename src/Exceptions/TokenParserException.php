<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Exceptions;

use Throwable;
use RuntimeException;

class TokenParserException extends RuntimeException implements B2BApiExceptionInterface
{
    /**
     * @param string|null    $message
     * @param int            $code
     * @param Throwable|null $prev
     *
     * @return self
     */
    public static function cannotParseToken(?string $message = null, int $code = 0, ?Throwable $prev = null): self
    {
        return new static($message ?? 'Cannot parse token', $code, $prev);
    }
}

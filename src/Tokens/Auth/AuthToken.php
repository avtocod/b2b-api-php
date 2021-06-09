<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tokens\Auth;

use Avtocod\B2BApi\Exceptions\TokenParserException;

final class AuthToken
{
    /**
     * Constant for modify current time.
     */
    public const MODIFY_PERIOD = 60;

    /**
     * Parse authorization token string.
     *
     * @param string $auth_token
     *
     * @throws TokenParserException
     *
     * @return TokenInfo
     */
    public static function parse(string $auth_token): TokenInfo
    {
        $parts = \explode(':', (string) \base64_decode($auth_token, true));

        $username    = $parts[0] ?? null;
        $timestamp   = $parts[1] ?? null;
        $age         = $parts[2] ?? null;
        $salted_hash = $parts[3] ?? null;

        if (\is_string($username) && \is_numeric($timestamp) && \is_numeric($age) && \is_string($salted_hash)) {
            return new TokenInfo($username, (int) $timestamp, (int) $age, $salted_hash);
        }

        throw TokenParserException::cannotParseToken();
    }

    /**
     * Generate authorization token.
     *
     * @param string      $username  Username (e.g. `username` or `username@domain`; in second case you must NOT pass
     *                               domain in `$domain` variable)
     * @param string      $password  User password
     * @param string|null $domain    User domain name
     * @param int         $age       In seconds
     * @param int|null    $timestamp Token creation unix timestamp
     *
     * @return string
     */
    public static function generate(string $username,
                                    string $password,
                                    ?string $domain = null,
                                    int $age = 172800,
                                    ?int $timestamp = null): string
    {
        if ($timestamp === null) {
            $timestamp = (new \DateTime)->modify(\sprintf('-%d sec', self::MODIFY_PERIOD))->getTimestamp();
            $age       += self::MODIFY_PERIOD;
        }

        $username = $domain === null
            ? $username
            : "{$username}@{$domain}";

        $pass_hash   = \base64_encode(\md5($password, true));
        $salted_hash = \base64_encode(\md5(\implode(':', [$timestamp, $age, $pass_hash]), true));

        return \base64_encode(\implode(':', [$username, $timestamp, $age, $salted_hash]));
    }
}

<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi;

use DateTime;
use DateTimeImmutable;
use InvalidArgumentException;

/**
 * @see <https://www.php.net/manual/ru/datetime.createfromformat.php>
 */
class DateTimeFactory extends DateTimeImmutable
{
    /**
     * Create DateTime object from passed time string.
     *
     * @param string $time E.g.: '2017-01-05T16:45:23.000Z', '2017-01-05T16:45:23.000000Z',
     *
     * @throws InvalidArgumentException
     *
     * @return DateTimeImmutable
     */
    public static function createFromIso8601Zulu(string $time): DateTimeImmutable
    {
        $result = DateTimeImmutable::createFromFormat('Y-m-d\\TH:i:s.u\\Z', $time);

        if (! $result instanceof DateTimeImmutable) {
            throw new InvalidArgumentException(
                "Wrong time [$time] passed (" . \implode(',', DateTimeImmutable::getLastErrors()['errors'] ?? []) . ')'
            );
        }

        return $result;
    }

    /**
     * Convert DateTimeImmutable object into string, using ISO8601 (zulu) format.
     *
     * @param DateTimeImmutable $date_time
     *
     * @return string E.g.: '2017-01-05T16:45:23.000Z'
     */
    public static function toIso8601Zulu(DateTimeImmutable $date_time): string
    {
        return $date_time->format('Y-m-d\\TH:i:s.v\\Z');
    }

    /**
     * Convert DateTimeImmutable object into string, using ISO8601 (zulu) format without microseconds.
     *
     * @param DateTimeImmutable $date_time
     *
     * @return string E.g.: '2017-01-05T16:45:23Z'
     */
    public static function toIso8601ZuluWithoutMs(DateTimeImmutable $date_time): string
    {
        return $date_time->format('Y-m-d\\TH:i:s\\Z');
    }
}

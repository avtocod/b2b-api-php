<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi;

use DateTime;
use InvalidArgumentException;

/**
 * @see <https://www.php.net/manual/ru/datetime.createfromformat.php>
 */
class DateTimeFactory extends DateTime
{
    /**
     * Create DateTime object from passed time string.
     *
     * @param string $time E.g.: '2017-01-05T16:45:23.000Z', '2017-01-05T16:45:23.000000Z',
     *
     * @throws InvalidArgumentException
     *
     * @return DateTime
     */
    public static function createFromIso8601Zulu(string $time): DateTime
    {
        $result = DateTime::createFromFormat('Y-m-d\\TH:i:s.u\\Z', $time);

        if (! $result instanceof DateTime) {
            throw new InvalidArgumentException(
                "Wrong time [$time] passed (" . \implode(',', DateTime::getLastErrors()['errors'] ?? []) . ')'
            );
        }

        return $result;
    }

    /**
     * Convert DateTime object into string, using ISO8601 (zulu) format.
     *
     * @param DateTime $date_time
     *
     * @return string E.g.: '2017-01-05T16:45:23.000Z'
     */
    public static function toIso8601Zulu(DateTime $date_time): string
    {
        return $date_time->format('Y-m-d\\TH:i:s.v\\Z');
    }

    /**
     * Convert DateTime object into string, using ISO8601 (zulu) format without microseconds.
     *
     * @param DateTime $date_time
     *
     * @return string E.g.: '2017-01-05T16:45:23Z'
     */
    public static function toIso8601ZuluWithoutMs(DateTime $date_time): string
    {
        return $date_time->format('Y-m-d\\TH:i:s\\Z');
    }
}

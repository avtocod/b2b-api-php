<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses;

use Countable;
use ArrayIterator;
use DateTimeImmutable;
use IteratorAggregate;
use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Responses\Entities\Balance;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

/**
 * @implements IteratorAggregate<int, Balance>
 */
class UserBalanceResponse implements ResponseInterface, Countable, IteratorAggregate
{
    /**
     * @var string
     */
    protected $raw_response_content;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var DateTimeImmutable
     */
    protected $stamp;

    /**
     * @var array<int, Balance>
     */
    protected $data;

    /**
     * Create a new response instance.
     *
     * @param string              $raw_response
     * @param string              $state
     * @param int                 $size
     * @param DateTimeImmutable   $stamp
     * @param array<int, Balance> $data
     */
    private function __construct(string $raw_response, string $state, int $size, DateTimeImmutable $stamp, array $data)
    {
        $this->raw_response_content = $raw_response;
        $this->state                = $state;
        $this->size                 = $size;
        $this->stamp                = $stamp;
        $this->data                 = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getRawResponseContent(): string
    {
        return $this->raw_response_content;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BadResponseException
     */
    public static function fromHttpResponse(HttpResponseInterface $response): self
    {
        $as_array = (array) \json_decode($raw_response = (string) $response->getBody(), true);

        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw BadResponseException::wrongJson($response, \json_last_error_msg());
        }

        $as_array['data'] = \array_map(static function (array $balance_data): Balance {
            return Balance::fromArray($balance_data);
        }, $as_array['data']);

        return new self(
            $raw_response,
            $as_array['state'],
            $as_array['size'],
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($as_array['stamp'])),
            $as_array['data']
        );
    }

    /**
     * Get response state.
     *
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Get response size.
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Get response date/time.
     *
     * @return DateTimeImmutable
     */
    public function getStamp(): DateTimeImmutable
    {
        return $this->stamp;
    }

    /**
     * Get balance data.
     *
     * @return array<int, Balance>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get **first** balance entry by balance type (e.g.: `DAY`, `MONTH`, `TOTAL`).
     *
     * @param string $balance_type
     *
     * @return Balance|null
     */
    public function getByType(string $balance_type): ?Balance
    {
        $result = \array_values(\array_filter($this->data, static function (Balance $balance) use (&$balance_type): bool {
            return $balance->getBalanceType() === $balance_type;
        }));

        return \count($result) >= 1
            ? $result[0]
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->size;
    }

    /**
     * @return ArrayIterator<int, Balance>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}

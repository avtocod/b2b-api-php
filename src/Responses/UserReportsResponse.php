<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses;

use DateTime;
use Countable;
use ArrayIterator;
use IteratorAggregate;
use Tarampampam\Wrappers\Json;
use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Responses\Entities\Report;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class UserReportsResponse implements ResponseInterface, Countable, IteratorAggregate
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
     * @var DateTime
     */
    protected $stamp;

    /**
     * @var Report[]
     */
    protected $data;

    /**
     * @var int|null
     */
    protected $total;

    /**
     * Create a new response instance.
     *
     * @param string   $raw_response
     * @param string   $state
     * @param int      $size
     * @param DateTime $stamp
     * @param Report[] $data
     * @param int      $total
     */
    private function __construct(string $raw_response,
                                 string $state,
                                 int $size,
                                 DateTime $stamp,
                                 array $data,
                                 ?int $total)
    {
        $this->raw_response_content = $raw_response;
        $this->state                = $state;
        $this->size                 = $size;
        $this->stamp                = $stamp;
        $this->data                 = $data;
        $this->total                = $total;
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
        try {
            $as_array = (array) Json::decode($raw_response = (string) $response->getBody());
        } catch (JsonEncodeDecodeException $e) {
            throw BadResponseException::wrongJson($response, $e->getMessage(), $e);
        }

        $as_array['data'] = \array_map(static function (array $report_data): Report {
            return Report::fromArray($report_data);
        }, $as_array['data']);

        return new static(
            $raw_response,
            $as_array['state'],
            $as_array['size'],
            DateTimeFactory::createFromIso8601Zulu($as_array['stamp']),
            $as_array['data'],
            $as_array['total'] ?? null
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
     * @return DateTime
     */
    public function getStamp(): DateTime
    {
        return $this->stamp;
    }

    /**
     * Get reports data.
     *
     * @return Report[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get total entries count.
     *
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * Get first report object.
     *
     * @return Report|null
     */
    public function first(): ?Report
    {
        return $this->data[0] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}

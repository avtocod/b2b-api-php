<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses;

use DateTime;
use Countable;
use ArrayIterator;
use IteratorAggregate;
use Tarampampam\Wrappers\Json;
use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Responses\Entities\User;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class UserResponse implements ResponseInterface, Countable, IteratorAggregate
{
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
     * @var User[]
     */
    protected $data;

    /**
     * Create a new response instance.
     *
     * @param string   $state
     * @param int      $size
     * @param DateTime $stamp
     * @param User[]   $data
     */
    private function __construct(string $state, int $size, DateTime $stamp, array $data)
    {
        $this->state = $state;
        $this->size  = $size;
        $this->stamp = $stamp;
        $this->data  = $data;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BadResponseException
     */
    public static function fromHttpResponse(HttpResponseInterface $response): self
    {
        try {
            $as_array = (array) Json::decode((string) $response->getBody());
        } catch (JsonEncodeDecodeException $e) {
            throw BadResponseException::wrongJson($response, $e->getMessage(), $e);
        }

        $as_array['data'] = \array_map(function (array $user_data): User {
            return User::fromArray($user_data);
        }, $as_array['data']);

        return new static(
            $as_array['state'],
            $as_array['size'],
            DateTimeFactory::createFromIso8601Zulu($as_array['stamp']),
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
     * @return DateTime
     */
    public function getStamp(): DateTime
    {
        return $this->stamp;
    }

    /**
     * Get users data.
     *
     * @return User[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get **first** user entry by UID.
     *
     * @param string $uid
     *
     * @return User|null
     */
    public function getByUid(string $uid): ?User
    {
        $result = \array_values(\array_filter($this->data, function (User $user) use (&$uid): bool {
            return $user->getUid() === $uid;
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
     * {@inheritdoc}
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}

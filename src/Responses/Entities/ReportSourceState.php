<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

class ReportSourceState implements CanCreateSelfFromArrayInterface
{
    /**
     * Source status - errored.
     */
    public const ERROR = 'ERROR';

    /**
     * Source status - success.
     */
    public const SUCCESS = 'OK';

    /**
     * Source status - is in progress.
     */
    public const PROGRESS = 'PROGRESS';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * Create a new report source state instance.
     *
     * @param string     $name  Source name
     * @param string     $state Source state
     * @param array|null $data
     */
    public function __construct(string $name, string $state, ?array $data)
    {
        $this->name  = $name;
        $this->state = $state;
        $this->data  = $data;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['_id'] ?? $data['id'] ?? $data['name'],
            $data['state'],
            $data['data'] ?? null
        );
    }

    /**
     * Source is in progress?
     *
     * @return bool
     */
    public function isInProgress(): bool
    {
        return $this->state === static::PROGRESS;
    }

    /**
     * Source work is completed?
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->isErrored() || $this->isSuccess();
    }

    /**
     * Source is errored?
     *
     * @return bool
     */
    public function isErrored(): bool
    {
        return $this->state === static::ERROR;
    }

    /**
     * Source is successes?
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->state === self::SUCCESS;
    }

    /**
     * Get source name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get source state.
     *
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Get additional data.
     *
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}

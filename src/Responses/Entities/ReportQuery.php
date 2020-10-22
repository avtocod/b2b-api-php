<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

class ReportQuery implements CanCreateSelfFromArrayInterface
{
    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $body;

    /**
     * @var array<mixed, mixed>|null
     */
    protected $data;

    /**
     * Create a new report query instance.
     *
     * @param string|null              $type
     * @param string|null              $body
     * @param array<mixed, mixed>|null $data
     */
    public function __construct(?string $type, ?string $body, ?array $data)
    {
        $this->type = $type;
        $this->body = $body;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['type'] ?? null,
            $data['body'] ?? null,
            $data['data'] ?? null
        );
    }

    /**
     * Get query type.
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Get query body.
     *
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Get query data.
     *
     * @return array<mixed, mixed>|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}

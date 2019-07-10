<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

class ReportTypeContent implements CanCreateSelfFromArrayInterface
{
    /**
     * @var array|string[]
     */
    protected $sources;

    /**
     * @var array|string[]
     */
    protected $fields;

    /**
     * Create a new report type content instance.
     *
     * @param string[] $sources Sources list
     * @param string[] $fields  Fields list
     */
    public function __construct(array $sources, array $fields)
    {
        $this->sources = $sources;
        $this->fields  = $fields;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['sources'],
            $data['fields']
        );
    }

    /**
     * Get sources list.
     *
     * @return array|string[]
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    /**
     * Get fields list.
     *
     * @return array|string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}

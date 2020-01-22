<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

class ReportState implements CanCreateSelfFromArrayInterface
{
    /**
     * @var array|ReportSourceState[]
     */
    protected $source_states;

    /**
     * Create a new report state instance.
     *
     * @param ReportSourceState[] $source_states
     */
    public function __construct(array $source_states)
    {
        $this->source_states = $source_states;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data): self
    {
        return new static(
            \array_map(static function (array $report_data): ReportSourceState {
                return ReportSourceState::fromArray($report_data);
            }, $data['sources'])
        );
    }

    /**
     * Get report sources stated.
     *
     * @return array|ReportSourceState[]
     */
    public function getSourceStates(): array
    {
        return $this->source_states;
    }

    /**
     * Get source state by name.
     *
     * @param string $source_name
     *
     * @return ReportSourceState|null
     */
    public function getSourceStateByName(string $source_name): ?ReportSourceState
    {
        foreach ($this->source_states as $source_state) {
            if ($source_state->getName() === $source_name) {
                return $source_state;
            }
        }

        return null;
    }
}

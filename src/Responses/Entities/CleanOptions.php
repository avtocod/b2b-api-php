<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

class CleanOptions implements CanCreateSelfFromArrayInterface
{
    /**
     * @var int|null
     */
    protected $process_response;

    /**
     * @var int|null
     */
    protected $process_request;

    /**
     * @var int|null
     */
    protected $report_log;

    /**
     * Create a new clean options instance.
     *
     * @param int|null $process_response
     * @param int|null $process_request
     * @param int|null $report_log
     */
    public function __construct(?int $process_response, ?int $process_request, ?int $report_log)
    {
        $this->process_response = $process_response;
        $this->process_request  = $process_request;
        $this->report_log       = $report_log;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['Process_Response'] ?? null,
            $data['Process_Request'] ?? null,
            $data['ReportLog'] ?? null
        );
    }

    /**
     * @return int|null
     */
    public function getProcessResponse(): ?int
    {
        return $this->process_response;
    }

    /**
     * @return int|null
     */
    public function getProcessRequest(): ?int
    {
        return $this->process_request;
    }

    /**
     * @return int|null
     */
    public function getReportLog(): ?int
    {
        return $this->report_log;
    }
}

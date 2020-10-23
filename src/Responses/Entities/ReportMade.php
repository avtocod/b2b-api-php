<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

use DateTimeImmutable;
use Avtocod\B2BApi\DateTimeFactory;

class ReportMade implements CanCreateSelfFromArrayInterface
{
    /**
     * @var string
     */
    protected $report_uid;

    /**
     * @var bool
     */
    protected $is_new;

    /**
     * @var string|null
     */
    protected $process_request_uid;

    /**
     * @var DateTimeImmutable
     */
    protected $suggest_get;

    /**
     * Create a new report made instance.
     *
     * @param string            $report_uid          Report unique ID
     * @param bool              $is_new              Report is new?
     * @param string|null       $process_request_uid Unique report request ID
     * @param DateTimeImmutable $suggest_get         Suggested date/time for report getting
     */
    public function __construct(string $report_uid, bool $is_new, ?string $process_request_uid, DateTimeImmutable $suggest_get)
    {
        $this->report_uid          = $report_uid;
        $this->is_new              = $is_new;
        $this->process_request_uid = $process_request_uid;
        $this->suggest_get         = $suggest_get;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['uid'],
            $data['isnew'],
            $data['process_request_uid'] ?? null,
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu((string) $data['suggest_get']))
        );
    }

    /**
     * Get report unique ID.
     *
     * @return string
     */
    public function getReportUid(): string
    {
        return $this->report_uid;
    }

    /**
     * Report is new?
     *
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->is_new;
    }

    /**
     * Get unique report request ID.
     *
     * @return string|null
     */
    public function getProcessRequestUid(): ?string
    {
        return $this->process_request_uid;
    }

    /**
     * Get suggested date/time for report getting.
     *
     * @return DateTimeImmutable
     */
    public function getSuggestGet(): DateTimeImmutable
    {
        return $this->suggest_get;
    }
}

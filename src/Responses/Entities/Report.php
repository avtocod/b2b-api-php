<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

use DateTime;
use Avtocod\B2BApi\DateTimeFactory;

class Report implements CanCreateSelfFromArrayInterface
{
    /**
     * @var string
     */
    protected $uid;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ReportContent|null
     */
    protected $content;

    /**
     * @var ReportQuery
     */
    protected $query;

    /**
     * @var string|null
     */
    protected $vehicle_id;

    /**
     * @var string
     */
    protected $report_type_uid;

    /**
     * @var string
     */
    protected $domain_uid;

    /**
     * @var array|string[]
     */
    protected $tags;

    /**
     * @var DateTime
     */
    protected $created_at;

    /**
     * @var string
     */
    protected $created_by;

    /**
     * @var DateTime
     */
    protected $updated_at;

    /**
     * @var string
     */
    protected $updated_by;

    /**
     * @var DateTime
     */
    protected $active_from;

    /**
     * @var DateTime
     */
    protected $active_to;

    /**
     * @var int
     */
    protected $progress_ok;

    /**
     * @var int
     */
    protected $progress_wait;

    /**
     * @var int
     */
    protected $progress_error;

    /**
     * @var ReportState
     */
    protected $state;

    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var bool|null
     */
    protected $deleted;

    /**
     * Create a new report instance.
     *
     * @param string             $uid             Unique report ID (e.g.: `report_uid@domain`)
     * @param string             $comment         Report comment
     * @param string             $name            Human-readable name
     * @param ReportContent|null $content         Report content
     * @param ReportQuery        $query           Report query
     * @param string|null        $vehicle_id      Vehicle identifier
     * @param string             $report_type_uid Report type unique ID
     * @param string             $domain_uid      Domain unique ID
     * @param string[]           $tags            Tags list
     * @param DateTime           $created_at      Created at
     * @param string             $created_by      Creator name
     * @param DateTime           $updated_at      Last changes was made at
     * @param string             $updated_by      Last changes was made by
     * @param DateTime           $active_from     Active from
     * @param DateTime           $active_to       Active to
     * @param int                $progress_ok     Successfully completed sources count
     * @param int                $progress_wait   Sources in a progress count
     * @param int                $progress_error  Errored sources count
     * @param ReportState        $state           Detailed report generation information
     * @param int|null           $id              Internal database identifier (optional, only for administrators)
     * @param bool|null          $deleted         Is deleted flag (optional, only for administrators)
     */
    public function __construct(string $uid,
                                string $comment,
                                string $name,
                                ?ReportContent $content,
                                ReportQuery $query,
                                ?string $vehicle_id,
                                string $report_type_uid,
                                string $domain_uid,
                                array $tags,
                                DateTime $created_at,
                                string $created_by,
                                DateTime $updated_at,
                                string $updated_by,
                                DateTime $active_from,
                                DateTime $active_to,
                                int $progress_ok,
                                int $progress_wait,
                                int $progress_error,
                                ReportState $state,
                                ?int $id,
                                ?bool $deleted)
    {
        $this->uid             = $uid;
        $this->comment         = $comment;
        $this->name            = $name;
        $this->content         = $content;
        $this->query           = $query;
        $this->vehicle_id      = $vehicle_id;
        $this->report_type_uid = $report_type_uid;
        $this->domain_uid      = $domain_uid;
        $this->tags            = $tags;
        $this->created_at      = $created_at;
        $this->created_by      = $created_by;
        $this->updated_at      = $updated_at;
        $this->updated_by      = $updated_by;
        $this->active_from     = $active_from;
        $this->active_to       = $active_to;
        $this->progress_ok     = $progress_ok;
        $this->progress_wait   = $progress_wait;
        $this->progress_error  = $progress_error;
        $this->state           = $state;
        $this->id              = $id;
        $this->deleted         = $deleted;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['uid'],
            $data['comment'],
            $data['name'],
            isset($data['content'])
                ? new ReportContent($data['content'])
                : null,
            ReportQuery::fromArray($data['query']),
            $data['vehicle_id'] ?? null,
            $data['report_type_uid'],
            $data['domain_uid'],
            \array_filter(\explode(',', $data['tags'])),
            DateTimeFactory::createFromIso8601Zulu($data['created_at']),
            $data['created_by'],
            DateTimeFactory::createFromIso8601Zulu($data['updated_at']),
            $data['updated_by'],
            DateTimeFactory::createFromIso8601Zulu($data['active_from']),
            DateTimeFactory::createFromIso8601Zulu($data['active_to']),
            $data['progress_ok'],
            $data['progress_wait'],
            $data['progress_error'],
            ReportState::fromArray($data['state']),
            $data['id'] ?? null,
            $data['deleted'] ?? null
        );
    }

    /**
     * Get unique report ID.
     *
     * @return string E.g.: `report_uid@domain`
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * Get report comment.
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Get human-readable name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get report content.
     *
     * @return ReportContent|null
     */
    public function getContent(): ?ReportContent
    {
        return $this->content;
    }

    /**
     * Get report query.
     *
     * @return ReportQuery
     */
    public function getQuery(): ReportQuery
    {
        return $this->query;
    }

    /**
     * Get vehicle identifier.
     *
     * @return string|null
     */
    public function getVehicleId(): ?string
    {
        return $this->vehicle_id;
    }

    /**
     * Get report type unique ID.
     *
     * @return string
     */
    public function getReportTypeUid(): string
    {
        return $this->report_type_uid;
    }

    /**
     * Get domain unique ID.
     *
     * @return string
     */
    public function getDomainUid(): string
    {
        return $this->domain_uid;
    }

    /**
     * Get tags list.
     *
     * @return array|string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get created at date/time.
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * Get group creator.
     *
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->created_by;
    }

    /**
     * Get last changes date/time.
     *
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updated_at;
    }

    /**
     * Get last changes author.
     *
     * @return string
     */
    public function getUpdatedBy(): string
    {
        return $this->updated_by;
    }

    /**
     * Get active from date/time.
     *
     * @return DateTime
     */
    public function getActiveFrom(): DateTime
    {
        return $this->active_from;
    }

    /**
     * Get active to date/time.
     *
     * @return DateTime
     */
    public function getActiveTo(): DateTime
    {
        return $this->active_to;
    }

    /**
     * Get successfully completed sources count.
     *
     * @return int
     */
    public function getProgressOk(): int
    {
        return $this->progress_ok;
    }

    /**
     * Get sources in a progress count.
     *
     * @return int
     */
    public function getProgressWait(): int
    {
        return $this->progress_wait;
    }

    /**
     * Get errored sources count.
     *
     * @return int
     */
    public function getProgressError(): int
    {
        return $this->progress_error;
    }

    /**
     * Get detailed report generation information.
     *
     * @return ReportState
     */
    public function getState(): ReportState
    {
        return $this->state;
    }

    /**
     * Report generation is completed?
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return ($this->progress_error + $this->progress_ok) >= \count($this->state->getSourceStates());
    }

    /**
     * Get internal database identifier (only for administrators).
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get deleted flag (only for administrators).
     *
     * @return bool|null
     */
    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }
}

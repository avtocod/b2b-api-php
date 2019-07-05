<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

use DateTime;

class ReportType
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
     * @var string
     */
    protected $state;

    /**
     * @var string[]
     */
    protected $tags;

    /**
     * @var int
     */
    protected $max_age;

    /**
     * @var string
     */
    protected $domain_uid;

    /**
     * @var ReportTypeContent
     */
    protected $content;

    /**
     * @var int
     */
    protected $day_quote;

    /**
     * @var int
     */
    protected $month_quote;

    /**
     * @var int
     */
    protected $total_quote;

    /**
     * @var int
     */
    protected $min_priority;

    /**
     * @var int
     */
    protected $max_priority;

    /**
     * @var int
     */
    protected $period_priority;

    /**
     * @var int
     */
    protected $max_request;

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
     * @var CleanOptions|null
     */
    protected $clean_options;

    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var bool|null
     */
    protected $deleted;

    /**
     * Create a new report type instance.
     *
     * @param string            $uid             Unique report type ID
     * @param string            $comment         Report type comment
     * @param string            $name            Human-readable report type name
     * @param string            $state           Report type state (e.g.: `DRAFT`, `PUBLISHED`, `OBSOLETE`)
     * @param string[]          $tags            Additional report type tags
     * @param int               $max_age         Period of relevance
     * @param string            $domain_uid      Domain unique ID
     * @param ReportTypeContent $content         Report type content
     * @param int               $day_quote       Daily quota
     * @param int               $month_quote     Monthly quota
     * @param int               $total_quote     Total quote
     * @param int               $min_priority    Lowest possible priority for this report type
     * @param int               $max_priority    Highest possible priority for this report type
     * @param int               $period_priority Time unit (in milliseconds) for priority calculation
     * @param int               $max_request     Number of requests in a given time unit, which will lower the
     *                                           priority to a minimum
     * @param DateTime          $created_at      Report type created at
     * @param string            $created_by      Report type creator
     * @param DateTime          $updated_at      Last changes was made at
     * @param string            $updated_by      Last changes was made by
     * @param DateTime          $active_from     Active from
     * @param DateTime          $active_to       Active to
     * @param CleanOptions|null $clean_options   Objects obsolescence
     * @param int|null          $id              Internal database identifier (optional, only for administrators)
     * @param bool|null         $deleted         Is deleted flag (optional, only for administrators)
     */
    public function __construct(string $uid,
                                string $comment,
                                string $name,
                                string $state,
                                array $tags,
                                int $max_age,
                                string $domain_uid,
                                ReportTypeContent $content,
                                int $day_quote,
                                int $month_quote,
                                int $total_quote,
                                int $min_priority,
                                int $max_priority,
                                int $period_priority,
                                int $max_request,
                                DateTime $created_at,
                                string $created_by,
                                DateTime $updated_at,
                                string $updated_by,
                                DateTime $active_from,
                                DateTime $active_to,
                                ?CleanOptions $clean_options,
                                ?int $id,
                                ?bool $deleted)
    {
        $this->uid             = $uid;
        $this->comment         = $comment;
        $this->name            = $name;
        $this->state           = $state;
        $this->tags            = $tags;
        $this->max_age         = $max_age;
        $this->domain_uid      = $domain_uid;
        $this->content         = $content;
        $this->day_quote       = $day_quote;
        $this->month_quote     = $month_quote;
        $this->total_quote     = $total_quote;
        $this->min_priority    = $min_priority;
        $this->max_priority    = $max_priority;
        $this->period_priority = $period_priority;
        $this->max_request     = $max_request;
        $this->created_at      = $created_at;
        $this->created_by      = $created_by;
        $this->updated_at      = $updated_at;
        $this->updated_by      = $updated_by;
        $this->active_from     = $active_from;
        $this->active_to       = $active_to;
        $this->clean_options   = $clean_options;
        $this->id              = $id;
        $this->deleted         = $deleted;
    }

    /**
     * Get unique report type ID.
     *
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * Get report type comment.
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Get human-readable report type name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get report type state.
     *
     * E.g.: `DRAFT`, `PUBLISHED`, `OBSOLETE`.
     *
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Get additional report type tags.
     *
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get period of relevance.
     *
     * @return int
     */
    public function getMaxAge(): int
    {
        return $this->max_age;
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
     * Get report type content.
     *
     * @return ReportTypeContent
     */
    public function getContent(): ReportTypeContent
    {
        return $this->content;
    }

    /**
     * Get daily quota.
     *
     * @return int
     */
    public function getDayQuote(): int
    {
        return $this->day_quote;
    }

    /**
     * Get monthly quota.
     *
     * @return int
     */
    public function getMonthQuote(): int
    {
        return $this->month_quote;
    }

    /**
     * Get total quote.
     *
     * @return int
     */
    public function getTotalQuote(): int
    {
        return $this->total_quote;
    }

    /**
     * Get lowest possible priority for this report type.
     *
     * @return int
     */
    public function getMinPriority(): int
    {
        return $this->min_priority;
    }

    /**
     * Get highest possible priority for this report type.
     *
     * @return int
     */
    public function getMaxPriority(): int
    {
        return $this->max_priority;
    }

    /**
     * Get time unit (in milliseconds) for priority calculation.
     *
     * @return int
     */
    public function getPeriodPriority(): int
    {
        return $this->period_priority;
    }

    /**
     * Get number of requests in a given time unit, which will lower the priority to a minimum.
     *
     * @return int
     */
    public function getMaxRequest(): int
    {
        return $this->max_request;
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
     * Get report type creator.
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
     * Get objects obsolescence options.
     *
     * @return CleanOptions|null
     */
    public function getCleanOptions(): ?CleanOptions
    {
        return $this->clean_options;
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

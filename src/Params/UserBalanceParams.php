<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class UserBalanceParams
{
    /**
     * Unique report type ID (e.g.: `some_report_uid` or `some_report_uid@domain`).
     *
     * @var string
     */
    protected $report_type_uid;

    /**
     * True, if necessary detailed balance information for report type.
     *
     * @var bool|null
     */
    protected $detailed;

    /**
     * @param string $report_type_uid Unique report type ID (e.g.: `some_report_uid` or `some_report_uid@domain`)
     */
    public function __construct(string $report_type_uid)
    {
        $this->report_type_uid = $report_type_uid;
    }

    /**
     * Get unique report type ID.
     *
     * @return string
     */
    public function getReportTypeUid(): string
    {
        return $this->report_type_uid;
    }

    /**
     * @param bool $detailed
     *
     * @return $this
     */
    public function setDetailed(bool $detailed): self
    {
        $this->detailed = $detailed;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isDetailed(): ?bool
    {
        return $this->detailed;
    }
}

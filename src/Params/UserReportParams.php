<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class UserReportParams
{
    /**
     * Report unique ID (e.g.: `some_report_uid_YV1KS9614S107357Y@domain`).
     *
     * @var string
     */
    protected $report_uid;

    /**
     * True, if necessary include report content into response.
     *
     * @var bool|null
     */
    protected $include_content;

    /**
     * True, if necessary detailed information about report.
     *
     * @var bool|null
     */
    protected $detailed;

    /**
     * @param string $report_uid Report unique ID (e.g.: `some_report_uid_YV1KS9614S107357Y@domain`)
     */
    public function __construct(string $report_uid)
    {
        $this->report_uid = $report_uid;
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
     * @param bool $include_content
     *
     * @return $this
     */
    public function setIncludeContent(bool $include_content): self
    {
        $this->include_content = $include_content;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isIncludeContent(): ?bool
    {
        return $this->include_content;
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

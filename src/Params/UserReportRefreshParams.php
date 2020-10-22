<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class UserReportRefreshParams
{
    /**
     * Report unique ID (e.g.: `some_report_uid_YV1KS9614S107357Y@domain`).
     *
     * @var string
     */
    protected $report_uid;

    /**
     * Additional request options.
     *
     * @var array<string, string|int|float|bool|array<mixed>>|null
     */
    protected $options;

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
     * Set additional request options.
     *
     * @param array<string, string|int|float|bool|array<mixed>> $options
     *
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get additional request options.
     *
     * @return array<string, string|int|float|bool|array<mixed>>|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }
}

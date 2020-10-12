<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class ReportMakeParams implements ReportMakeParamsInterface
{
    /**
     * Unique report type ID (e.g.: `some_report_uid` or `some_report_uid@domain`).
     *
     * @var string
     */
    private $report_type_uid;

    /**
     * Request type (e.g.: `VIN`, `GRZ`, `STS`, `PTS`, `CHASSIS`, etc.).
     *
     * @var string
     */
    private $type;

    /**
     * Request body (e.g.: `Z94CB41AAGR323020` (VIN), `А111АА177` (GRZ)).
     *
     * @var string
     */
    private $value;

    /**
     * Additional request options.
     *
     * @var array<string, string|int|float|bool|array<mixed>>|null
     */
    private $options;

    /**
     * Force update report, if it already was generated previously.
     *
     * @var bool|null
     */
    private $is_force;

    /**
     * URL to call (using `post` method) when report content updated.
     *
     * @var string|null
     */
    private $on_update_url;

    /**
     * URL to call (using `post` method) when report generation completed.
     *
     * @var string|null
     */
    private $on_complete_url;

    /**
     * Additional request data.
     *
     * @var array<string, string|int|float|bool|null|array<mixed>>|null
     */
    private $data;

    /**
     * Idempotence key which the server uses to recognize subsequent retries of the same request.
     *
     * @var string|null
     */
    private $idempotence_key;

    /**
     * ReportMakeParameter constructor.
     *
     * @param string $report_type_uid Unique report type ID (e.g.: `some_report_uid` or `some_report_uid@domain`)
     * @param string $type            Request type (e.g.: `VIN`, `GRZ`, `STS`, `PTS`, `CHASSIS`, etc.)
     * @param string $value           Request body (e.g.: `Z94CB41AAGR323020` (VIN), `А111АА177` (GRZ))
     */
    public function __construct(string $report_type_uid, string $type, string $value)
    {
        $this->report_type_uid = $report_type_uid;
        $this->type            = $type;
        $this->value           = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getReportTypeUid(): string
    {
        return $this->report_type_uid;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options): ReportMakeParamsInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setForce(bool $is_force): ReportMakeParamsInterface
    {
        $this->is_force = $is_force;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isForce(): ?bool
    {
        return $this->is_force;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnUpdateUrl(string $on_update_url): ReportMakeParamsInterface
    {
        $this->on_update_url = $on_update_url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOnUpdateUrl(): ?string
    {
        return $this->on_update_url;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnCompleteUrl(string $on_complete_url): ReportMakeParamsInterface
    {
        $this->on_complete_url = $on_complete_url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOnCompleteUrl(): ?string
    {
        return $this->on_complete_url;
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): ReportMakeParamsInterface
    {
        $this->data = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdempotenceKey(string $idempotence_key): ReportMakeParamsInterface
    {
        $this->idempotence_key = $idempotence_key;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdempotenceKey(): ?string
    {
        return $this->idempotence_key;
    }
}

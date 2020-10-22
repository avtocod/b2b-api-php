<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class UserReportMakeParams
{
    /**
     * Unique report type ID (e.g.: `some_report_uid` or `some_report_uid@domain`).
     *
     * @var string
     */
    protected $report_type_uid;

    /**
     * Request type (e.g.: `VIN`, `GRZ`, `STS`, `PTS`, `CHASSIS`, etc.).
     *
     * @var string
     */
    protected $type;

    /**
     * Request body (e.g.: `Z94CB41AAGR323020` (VIN), `А111АА177` (GRZ)).
     *
     * @var string
     */
    protected $value;

    /**
     * Additional request options.
     *
     * @var array<string, string|int|float|bool|array<mixed>>|null
     */
    protected $options;

    /**
     * Force update report, if it already was generated previously.
     *
     * @var bool|null
     */
    protected $is_force;

    /**
     * URL to call (using `post` method) when report content updated.
     *
     * @var string|null
     */
    protected $on_update_url;

    /**
     * URL to call (using `post` method) when report generation completed.
     *
     * @var string|null
     */
    protected $on_complete_url;

    /**
     * Additional request data.
     *
     * @var array<string, string|int|float|bool|null|array<mixed>>|null
     */
    protected $data;

    /**
     * Idempotence key which the server uses to recognize subsequent retries of the same request.
     *
     * @var string|null
     */
    protected $idempotence_key;

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
     * Get unique report type ID (e.g.: `some_report_uid` or `some_report_uid@domain`).
     *
     * @return string
     */
    public function getReportTypeUid(): string
    {
        return $this->report_type_uid;
    }

    /**
     * Get request type (e.g.: `VIN`, `GRZ`, `STS`, `PTS`, `CHASSIS`, etc.).
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get request value (e.g.: `Z94CB41AAGR323020` (VIN), `А111АА177` (GRZ)).
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
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

    /**
     * Set `force update report` flag, if it already was generated previously.
     *
     * @param bool $is_force
     *
     * @return $this
     */
    public function setForce(bool $is_force): self
    {
        $this->is_force = $is_force;

        return $this;
    }

    /**
     * Get force update report flag.
     *
     * @return bool|null
     */
    public function isForce(): ?bool
    {
        return $this->is_force;
    }

    /**
     * Set URL to call (using `post` method) when report content updated.
     *
     * @param string $on_update_url
     *
     * @return $this
     */
    public function setOnUpdateUrl(string $on_update_url): self
    {
        $this->on_update_url = $on_update_url;

        return $this;
    }

    /**
     * Get URL to call (using `post` method) when report content updated.
     *
     * @return string|null
     */
    public function getOnUpdateUrl(): ?string
    {
        return $this->on_update_url;
    }

    /**
     * Set URL to call (using `post` method) when report generation completed.
     *
     * @param string $on_complete_url
     *
     * @return $this
     */
    public function setOnCompleteUrl(string $on_complete_url): self
    {
        $this->on_complete_url = $on_complete_url;

        return $this;
    }

    /**
     * Get URL to call (using `post` method) when report generation completed.
     *
     * @return string|null
     */
    public function getOnCompleteUrl(): ?string
    {
        return $this->on_complete_url;
    }

    /**
     * Set additional request data.
     *
     * @param array<string, string|int|float|bool|null|array<mixed>> $data
     *
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get additional request data.
     *
     * @return array<string, string|int|float|bool|null|array<mixed>>|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * Set idempotence key for request.
     *
     * @param string $idempotence_key
     *
     * @return $this
     */
    public function setIdempotenceKey(string $idempotence_key): self
    {
        $this->idempotence_key = $idempotence_key;

        return $this;
    }

    /**
     * Get idempotence key for request.
     *
     * @return string|null
     */
    public function getIdempotenceKey(): ?string
    {
        return $this->idempotence_key;
    }
}

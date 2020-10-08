<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class ReportMakeParams
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
     * @var array<mixed>|null
     */
    private $options = [];

    /**
     * Force update report, if it already was generated previously.
     *
     * @var bool
     */
    private $is_force = false;

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
     * @var array<mixed>|null
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
     * @return string
     */
    public function getReportTypeUid(): string
    {
        return $this->report_type_uid;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param array<mixed>|null $options
     *
     * @return $this
     */
    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array<mixed>|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
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
     * @return bool
     */
    public function isForce(): bool
    {
        return $this->is_force;
    }

    /**
     * @param string|null $on_update_url
     *
     * @return $this
     */
    public function setOnUpdateUrl(?string $on_update_url): self
    {
        $this->on_update_url = $on_update_url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOnUpdateUrl(): ?string
    {
        return $this->on_update_url;
    }

    /**
     * @param string|null $on_complete_url
     *
     * @return $this
     */
    public function setOnCompleteUrl(?string $on_complete_url): self
    {
        $this->on_complete_url = $on_complete_url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOnCompleteUrl(): ?string
    {
        return $this->on_complete_url;
    }

    /**
     * Set additional request data.
     *
     * @param array<mixed>|null $data
     *
     * @return $this
     */
    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array<mixed>|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * Set idempotence key for request.
     *
     * @param string|null $idempotence_key
     *
     * @return $this
     */
    public function setIdempotenceKey(?string $idempotence_key): self
    {
        $this->idempotence_key = $idempotence_key;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIdempotenceKey(): ?string
    {
        return $this->idempotence_key;
    }
}
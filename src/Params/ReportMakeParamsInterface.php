<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

interface ReportMakeParamsInterface
{
    /**
     * Get unique report type ID (e.g.: `some_report_uid` or `some_report_uid@domain`).
     *
     * @return string
     */
    public function getReportTypeUid(): string;

    /**
     * Get request type (e.g.: `VIN`, `GRZ`, `STS`, `PTS`, `CHASSIS`, etc.).
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get request value (e.g.: `Z94CB41AAGR323020` (VIN), `А111АА177` (GRZ)).
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Set additional request options.
     *
     * @param array<string, string|int|float|bool|array<mixed>> $options
     *
     * @return $this
     */
    public function setOptions(array $options): ReportMakeParamsInterface;

    /**
     * Get additional request options.
     *
     * @return array<string, string|int|float|bool|array<mixed>>|null
     */
    public function getOptions(): ?array;

    /**
     * Set `force update report` flag, if it already was generated previously.
     *
     * @param bool $is_force
     *
     * @return $this
     */
    public function setForce(bool $is_force): ReportMakeParamsInterface;

    /**
     * Get force update report flag.
     *
     * @return bool|null
     */
    public function isForce(): ?bool;

    /**
     * Set URL to call (using `post` method) when report content updated.
     *
     * @param string $on_update_url
     *
     * @return $this
     */
    public function setOnUpdateUrl(string $on_update_url): ReportMakeParamsInterface;

    /**
     * Get URL to call (using `post` method) when report content updated.
     *
     * @return string|null
     */
    public function getOnUpdateUrl(): ?string;

    /**
     * Set URL to call (using `post` method) when report generation completed.
     *
     * @param string $on_complete_url
     *
     * @return $this
     */
    public function setOnCompleteUrl(string $on_complete_url): ReportMakeParamsInterface;

    /**
     * Get URL to call (using `post` method) when report generation completed.
     *
     * @return string|null
     */
    public function getOnCompleteUrl(): ?string;

    /**
     * Set additional request data.
     *
     * @param array<string, string|int|float|bool|null|array<mixed>> $data
     *
     * @return $this
     */
    public function setData(array $data): ReportMakeParamsInterface;

    /**
     * Get additional request data.
     *
     * @return array<string, string|int|float|bool|null|array<mixed>>|null
     */
    public function getData(): ?array;

    /**
     * Set idempotence key for request.
     *
     * @param string $idempotence_key
     *
     * @return $this
     */
    public function setIdempotenceKey(string $idempotence_key): ReportMakeParamsInterface;

    /**
     * Get idempotence key for request.
     *
     * @return string|null
     */
    public function getIdempotenceKey(): ?string;
}

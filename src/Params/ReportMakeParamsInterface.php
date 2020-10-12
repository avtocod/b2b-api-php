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
     * Get additional request options.
     *
     * @return array<string, string|int|float|bool|array<mixed>>|null
     */
    public function getOptions(): ?array;

    /**
     * Get force update report flag.
     *
     * @return bool|null
     */
    public function isForce(): ?bool;

    /**
     * Get URL to call (using `post` method) when report content updated.
     *
     * @return string|null
     */
    public function getOnUpdateUrl(): ?string;

    /**
     * Get URL to call (using `post` method) when report generation completed.
     *
     * @return string|null
     */
    public function getOnCompleteUrl(): ?string;

    /**
     * Get additional request data.
     *
     * @return array<string, string|int|float|bool|null|array<mixed>>|null
     */
    public function getData(): ?array;

    /**
     * Get idempotence key for request.
     *
     * @return string|null
     */
    public function getIdempotenceKey(): ?string;
}

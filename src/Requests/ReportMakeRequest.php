<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Requests;

class ReportMakeRequest
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
     * Return data to make request
     *
     * @return object
     */
    public function getBodyObject(): object
    {
        $request_body = [
            'queryType' => $this->type,
            'query'     => $this->value,
        ];

        $options = [
            'FORCE' => $this->is_force
        ];

        if ($this->on_update_url !== null) {
            $options['webhook']['on_update'] = $this->on_update_url;
        }

        if ($this->on_complete_url !== null) {
            $options['webhook']['on_complete'] = $this->on_complete_url;
        }

        if ($this->idempotence_key !== null) {
            $request_body['idempotenceKey'] = $this->idempotence_key;
        }

        if ($this->data !== null) {
            $request_body['data'] = (object)$this->data;
        }

        $request_body['options'] = (object)\array_replace($options, $this->options ?? []);

        return (object) $request_body;
    }

    /**
     * @return string
     */
    public function getReportTypeUid(): string
    {
        return $this->report_type_uid;
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
}

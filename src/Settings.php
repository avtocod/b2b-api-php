<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi;

use GuzzleHttp\RequestOptions as GuzzleHttpOptions;

class Settings
{
    /**
     * @var string
     */
    protected $auth_token;

    /**
     * @var string
     */
    protected $base_uri = 'https://b2bapi.avtocod.ru/b2b/api/v1/';

    /**
     * @var array
     */
    protected $guzzle_options = [
        GuzzleHttpOptions::VERIFY  => true,
        GuzzleHttpOptions::TIMEOUT => 60.0,
    ];

    /**
     * Create a new Settings instance.
     *
     * @param string      $auth_token
     * @param string|null $base_uri
     * @param array|null  $guzzle_options
     */
    public function __construct(string $auth_token,
                                ?string $base_uri = null,
                                ?array $guzzle_options = null)
    {
        $this->auth_token = $auth_token;

        if ($base_uri !== null) {
            $this->base_uri = \rtrim($base_uri, '/ ') . '/';
        }

        if ($guzzle_options !== null) {
            $this->guzzle_options = \array_replace($this->guzzle_options, $guzzle_options);
        }
    }

    /**
     * Get API base uri.
     *
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->base_uri;
    }

    /**
     * Get guzzle options array.
     *
     * @return array
     */
    public function getGuzzleOptions(): array
    {
        return $this->guzzle_options;
    }

    /**
     * Get auth token.
     *
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->auth_token;
    }

    /**
     * Set auth token.
     *
     * @param string $auth_token
     */
    public function setAuthToken(string $auth_token): void
    {
        $this->auth_token = $auth_token;
    }
}

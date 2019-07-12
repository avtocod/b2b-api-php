<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses;

use Tarampampam\Wrappers\Json;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class DevPingResponse implements ResponseInterface
{
    /**
     * @var string
     */
    protected $raw_response_content;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var int
     */
    protected $in;

    /**
     * @var int
     */
    protected $out;

    /**
     * @var int
     */
    protected $delay;

    /**
     * Create a new response instance.
     *
     * @param string $raw_response
     * @param string $value
     * @param int    $in
     * @param int    $out
     * @param int    $delay
     */
    private function __construct(string $raw_response, string $value, int $in, int $out, int $delay)
    {
        $this->raw_response_content = $raw_response;
        $this->value                = $value;
        $this->in                   = $in;
        $this->out                  = $out;
        $this->delay                = $delay;
    }

    /**
     * {@inheritdoc}
     */
    public function getRawResponseContent(): string
    {
        return $this->raw_response_content;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BadResponseException
     */
    public static function fromHttpResponse(HttpResponseInterface $response): self
    {
        try {
            $as_array = (array) Json::decode($raw_response = (string) $response->getBody());
        } catch (JsonEncodeDecodeException $e) {
            throw BadResponseException::wrongJson($response, $e->getMessage(), $e);
        }

        return new static(
            $raw_response,
            $as_array['value'],
            $as_array['in'],
            $as_array['out'],
            $as_array['delay']
        );
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getDelay(): int
    {
        return $this->delay;
    }

    /**
     * @return int
     */
    public function getIn(): int
    {
        return $this->in;
    }

    /**
     * @return int
     */
    public function getOut(): int
    {
        return $this->out;
    }
}

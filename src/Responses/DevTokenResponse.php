<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses;

use DateTimeImmutable;
use Avtocod\B2BApi\DateTimeFactory;
use Avtocod\B2BApi\Exceptions\BadResponseException;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class DevTokenResponse implements ResponseInterface
{
    /**
     * @var string
     */
    protected $raw_response_content;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $password_hash;

    /**
     * @var DateTimeImmutable
     */
    protected $date;

    /**
     * @var int
     */
    protected $stamp;

    /**
     * @var int
     */
    protected $age;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var string
     */
    protected $salted_pass_hash;

    /**
     * @var string
     */
    protected $raw_token;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $header;

    /**
     * Create a new response instance.
     *
     * @param string            $raw_response
     * @param string            $user
     * @param string            $password
     * @param string            $password_hash
     * @param DateTimeImmutable $date
     * @param int               $stamp
     * @param int               $age
     * @param string            $salt
     * @param string            $salted_pass_hash
     * @param string            $raw_token
     * @param string            $token
     * @param string            $header
     */
    private function __construct(string $raw_response,
                                 string $user,
                                 string $password,
                                 string $password_hash,
                                 DateTimeImmutable $date,
                                 int $stamp,
                                 int $age,
                                 string $salt,
                                 string $salted_pass_hash,
                                 string $raw_token,
                                 string $token,
                                 string $header)
    {
        $this->raw_response_content = $raw_response;
        $this->user                 = $user;
        $this->password             = $password;
        $this->password_hash        = $password_hash;
        $this->date                 = $date;
        $this->stamp                = $stamp;
        $this->age                  = $age;
        $this->salt                 = $salt;
        $this->salted_pass_hash     = $salted_pass_hash;
        $this->raw_token            = $raw_token;
        $this->token                = $token;
        $this->header               = $header;
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
        $as_array = (array) \json_decode($raw_response = (string) $response->getBody(), true);

        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw BadResponseException::wrongJson($response, \json_last_error_msg());
        }

        return new self(
            $raw_response,
            $as_array['user'],
            $as_array['pass'],
            $as_array['pass_hash'],
            DateTimeImmutable::createFromMutable(DateTimeFactory::createFromIso8601Zulu($as_array['date'])),
            $as_array['stamp'],
            $as_array['age'],
            $as_array['salt'],
            $as_array['salted_pass_hash'],
            $as_array['raw_token'],
            $as_array['token'],
            $as_array['header']
        );
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getStamp(): int
    {
        return $this->stamp;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @return string
     */
    public function getSaltedPassHash(): string
    {
        return $this->salted_pass_hash;
    }

    /**
     * @return string
     */
    public function getRawToken(): string
    {
        return $this->raw_token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }
}

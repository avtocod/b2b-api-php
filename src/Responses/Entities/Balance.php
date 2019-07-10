<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

use DateTime;
use Avtocod\B2BApi\DateTimeFactory;

class Balance implements CanCreateSelfFromArrayInterface
{
    /**
     * Daily balance type.
     */
    public const DAILY = 'DAY';

    /**
     * Monthly balance type.
     */
    public const MONTHLY = 'MONTH';

    /**
     * Totally balance type.
     */
    public const TOTALLY = 'TOTAL';

    /**
     * @var string
     */
    protected $report_type_uid;

    /**
     * @var string
     */
    protected $balance_type;

    /**
     * @var int
     */
    protected $quote_init;

    /**
     * @var int
     */
    protected $quote_up;

    /**
     * @var int
     */
    protected $quote_use;

    /**
     * @var DateTime|null
     */
    protected $created_at;

    /**
     * @var DateTime|null
     */
    protected $updated_at;

    /**
     * Create a new balance instance.
     *
     * @param string        $report_type_uid Report type unique identifier
     * @param string        $balance_type    Balance entry type (e.g.: `DAY`, `MONTH`, `TOTAL`)
     * @param int           $quote_init      Initial quota value
     * @param int           $quote_up        Added quota value
     * @param int           $quote_use       Used quota value
     * @param DateTime|null $created_at      Balance entry created at
     * @param DateTime|null $updated_at      Last changes was made at
     */
    public function __construct(string $report_type_uid,
                                string $balance_type,
                                int $quote_init,
                                int $quote_up,
                                int $quote_use,
                                ?DateTime $created_at,
                                ?DateTime $updated_at)
    {
        $this->report_type_uid = $report_type_uid;
        $this->balance_type    = $balance_type;
        $this->quote_init      = $quote_init;
        $this->quote_up        = $quote_up;
        $this->quote_use       = $quote_use;
        $this->created_at      = $created_at;
        $this->updated_at      = $updated_at;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data): self
    {
        return new static(
            $data['report_type_uid'],
            $data['balance_type'],
            $data['quote_init'],
            $data['quote_up'],
            $data['quote_use'],
            isset($data['created_at'])
                ? DateTimeFactory::createFromIso8601Zulu($data['created_at'])
                : null,
            isset($data['updated_at'])
                ? DateTimeFactory::createFromIso8601Zulu($data['updated_at'])
                : null
        );
    }

    /**
     * Get report type unique identifier.
     *
     * @return string
     */
    public function getReportTypeUid(): string
    {
        return $this->report_type_uid;
    }

    /**
     * Get balance entry type.
     *
     * @return string E.g.: `DAY`, `MONTH`, `TOTAL`
     */
    public function getBalanceType(): string
    {
        return $this->balance_type;
    }

    /**
     * Get initial quota value.
     *
     * @return int
     */
    public function getQuoteInit(): int
    {
        return $this->quote_init;
    }

    /**
     * Get added quota value.
     *
     * @return int
     */
    public function getQuoteUp(): int
    {
        return $this->quote_up;
    }

    /**
     * Get used quota value.
     *
     * @return int
     */
    public function getQuoteUse(): int
    {
        return $this->quote_use;
    }

    /**
     * Get created at date/time.
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    /**
     * Get last changes date/time.
     *
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }
}

<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class UserReportTypesParams
{
    /**
     * True, if User can generate reports for report type.
     *
     * @var bool|null
     */
    protected $can_generate;

    /**
     * Description of query for fetching list data.
     *
     * @var string|null
     */
    protected $query;

    /**
     * Page number.
     *
     * @var int|null
     */
    protected $page;

    /**
     * Items per page.
     *
     * @var int|null
     */
    protected $per_page;

    /**
     * Pagination offset.
     *
     * @var int|null
     */
    protected $offset;

    /**
     * Sorting rules.
     *
     * @var string|null
     */
    protected $sort_by;

    /**
     * True, if necessary include list item content into response.
     *
     * @var bool|null
     */
    protected $with_content;

    /**
     * True, if necessary calculate total items count.
     *
     * @var bool|null
     */
    protected $calc_total;

    /**
     * @param bool $can_generate
     *
     * @return $this
     */
    public function setCanGenerate(bool $can_generate): self
    {
        $this->can_generate = $can_generate;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isCanGenerate(): ?bool
    {
        return $this->can_generate;
    }

    /**
     * @param string $query
     *
     * @return $this
     */
    public function setQuery(string $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @param int $per_page
     *
     * @return $this
     */
    public function setPerPage(int $per_page): self
    {
        $this->per_page = $per_page;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerPage(): ?int
    {
        return $this->per_page;
    }

    /**
     * @param int $offset
     *
     * @return $this
     */
    public function setOffset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param string $sort_by
     *
     * @return $this
     */
    public function setSortBy(string $sort_by): self
    {
        $this->sort_by = $sort_by;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSortBy(): ?string
    {
        return $this->sort_by;
    }

    /**
     * @param bool $with_content
     *
     * @return $this
     */
    public function setWithContent(bool $with_content): self
    {
        $this->with_content = $with_content;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isWithContent(): ?bool
    {
        return $this->with_content;
    }

    /**
     * @param bool $calc_total
     *
     * @return $this
     */
    public function setCalcTotal(bool $calc_total): self
    {
        $this->calc_total = $calc_total;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isCalcTotal(): ?bool
    {
        return $this->calc_total;
    }
}

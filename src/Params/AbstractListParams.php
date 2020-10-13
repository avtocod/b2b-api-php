<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

abstract class AbstractListParams
{
    /**
     * Description of query for fetching list data.
     *
     * @var string
     */
    private $query = '_all';

    /**
     * Page number.
     *
     * @var int
     */
    private $page = 1;

    /**
     * Items per page.
     *
     * @var int
     */
    private $per_page = 20;

    /**
     * Pagination offset.
     *
     * @var int
     */
    private $offset = 0;

    /**
     * Sorting rules.
     *
     * @var string
     */
    private $sort_by = '-created_at';

    /**
     * True, if necessary include list item content into response.
     *
     * @var bool
     */
    private $include_content = false;

    /**
     * True, if necessary calculate total items count.
     *
     * @var bool
     */
    private $calc_total = false;

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
     * @return string
     */
    public function getQuery(): string
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
     * @return int
     */
    public function getPage(): int
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
     * @return int
     */
    public function getPerPage(): int
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
     * @return int
     */
    public function getOffset(): int
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
     * @return string
     */
    public function getSortBy(): string
    {
        return $this->sort_by;
    }

    /**
     * @param bool $include_content
     *
     * @return $this
     */
    public function setIncludeContent(bool $include_content): self
    {
        $this->include_content = $include_content;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIncludeContent(): bool
    {
        return $this->include_content;
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
     * @return bool
     */
    public function getCalcTotal(): bool
    {
        return $this->calc_total;
    }
}
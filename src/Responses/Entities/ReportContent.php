<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Responses\Entities;

class ReportContent
{
    /**
     * @var array<mixed, mixed>
     */
    protected $content;

    /**
     * Create a new report content instance.
     *
     * @param array<mixed, mixed> $content
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    /**
     * Get report content.
     *
     * @return array<mixed, mixed>
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * Get content using path in some notation (dot, by default).
     *
     * @param string           $path
     * @param mixed|null       $default
     * @param non-empty-string $delimiter Dot `.` by default
     *
     * @return mixed
     */
    public function getByPath(string $path, $default = null, string $delimiter = '.')
    {
        $delimiter = \mb_strlen($delimiter) ? $delimiter : '.';

        return \array_reduce((array) \explode($delimiter, $path), static function ($carry, $item) use (&$default) {
            return \is_numeric($item) || \is_array($carry)
                ? ($carry[$item] ?? $default)
                : ($carry->$item ?? $default);
        }, $this->content);
    }
}

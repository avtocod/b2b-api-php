<?php

namespace Avtocod\B2BApi\Responses\Entities;

interface CanCreateSelfFromArrayInterface
{
    /**
     * Create self using array of data.
     *
     * @param array<mixed> $data
     *
     * @return self|$this
     */
    public static function fromArray(array $data);
}

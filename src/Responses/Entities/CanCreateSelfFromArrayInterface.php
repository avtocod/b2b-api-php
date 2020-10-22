<?php

namespace Avtocod\B2BApi\Responses\Entities;

interface CanCreateSelfFromArrayInterface
{
    /**
     * Create self using array of data.
     *
     * @param array<string, mixed> $data
     *
     * @return self
     */
    public static function fromArray(array $data);
}

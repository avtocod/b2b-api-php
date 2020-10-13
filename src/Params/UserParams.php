<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

final class UserParams
{
    /**
     * True, if necessary detailed information about user.
     *
     * @var bool
     */
    private $detailed = false;

    /**
     * @param bool $detailed
     *
     * @return $this
     */
    public function setDetailed(bool $detailed): UserParams
    {
        $this->detailed = $detailed;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDetailed(): bool
    {
        return $this->detailed;
    }
}
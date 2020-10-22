<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class UserParams
{
    /**
     * True, if necessary detailed information about user.
     *
     * @var bool|null
     */
    protected $detailed;

    /**
     * @param bool $detailed
     *
     * @return $this
     */
    public function setDetailed(bool $detailed): self
    {
        $this->detailed = $detailed;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isDetailed(): ?bool
    {
        return $this->detailed;
    }
}

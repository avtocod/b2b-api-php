<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

class DevPingParams
{
    /**
     * Any string value (server must returns it back).
     *
     * @var string|null
     */
    protected $value;

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}

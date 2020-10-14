<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Params;

final class UserReportTypesParams extends AbstractListParams
{
    /**
     * True, if User can generate reports for report type.
     *
     * @var bool
     */
    private $can_generate = false;

    /**
     * @param bool $can_generate
     *
     * @return $this
     */
    public function setCanGenerate(bool $can_generate): UserReportTypesParams
    {
        $this->can_generate = $can_generate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCanGenerate(): bool
    {
        return $this->can_generate;
    }
}
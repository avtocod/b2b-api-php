<?php

namespace Avtocod\B2BApi\Responses;

interface WithRawResponseGetterInterface
{
    /**
     * Get raw response content (json-string, as usual).
     *
     * @return mixed
     */
    public function getRawResponseContent();
}

<?php

namespace Avtocod\B2BApi;

interface WithSettingsInterface
{
    /**
     * Get client settings object.
     *
     * @return Settings
     */
    public function getSettings(): Settings;
}

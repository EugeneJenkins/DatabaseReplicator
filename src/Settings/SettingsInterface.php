<?php

namespace Eugene\DatabaseReplicator\Settings;

interface SettingsInterface
{
    /**
     * @return array<array<string>>
     */
    public function load(): array;
}
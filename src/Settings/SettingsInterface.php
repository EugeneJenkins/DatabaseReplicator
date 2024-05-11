<?php

namespace Eugene\DatabaseReplicator\Settings;

interface SettingsInterface
{
    public function load(): array;
}
<?php

namespace Eugene\DatabaseReplicator\Factory;

use Eugene\DatabaseReplicator\Settings\SettingsInterface;

interface CreateSettingsFactoryInterface
{
    public static function createSettings(): SettingsInterface;
}
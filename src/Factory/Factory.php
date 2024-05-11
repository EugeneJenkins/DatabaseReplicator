<?php
declare(strict_types=1);

namespace Eugene\DatabaseReplicator\Factory;

use Eugene\DatabaseReplicator\Settings\JsonSettings;
use Eugene\DatabaseReplicator\Database\MySQLConnection;
use Eugene\DatabaseReplicator\Settings\SettingsInterface;
use Eugene\DatabaseReplicator\Database\DatabaseSettingsDTO;

class Factory implements CreateDatabaseConnectionInterface, CreateSettingsFactoryInterface
{
    public static function createDatabase(array $settings): MySQLConnection
    {
        return new MySQLConnection(new DatabaseSettingsDTO($settings));
    }

    public static function createSettings(): SettingsInterface
    {
        return new JsonSettings();
    }
}
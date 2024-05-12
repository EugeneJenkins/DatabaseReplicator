<?php
declare(strict_types=1);

namespace Eugene\DatabaseReplicator\Factory;

use Eugene\DatabaseReplicator\Broker\FileBroker;
use Eugene\DatabaseReplicator\Settings\JsonSettings;
use Eugene\DatabaseReplicator\Broker\BrokerInterface;
use Eugene\DatabaseReplicator\Database\MySQLConnection;
use Eugene\DatabaseReplicator\Settings\SettingsInterface;
use Eugene\DatabaseReplicator\Database\DatabaseSettingsDTO;

class Factory implements CreateDatabaseConnectionInterface, CreateSettingsFactoryInterface, CreateBrokerFactoryInterface
{
    public static function createDatabase(array $settings): MySQLConnection
    {
        /** @phpstan-ignore-next-line */
        return new MySQLConnection(new DatabaseSettingsDTO($settings));
    }

    public static function createSettings(): SettingsInterface
    {
        return new JsonSettings();
    }

    public static function createBroker(): BrokerInterface
    {
        return new FileBroker();
    }
}
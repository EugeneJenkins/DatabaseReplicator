<?php

namespace Eugene\DatabaseReplicator\Factory;

use Eugene\DatabaseReplicator\Database\MySQLConnection;

interface CreateDatabaseConnectionInterface
{
    /**
     * @param array<string> $settings
     * @return MySQLConnection
     */
    public static function createDatabase(array $settings): MySQLConnection;
}
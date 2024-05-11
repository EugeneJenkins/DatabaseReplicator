<?php

namespace Eugene\DatabaseReplicator\Factory;

use Eugene\DatabaseReplicator\Database\MySQLConnection;

interface CreateDatabaseConnectionInterface
{
    public static function createDatabase(array $settings): MySQLConnection;
}
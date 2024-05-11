<?php

namespace Eugene\DatabaseReplicator\Database;

use PDO;

interface ConnectionInterface
{
    public function getConnection(): PDO;
}
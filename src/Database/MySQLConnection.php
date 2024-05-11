<?php

namespace Eugene\DatabaseReplicator\Database;

use PDO;

readonly class MySQLConnection implements ConnectionInterface
{
    private PDO $connection;

    public function __construct(DatabaseSettingsDTO $dto)
    {
        $this->connection = new PDO(
            sprintf('mysql:host=%s;dbname=%s', $dto->getHost(), $dto->getDbName()),
            $dto->getName(),
            $dto->getPassword()
        );
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}

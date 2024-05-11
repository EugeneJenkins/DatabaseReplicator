<?php

namespace Eugene\DatabaseReplicator\Database;

use PDO;
use PDOStatement;

class DatabaseManager
{
    /**
     * @var array <string>
     */
    private array $tableNames;

    public function __construct(private readonly ConnectionInterface $connection)
    {
    }

    /**
     * @return array<Table>
     */
    public function getAllTables(): array
    {
        $this->tableNames = [];
        $tables = [];
        $response = $this->getAll('SHOW TABLES');

        foreach ($response as $row) {
            $tableName = array_shift($row);
            $this->tableNames[] = $tableName;
            $tables[$tableName] = new Table($tableName, $this);
        }

        return $tables;
    }

    public function getTableByName(string $name): Table
    {
        return new Table($name, $this);
    }

    /**
     * @return array <string>
     */
    public function getAllTableNames(): array
    {
        if (empty($this->tableNames)){
            $this->getAllTables();
        }

        return $this->tableNames;
    }

    public function getAll(string $sql): array
    {
        return $this->query($sql)->fetchAll();
    }

    public function get(string $sql): array
    {
        $response = $this->query($sql)->fetch();

        if (!is_array($response)) {
            return [];
        }

        return $response;
    }

    private function query(string $sql): PDOStatement
    {
        return $this->connection->getConnection()->query($sql, PDO::FETCH_ASSOC);
    }

    public function multipleInsert(string $sql, array $data): bool
    {
        return $this->connection->getConnection()->prepare($sql)->execute($data);
    }

    public function beginTransaction(): void
    {
        $this->connection->getConnection()->beginTransaction();
    }

    public function rollBackTransaction(): void
    {
        $this->connection->getConnection()->rollBack();
    }

    public function commitBackTransaction(): void
    {
        $this->connection->getConnection()->commit();
    }
}
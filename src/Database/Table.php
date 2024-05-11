<?php

namespace Eugene\DatabaseReplicator\Database;

use Exception;

class Table
{
    private array $primaryKeys = [];

    public function __construct(private readonly string $name, private readonly DatabaseManager $manager)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrimaryKeys(): array
    {
        if (empty($this->primaryKeys)) {
            $response = $this->manager->getAll("SHOW KEYS FROM $this->name WHERE Key_name = 'PRIMARY'");

            foreach ($response as $row) {
                $this->primaryKeys[] = $row['Column_name'];
            }
        }

        return $this->primaryKeys;
    }

    public function getAll(): array
    {
        return $this->manager->getAll("SELECT * FROM {$this->getName()}");
    }

    public function insertRow(array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $columns = implode(',', array_keys(array_shift($data)));

        try {
            $this->manager->beginTransaction();

            foreach ($data as $row) {
                $bind = [];
                foreach ($row as $key => $item) {
                    $bind[":$key"] = $item ?? '';
                }

                $values = implode(',', array_keys($bind));

                $sql = "INSERT INTO {$this->getName()} ($columns) VALUES ($values)";

                $this->manager->multipleInsert($sql, $bind);
            }

            $this->manager->commitBackTransaction();
        } catch (Exception $exception) {
            echo $exception->getMessage();

            $this->manager->rollBackTransaction();
            return false;
        }

        return true;
    }
}
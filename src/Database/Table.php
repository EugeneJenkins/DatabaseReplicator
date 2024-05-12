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

    public function generateQueries(array $data): array
    {
        $queries = [];

        $test = $data;
        $columns = implode(',', array_map(
                fn($item) => sprintf('`%s`', $item),
                array_keys(array_shift($test)))
        );

        foreach ($data as $row) {
            $values = implode(',', array_map(fn($item) => sprintf('"%s"', $item), $row));

            $queries[] = "INSERT INTO {$this->getName()} ($columns) VALUES ($values)";
        }

        return $queries;
    }
}
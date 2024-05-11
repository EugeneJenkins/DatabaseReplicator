<?php

namespace Eugene\DatabaseReplicator;

use Eugene\DatabaseReplicator\Database\DatabaseManager;
use Eugene\DatabaseReplicator\Database\MySQLConnection;

readonly class Replicator
{
    private DatabaseManager $primary;
    private DatabaseManager $secondary;

    public function __construct(MySQLConnection $primary, MySQLConnection $secondary)
    {
        $this->primary = new DatabaseManager($primary);
        $this->secondary = new DatabaseManager($secondary);
    }

    public function merge(): void
    {
        $primaryTables = $this->primary->getAllTables();
        $secondaryTables = $this->secondary->getAllTableNames();

        $primaryTables = array_filter($primaryTables, fn($primary) => in_array($primary->getName(), $secondaryTables));

        foreach ($primaryTables as $table) {
            echo $table->getName() . "\n";

            $secondaryTable = $this->secondary->getTableByName($table->getName());
            $finder = new TableRawDifferenceFinder($table, $secondaryTable);
            $difference = $finder->findDifference();

            try {
                $secondaryTable->insertRow($difference);
            } catch (\Throwable $exception) {
                $exception->getMessage();

                echo "\n";
                break;
            }
        }
    }
}
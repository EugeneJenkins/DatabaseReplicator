<?php

namespace Eugene\DatabaseReplicator;

use Eugene\DatabaseReplicator\Factory\Factory;
use Eugene\DatabaseReplicator\Broker\BrokerInterface;
use Eugene\DatabaseReplicator\Database\DatabaseManager;
use Eugene\DatabaseReplicator\Database\MySQLConnection;
use Eugene\DatabaseReplicator\Exceptions\DatabaseException;
use Eugene\DatabaseReplicator\Exceptions\TableNameMismatchException;

readonly class Replicator
{
    private DatabaseManager $primary;
    private DatabaseManager $secondary;
    private BrokerInterface $broker;

    public function __construct(MySQLConnection $primary, MySQLConnection $secondary)
    {
        $this->primary = new DatabaseManager($primary);
        $this->secondary = new DatabaseManager($secondary);
        $this->broker = Factory::createBroker();
    }

    /**
     * @throws DatabaseException
     * @throws TableNameMismatchException
     */
    public function merge(): void
    {
        $primaryTables = $this->primary->getAllTables();
        $secondaryTables = $this->secondary->getAllTableNames();

        $primaryTables = array_filter($primaryTables, fn($primary) => in_array($primary->getName(), $secondaryTables));

        foreach ($primaryTables as $table) {
            echo $table->getName() . "\n";

            if ('bp_PaymentsHistory' != $table->getName()){
                continue;
            }

            $secondaryTable = $this->secondary->getTableByName($table->getName());
            $difference = (new TableRawDifferenceFinder($table, $secondaryTable))->findDifference();

            echo sprintf("memory: %d MB \n", round(memory_get_usage(true) / 1048576, 2));
            echo sprintf("Count of difference: %d\n", count($difference));

            try {
                if (empty($difference)) {
                    continue;
                }
                gc_collect_cycles();

                $this->broker->push($secondaryTable->generateQueries($difference));

                unset($difference);
            } catch (\Throwable $exception) {
                echo $exception->getMessage();

                echo "\n";
                break;
            }
        }
    }
}
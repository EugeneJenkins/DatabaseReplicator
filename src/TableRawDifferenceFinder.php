<?php

namespace Eugene\DatabaseReplicator;

use Eugene\DatabaseReplicator\Database\Table;
use Eugene\DatabaseReplicator\Exceptions\TableNameMismatchException;

class TableRawDifferenceFinder
{
    public function __construct(
        private Table $primaryTable,
        private Table $secondaryTable,
    )
    {
    }

    /**
     * @throws TableNameMismatchException
     */
    public function findDifference(): array
    {
        if ($this->primaryTable->getName() !== $this->secondaryTable->getName()) {
            throw new TableNameMismatchException();
        }

        $primaryRows = $this->primaryTable->getAll();
        $reference = $this->secondaryTable->getAll();
        $keys = $this->primaryTable->getPrimaryKeys();

        if (empty($primaryRows)) {
            return [];
        }

        if (empty($keys)) {
            return $this->findDifferenceByIdenticalArray($primaryRows, $reference);
        }

        return $this->findDifferenceByPrimaryKeys($primaryRows, $reference, $keys);
    }

    private function findDifferenceByIdenticalArray(array $primaryRows, array $reference): array
    {
        return array_filter($primaryRows, fn($source) => !in_array($source, $reference));
    }

    private function findDifferenceByPrimaryKeys(array $data, array $data2, array $primaryKeys): array
    {
        return array_filter($data, function ($row) use ($data2, $primaryKeys) {
            foreach ($data2 as $item) {
                $counter = 0;
                foreach ($primaryKeys as $primaryKey) {
                    if ($item[$primaryKey] === $row[$primaryKey]) {
                        $counter++;
                    }
                }

                if ($counter == count($primaryKeys)) {
                    return false;
                }
            }

            return true;
        });
    }
}
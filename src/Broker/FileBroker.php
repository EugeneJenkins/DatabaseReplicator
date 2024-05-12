<?php

namespace Eugene\DatabaseReplicator\Broker;

use Eugene\DatabaseReplicator\File\FileWriteException;
use Eugene\DatabaseReplicator\File\FileWriter;

readonly class FileBroker implements BrokerInterface
{
    private FileWriter $file;

    public function __construct()
    {
        $this->file = new FileWriter();
    }

    /**
     * @throws FileWriteException
     */
    public function push(array $data): void
    {
        foreach ($data as $row) {
            $this->file->write($row);
        }
    }
}
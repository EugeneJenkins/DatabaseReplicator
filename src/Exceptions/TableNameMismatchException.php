<?php

namespace Eugene\DatabaseReplicator\Exceptions;

use Exception;

class TableNameMismatchException extends Exception
{
    public function __construct()
    {
        parent::__construct('Table names do not match', 1000);
    }
}
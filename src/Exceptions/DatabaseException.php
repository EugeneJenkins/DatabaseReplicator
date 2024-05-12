<?php

namespace Eugene\DatabaseReplicator\Exceptions;

use Exception;

class DatabaseException extends Exception
{
    public function __construct(string $message = 'Database Error')
    {
        parent::__construct($message);
    }
}
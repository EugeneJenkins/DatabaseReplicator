<?php

namespace Eugene\DatabaseReplicator\Exceptions;

use Exception;

class MissingPrimaryKeyException extends Exception
{
    public function __construct()
    {
        parent::__construct('There are no primary keys to compare', 1001);
    }
}
<?php

namespace Eugene\DatabaseReplicator\File;

use Exception;

class FileWriteException extends Exception
{
    public function __construct(
        string     $message = 'The file is missing or does not have sufficient write permissions.',
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
<?php

namespace Eugene\DatabaseReplicator\Exceptions;

use Exception;

class SettingsLoadException extends Exception
{
    public function __construct()
    {
        parent::__construct('Failed to load settings');
    }
}
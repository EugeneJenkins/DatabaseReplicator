<?php
declare(strict_types=1);

namespace Eugene\DatabaseReplicator\Database;

readonly class DatabaseSettingsDTO
{
    public function __construct(private array $settings)
    {
    }

    public function getName(): string
    {
        return $this->settings['name'];
    }

    public function getPassword(): string
    {
        return $this->settings['password'];
    }

    public function getHost(): string
    {
        return $this->settings['password'];
    }

    public function getDbName(): string
    {
        return $this->settings['dbName'];
    }
}
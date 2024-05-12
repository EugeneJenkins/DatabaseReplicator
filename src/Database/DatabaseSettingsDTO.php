<?php
declare(strict_types=1);

namespace Eugene\DatabaseReplicator\Database;

readonly class DatabaseSettingsDTO
{
    /**
     * @param array{
     *      "user": string,
     *      "password": string,
     *      "host": string,
     *      "dbName": string
     * } $settings
     */
    public function __construct(private array $settings)
    {
    }

    public function getUser(): string
    {
        return $this->settings['user'];
    }

    public function getPassword(): string
    {
        return $this->settings['password'];
    }

    public function getHost(): string
    {
        return $this->settings['host'];
    }

    public function getDbName(): string
    {
        return $this->settings['dbName'];
    }
}
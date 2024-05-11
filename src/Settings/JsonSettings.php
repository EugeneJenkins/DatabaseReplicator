<?php
declare(strict_types=1);

namespace Eugene\DatabaseReplicator\Settings;

final class JsonSettings implements SettingsInterface
{
    private string $path;

    public function __construct()
    {
        $this->path = JSON_SETTINGS_PATH;
    }

    public function load(): array
    {
        return json_decode(file_get_contents($this->path), true);
    }

    public function setPath(string $path): JsonSettings
    {
        $this->path = $path;
        return $this;
    }
}
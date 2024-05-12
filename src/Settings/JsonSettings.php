<?php
declare(strict_types=1);

namespace Eugene\DatabaseReplicator\Settings;

use Eugene\DatabaseReplicator\Exceptions\SettingsLoadException;

final class JsonSettings implements SettingsInterface
{
    private string $path;

    public function __construct()
    {
        $this->path = JSON_SETTINGS_PATH;
    }

    /**
     * @throws SettingsLoadException
     */
    public function load(): array
    {
        $contents = file_get_contents($this->path);

        if(empty($contents)){
            throw new SettingsLoadException();
        }

        return json_decode($contents, true);
    }

    public function setPath(string $path): JsonSettings
    {
        $this->path = $path;
        return $this;
    }
}
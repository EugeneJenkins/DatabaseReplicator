<?php

namespace Eugene\DatabaseReplicator\File;

class File
{
    private mixed $fileStream;
    private string $path;
    private string $directory;

    public function __construct(readonly private string $mode)
    {
        $this->path = REPLICATION_MESSAGES_PATH;
        $this->directory = MESSAGES_DIRECTORY;
    }

    public function __destruct()
    {
        if (!empty($this->fileStream)) {
            fclose($this->fileStream);
        }
    }

    public function getStream()
    {
        if (!empty($this->fileStream)) {
            return $this->fileStream;
        }

        if (!is_dir($this->directory)) {
            mkdir($this->directory, 0755);
        }

        $this->fileStream = fopen($this->path, $this->mode);

        if (!$this->fileStream) {
            throw new FileWriteException(sprintf('Unable to open file %s', $this->path));
        }

        return $this->fileStream;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
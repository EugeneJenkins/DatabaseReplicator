<?php

namespace Eugene\DatabaseReplicator\File;

readonly class FileWriter
{
    public function __construct(
        private File $file = new File('a')
    )
    {
    }

    /**
     * @throws FileWriteException
     */
    public function write(string $data): void
    {
        if (fwrite($this->file->getStream(), sprintf("%s\n", $data)) === FALSE) {
            throw new FileWriteException(sprintf('Cannot write to a file %s', $this->file->getPath()));
        }
    }
}
<?php

use Eugene\DatabaseReplicator\Factory\Factory;
use Eugene\DatabaseReplicator\Replicator;

require_once 'bootstrap.php';

$settings = Factory::createSettings()->load();
$dev = Factory::createDatabase($settings['source']);
$local = Factory::createDatabase($settings['reference']);

try {
    $replicator = new Replicator($dev, $local);
    $replicator->merge();
} catch (Throwable $exception) {
    echo $exception->getMessage();
}

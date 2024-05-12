<?php

namespace Eugene\DatabaseReplicator\Broker;

interface BrokerInterface
{
    public function push(array $data): void;
}
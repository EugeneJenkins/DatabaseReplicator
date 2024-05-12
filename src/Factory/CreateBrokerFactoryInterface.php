<?php

namespace Eugene\DatabaseReplicator\Factory;

use Eugene\DatabaseReplicator\Broker\BrokerInterface;

interface CreateBrokerFactoryInterface
{
    public static function createBroker(): BrokerInterface;
}
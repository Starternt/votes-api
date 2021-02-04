<?php

namespace App\Utils;

use Kafka\Producer;
use Kafka\ProducerConfig;

trait KafkaHelper
{
    /**
     * @param string $host
     * @param string $port
     *
     * @return Producer
     */
    public function configureProducer(string $host, string $port): Producer
    {
        $config = ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(100000);
        $config->setMetadataBrokerList($host.':'.$port);
        $config->setBrokerVersion('1.0.0');
        $config->setRequiredAck(1);

        $config->setIsAsyn(false);
        return new Producer();
    }
}
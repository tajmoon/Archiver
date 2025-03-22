<?php

namespace App\Archiver;

use App\Archiver\DataTypes\Config\ArchiveConfig;
use App\Archiver\DataTypes\Config;
use App\Archiver\Engine\ArchiveEngineFactory;
use Exception;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;

class Archiver
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly Config $config
    ) {

    }

    /**
     * Start archive
     * @param bool $isForce - force isn't stop after Exception
     * @return void
     * @throws Exception
     */
    public function start(bool $isForce = false) : void {
        /** @var ArchiveConfig $config */
        foreach ($this->config->archiveConfigs as $config) {
            try {
                $engine = ArchiveEngineFactory::create($config, $this->logger, $isForce);

                $engine->archive();
            } catch (Exception $exception) {
                $this->logger->log(LogLevel::ERROR, $exception->getMessage());
                if (!$isForce) {
                    throw $exception;
                }
            }
        }
    }
}
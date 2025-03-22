<?php

namespace App\Archiver\Engine;

use App\Archiver\DataTypes\Config\ArchiveConfig;
use App\Archiver\Engine\Base\AbstractArchiveEngine;
use Psr\Log\LoggerInterface;
use Exception;

class ArchiveEngineFactory
{
    /**
     * Create ready to work AbstractArchiveEngine instance
     * @param ArchiveConfig $config
     * @param LoggerInterface|null $logger
     * @param bool $isForce
     * @return AbstractArchiveEngine
     * @throws Exception
     */
    public static function create(ArchiveConfig $config, ?LoggerInterface $logger = null, bool $isForce = false): AbstractArchiveEngine
    {
        $archiveEngineBuilder = new ArchiveEngineBuilder($config);
        if ($logger instanceof LoggerInterface) {
            $archiveEngineBuilder->setLogger($logger);
        }

        return $archiveEngineBuilder
            ->setForce($isForce)
            ->build()
            ->getEngine();
    }
}
<?php

namespace App\Archiver\Engine\Base;

use App\Archiver\DataTypes\Config\ArchiveConfig;
use App\Archiver\DataTypes\Config\ArchiveConfig\Compression;
use Exception;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;

abstract class AbstractArchiveEngine implements ArchiveEngineInterface
{
    use LoggerAwareTrait;
    public readonly bool $isForce;

    public function __construct(
        protected ArchiveConfig $config
    ) {
        static::init();
    }

    public function __destruct() {
        static::end();
    }

    /**
     * Prepares an instance of the child class (to avoid overriding the constructor)
     * @return void
     */
    protected abstract function init() : void;

    protected abstract function end() : void;

    /**
     * Save archive to file
     * @return bool
     */
    protected abstract function saveToFile() : bool;

    /**
     * Adds file or dir (recursive) to archive
     * @param string $source
     * @throws Exception
     */
    protected abstract function addFile(string $source) : self;

    /**
     * Archive all files and save to file
     * @return bool
     * @throws Exception
     */
    public function archive() : bool {
        $this->addFiles();

        return $this->saveToFile();
    }

    /**
     * @param bool $isForce
     * @return void
     */
    public function setIsForce(bool $isForce) : void {
        $this->isForce = $isForce;
    }

    /**
     * Adds all files to archive
     * @return void
     * @throws Exception
     */
    private function addFiles() : void
    {
        foreach ($this->config->sources as $source) {
            try {
                $this->addFile($source);
            } catch (Exception $exception) {
                $this->logger->log(LogLevel::ERROR, $exception->getMessage());
                if (!$this->isForce) {
                    throw $exception;
                }
            }
        }
    }
}
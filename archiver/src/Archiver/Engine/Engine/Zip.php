<?php

namespace App\Archiver\Engine\Engine;

use App\Archiver\DataTypes\Config\ArchiveConfig\Compression;
use App\Archiver\Engine\Base\AbstractCompressArchiveEngine;
use PhpZip\Constants\ZipCompressionMethod;
use PhpZip\Exception\ZipException;
use PhpZip\ZipFile;
use Exception;

final class Zip extends AbstractCompressArchiveEngine
{
    /** @var array  */
    private const COMPRESSIONS_METHODS = [
        null => ZipCompressionMethod::STORED,
        'DEFLATED' => ZipCompressionMethod::DEFLATED,
        'BZIP2' => ZipCompressionMethod::BZIP2
    ];

    /** @var ZipFile */
    private ZipFile $zipFileObject;

    #[\Override]
    protected function init() : void {
        $this->zipFileObject = new ZipFile();
    }

    protected function end() : void {
        $this->zipFileObject->close();
    }

    /**
     * Save archive to file
     * @return bool
     * @throws ZipException
     */
    protected function saveToFile() : bool
    {
        if ($this->config->compression instanceof Compression) {
            $this->zipFileObject->setCompressionLevel($this->config->compression?->level);
        }

        $this->zipFileObject->saveAsFile($this->config->destination);

        return true;
    }

    /**
     * Adds file or dir (recursive) to archive
     * @param string $source
     * @return self
     * @throws ZipException
     */
    protected function addFile(string $source) : self {
        if(file_exists($source)) {
            if(is_dir($source)) {
                $this->zipFileObject->addDirRecursive(
                    $source,
                    basename($source),
                    compressionMethod: self::COMPRESSIONS_METHODS[$this->config->compression?->method]
                );
            } else {
                $this->zipFileObject->addFile(
                    $source,
                    compressionMethod: self::COMPRESSIONS_METHODS[$this->config->compression?->method]
                );
            }
        }

        return $this;
    }

    /**
     * @param string $method
     * @return bool
     * @throws Exception
     */
    protected static function isCompressionMethodSupported(string $method) : bool {
        try {
            ZipCompressionMethod::checkSupport(self::getCompressionMethodName($method));
        } catch (ZipException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param string $method
     * @return string|int
     * @throws Exception
     */
    protected static function getCompressionMethodName(string $method) : string|int {
        if (!isset(self::COMPRESSIONS_METHODS[$method])) {
            throw new Exception('Unknown compression method: ' . $method);
        }

        return self::COMPRESSIONS_METHODS[$method];
    }
}
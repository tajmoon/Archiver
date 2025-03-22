<?php

namespace App\Archiver\Engine\Base;

use App\Archiver\Engine\Base\AbstractArchiveEngine;
use App\Archiver\DataTypes\Config\ArchiveConfig\Compression;
use Exception;

abstract class AbstractCompressArchiveEngine extends AbstractArchiveEngine
{
    /**
     * Override, add compress features
     * @return bool
     * @throws Exception
     */
    #[\Override]
    public function archive() : bool {
        if ($this->config->compression instanceof Compression) {
            if (!static::isCompressionMethodSupported($this->config->compression?->method)) {
                throw new Exception("Compression method not supported");
            }
        }

        return parent::archive(...func_get_args());
    }

    /**
     * Check is compression method supported
     * @param string $method
     * @return bool
     */
    protected abstract static function isCompressionMethodSupported(string $method): bool;

    /**
     * Returns mapped compress name
     * @param string $method
     * @return mixed
     */
    protected abstract static function getCompressionMethodName(string $method): mixed;
}
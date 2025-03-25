<?php

namespace App\Archiver\DataTypes\Config\ArchiveConfig\Enums\Methods;

use PhpZip\Constants\ZipCompressionMethod;

enum Zip
{
    public const DEFLATED = 'DEFLATED';
    public const BZIP2 = 'BZIP2';
    public const COMPRESSIONS_METHODS = [
        null => ZipCompressionMethod::STORED,
        self::DEFLATED => ZipCompressionMethod::DEFLATED,
        self::BZIP2 => ZipCompressionMethod::BZIP2
    ];
}

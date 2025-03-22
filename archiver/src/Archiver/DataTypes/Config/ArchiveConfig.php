<?php

namespace App\Archiver\DataTypes\Config;

use App\Archiver\DataTypes\Config\ArchiveConfig\Compression;

class ArchiveConfig
{
    /** @var array  */
    public array $sources;
    /** @var string  */
    public string $type;
    /** @var string  */
    public string $destination;

    /** @var ?Compression  */
    public ?Compression $compression = null;
}
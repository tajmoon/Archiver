<?php

namespace App\Archiver\DataTypes\Config\ArchiveConfig;

class Compression {
    /** @var string|null  */
    public ?string $method;
    /** @var int|null  */
    public ?int $level;
}
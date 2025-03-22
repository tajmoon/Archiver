<?php

namespace App\Archiver\Engine\Base;

use App\Archiver\DataTypes\Config\ArchiveConfig;

interface ArchiveEngineInterface
{
    public function __construct(
        ArchiveConfig $config
    );

    /**
     * Save archive as file
     * @return bool true - success, false - fail
     */
    public function archive() : bool;

    public function setIsForce(bool $isForce) : void;
}
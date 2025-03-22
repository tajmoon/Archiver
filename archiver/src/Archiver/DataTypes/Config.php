<?php

namespace App\Archiver\DataTypes;

use App\Archiver\DataTypes\Config\ArchiveConfig;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Config
{
    /**
     * @var ArchiveConfig[]
     */
    public array $archiveConfigs;

    /**
     * @param string $json - json data config
     * @return self
     */
    public static function getCreateFromJSON(string $json) : self {
        $serializer = new Serializer([
            new ArrayDenormalizer(),
            new ObjectNormalizer(
                null,
                null,
                null,
                new PhpDocExtractor()
            )
        ], [
            new JsonEncoder()
        ]);

        return $serializer->deserialize(file_get_contents($json), Config::class, JsonEncoder::FORMAT);
    }
}
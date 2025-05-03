<?php

namespace App\Archiver\DataTypes;

use App\Archiver\DataTypes\Config\ArchiveConfig;
use Symfony\Component\Filesystem\Path;
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
     * @param string $pathToFile - json data config
     * @param string $prefix
     * @return self
     */
    public static function getCreateFromJSON(string $pathToFile, string $prefix = '') : self {
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

        return $serializer->deserialize(
            file_get_contents(self::getFileExistPath($pathToFile, $prefix)),
            Config::class,
            JsonEncoder::FORMAT
        );
    }

    /**
     * @param string $pathToDir - path to dir where is config file
     * @param string $fileName - name config json file
     * @param string $prefix - config prefix
     * @return string
     */
    private static function getFileExistPath(string $pathToFile, string $prefix = '') : string
    {
        $dir = Path::getDirectory($pathToFile);
        $fileName = basename($pathToFile);

        $path = $dir . '/' . $prefix . '.' . $fileName;

        if (file_exists($path)) {
            return $path;
        }

        return $dir . '/' . $fileName;
    }
}
# General information
This project is used to automatic archive files

# Requirements
PHP 8.2 or higher \
with Extensions: \
Zip - required to create Zip archives \
bz2 - optional to Bzip2 compression

# Instalation
Download project files (all or only the directory archiver) or clone repository.\
Install requirements, run `composer install` in directory archiver. \
Next [Configure](#Configuration).

# Configuration
Defult config location: `config/archiver.json`

## First config element:
| Name | Type | Description |
|--|--|--|
| archiveConfigs | Config[] | required - array of [Config](#Config) object|

## Config
|Name| Type| Description |
|--|--|--|
|sources| string[]| required - list of paths to files and directories whose will be add to archive, if the path points to a directory it will be added with all its contents (recursively) |
|destination| string | path to output archive file |
|type| enum | required - archive type, enum ['zip'] |
|compression| [Compression](#Compression)\|null | optional - information about compression, if null, compression is disabled. Default: null |

## Compression
|Name| Type | Description|
|--|--|--|
|method|enum\|NULL| required - method of compression, Zip: ['DEFLATED', 'BZIP2'] |
|level|int| required - level of compression, Zip: [0-9] |

## example

    {
      "archiveConfigs": [
        {
          "sources": [
            "C:\\your\\dir",
            "C:\\example\\file.txt"
          ],
          "destination": "C:\\archive.zip",
          "type": "zip",
          "compression": {
            "method": "BZIP2",
            "level": 9
          }
        },
        {
          "sources": [
            "E:\\files_to_archive"
          ],
          "destination": "E:\\your\\archives\\exaple_archive.zip",
          "type": "zip",
          "compression": null
        }
      ]
    }

# Run
## Basic use
Run `php bin\console archiver:start` form archiver directory
## full command syntax
`php bin\console archiver:start [--force|-f]`
## available options:
| option | shortcut| description |
|--|--|--|
|--force|-f|The program will not stop when an error occurs|


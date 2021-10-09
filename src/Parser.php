<?php

namespace Differ\Parser;

use Exception;
use Symfony\Component\Yaml\Yaml;

function parse(string $contents, string $extension): array
{
    switch ($extension) {
        case 'json':
            return json_decode($contents, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($contents);
        default:
            throw new Exception("Unknown file extension: {$extension}");
    }
}

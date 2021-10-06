<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parse($contents, $extension): array
{
    switch ($extension) {
        case 'json':
            return json_decode($contents, true);
        case 'yaml':
        case 'yml':
            return Yaml::parse($contents);
    }
}

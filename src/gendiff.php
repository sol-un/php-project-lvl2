<?php

namespace Gendiff\Gendiff;

use function Gendiff\Builder\build;
use function Gendiff\Formatter\render;

function readFile(string $path): string
{
    return file_get_contents(__DIR__ . '/' . $path) ?: '';
}

function parse(string $contents): array
{
    return json_decode($contents, true);
}

function gendiff(\Docopt\Response $args): string
{
    ["<firstFile>" => $firstFilePath, "<secondFile>" => $secondFilePath] = $args;
    $prevData = parse(readFile($firstFilePath));
    $newData = parse(readFile($secondFilePath));
    $ast = build($prevData, $newData);
    print_r(render($ast));
    return render($ast);
}

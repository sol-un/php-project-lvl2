<?php

namespace Gendiff\Gendiff;

use function Gendiff\Builder\build;
use function Gendiff\Formatter\render;

function readFile(string $path)
{
    return file_get_contents(realpath($path));
}

function parse($contents): array
{
    return json_decode($contents, true);
}

function gendiff(string $firstFilePath, string $secondFilePath): string
{
    $prevData = parse(readFile($firstFilePath));
    $newData = parse(readFile($secondFilePath));
    $ast = build($prevData, $newData);
    return render($ast);
}

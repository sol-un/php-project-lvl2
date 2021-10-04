<?php

namespace Gendiff\Gendiff;

use function Gendiff\Builder\build;
use function Gendiff\Formatter\render;
use function Gendiff\Parser\parse;

function readFile(string $path)
{
    return file_get_contents(realpath($path));
}

function gendiff(string $firstFilePath, string $secondFilePath): string
{
    $firstFileExtension = pathinfo($firstFilePath, PATHINFO_EXTENSION);
    $secondFileExtension = pathinfo($secondFilePath, PATHINFO_EXTENSION);
    $prevData = parse(readFile($firstFilePath), $firstFileExtension);
    $newData = parse(readFile($secondFilePath), $secondFileExtension);
    $ast = build($prevData, $newData);
    return render($ast);
}

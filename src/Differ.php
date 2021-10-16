<?php

namespace Differ\Differ;

use function Differ\Builder\build;
use function Differ\Formatters\Dispatcher\render;
use function Differ\Parser\parse;

function readFile(string $path): string
{
    return file_get_contents(realpath($path));
}

function genDiff(string $firstFilePath, string $secondFilePath, string $format = 'stylish'): string
{
    $firstFileExtension = pathinfo($firstFilePath, PATHINFO_EXTENSION);
    $secondFileExtension = pathinfo($secondFilePath, PATHINFO_EXTENSION);
    $prevData = parse(readFile($firstFilePath), $firstFileExtension);
    $newData = parse(readFile($secondFilePath), $secondFileExtension);
    $ast = build($prevData, $newData);
    return render($ast, $format);
}

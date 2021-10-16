<?php

namespace Differ\Differ;

use Exception;

use function Differ\Builder\build;
use function Differ\Formatters\Dispatcher\render;
use function Differ\Parser\parse;

function readFile(string $path): array
{
    $absPath = realpath($path);
    if ($absPath === false) {
        throw new Exception("File not found: '{$path}'");
    }
    $contents = file_get_contents($absPath);
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    return [$contents, $extension];
}

function genDiff(string $firstFilePath, string $secondFilePath, string $format = 'stylish'): string|false
{
    [$firstFileContents, $firstFileExtension] = readFile($firstFilePath);
    [$secondFileContents, $secondFileExtension] = readFile($secondFilePath);
    $prevData = parse($firstFileContents, $firstFileExtension);
    $newData = parse($secondFileContents, $secondFileExtension);
    $ast = build($prevData, $newData);
    return render($ast, $format);
}

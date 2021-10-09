<?php

namespace Differ\Formatters\Index;

use Exception;

use function Differ\Formatters\Stylish\renderStylish;
use function Differ\Formatters\Plain\renderPlain;
use function Differ\Formatters\Json\renderJson;

function render(array $ast, string $format): string
{
    switch ($format) {
        case "stylish":
            return renderStylish($ast);
        case "plain":
            return renderPlain($ast);
        case "json":
            return renderJson($ast);
        default:
            throw new Exception("Unknown diff format: {$format}");
    }
}

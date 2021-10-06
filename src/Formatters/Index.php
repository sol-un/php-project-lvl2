<?php

namespace Differ\Formatters\Index;

use function Differ\Formatters\Stylish\renderStylish;
use function Differ\Formatters\Plain\renderPlain;
use function Differ\Formatters\Json\renderJson;

function render($ast, $format)
{
    switch ($format) {
        case "stylish":
            return renderStylish($ast);
        case "plain":
            return renderPlain($ast);
        case "json":
            return renderJson($ast);
    }
}

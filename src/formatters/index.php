<?php

namespace Gendiff\Formatters\Index;

use function Gendiff\Formatters\Stylish\renderStylish;
use function Gendiff\Formatters\Plain\renderPlain;
use function Gendiff\Formatters\Json\renderJson;

function render($ast, $format)
{
    switch ($format) {
        case "stylish":
            return renderStylish($ast);
        case "plain":
            return renderPlain($ast);
        case "json":
            $result = renderJson($ast);
            return $result;
    }
}

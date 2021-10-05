<?php

namespace Gendiff\Formatters\Index;

use function Gendiff\Formatters\Stylish\renderStylish;
use function Gendiff\Formatters\Plain\renderPlain;

function render($ast, $format)
{
    switch ($format) {
        case "stylish":
            return renderStylish($ast);
        case "plain":
            return renderPlain($ast);
    }
}

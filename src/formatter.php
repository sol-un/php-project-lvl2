<?php

namespace Gendiff\Formatter;

use Illuminate\Support\Collection;

function indent(int $depth): string
{
    return str_repeat('  ', $depth);
}

function renderLine(int $depth, string $prefix, string $key, $value): string
{
    return indent($depth) . "{$prefix}{$key}: {$value}";
}

function renderValue(mixed $value, int $depth)
{
    switch (gettype($value)) {
        case "boolean":
            return $value ? "true" : "false";
        case "NULL":
            return "NULL";
        default:
            return $value;
    }
}

function render(array $ast, int $depth = 0): string
{
    $renderFnDispatcher = [
        "added" => fn ($node, $depth) => renderLine($depth, '+ ', $node["name"], renderValue($node["value"], $depth)),
        "deleted" => fn ($node, $depth) => renderLine($depth, '- ', $node["name"], renderValue($node["value"], $depth)),
        "changed" => function ($node, $depth) {
            $deletedLine = renderLine($depth, '- ', $node["name"], renderValue($node["prevValue"], $depth));
            $addedLine = renderLine($depth, '+ ', $node["name"], renderValue($node["newValue"], $depth));
            return "{$deletedLine}\n{$addedLine}";
        },
        "unchanged" => function ($node, $depth) {
            return renderLine($depth, '  ', $node["name"], renderValue($node["value"], $depth));
        }
    ];

    $lines = collect($ast)
        ->map(
            function ($node) use ($renderFnDispatcher, $depth) {
                $type = $node["type"];
                return $renderFnDispatcher[$type]($node, $depth + 1);
            }
        )
        ->join("\n");
    return "{\n{$lines}\n}\n";
}

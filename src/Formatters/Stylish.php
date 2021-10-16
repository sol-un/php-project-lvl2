<?php

namespace Differ\Formatters\Stylish;

use Exception;
use Illuminate\Support\Collection;

function indent(int $depth): string
{
    return str_repeat('  ', $depth);
}

function renderLine(int $depth, string $prefix, string $key, string $value): string
{
    $indent = indent($depth);
    return "{$indent}{$prefix}{$key}: {$value}";
}

function renderValue(mixed $value, int $depth): string
{
    switch (gettype($value)) {
        case "boolean":
            return $value ? "true" : "false";
        case "NULL":
            return "null";
        case "array":
            $rendered = collect($value)
                ->map(
                    function ($value, $key) use ($depth) {
                        return renderLine($depth + 3, '  ', $key, renderValue($value, $depth + 2));
                    }
                )
                ->join("\n");
            $indent = indent($depth + 2);
            return "{\n{$rendered}\n{$indent}}";
        default:
            return "{$value}";
    }
}

function renderStylish(array $ast, int $depth = 0): string
{
    $lines = collect($ast)
        ->map(
            function ($node) use ($depth) {
                switch ($node["type"]) {
                    case "nested":
                        return renderLine($depth + 1, '  ', $node["name"], renderStylish($node["children"], $depth + 2));
                    case "added":
                        return renderLine($depth + 1, '+ ', $node["name"], renderValue($node["value"], $depth));
                    case "deleted":
                        return renderLine($depth + 1, '- ', $node["name"], renderValue($node["value"], $depth));
                    case "changed":
                        $deletedLine = renderLine($depth + 1, '- ', $node["name"], renderValue($node["prevValue"], $depth));
                        $addedLine = renderLine($depth + 1, '+ ', $node["name"], renderValue($node["newValue"], $depth));

                        return "{$deletedLine}\n{$addedLine}";
                    case "unchanged":
                        return renderLine($depth + 1, '  ', $node["name"], renderValue($node["value"], $depth));
                    default:
                        throw new Exception("Unknown node type: {$node["type"]}");
                }
            }
        )
        ->join("\n");
    $indent = indent($depth);
    return "{\n{$lines}\n{$indent}}";
}

<?php

namespace Gendiff\Formatters\Stylish;

use Illuminate\Support\Collection;

function indent(int $depth): string
{
    return str_repeat('  ', $depth);
}

function renderLine(int $depth, string $prefix, string $key, $value): string
{
    $indent = indent($depth);
    return "{$indent}{$prefix}{$key}: {$value}";
}

function renderValue($value, int $depth): string
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
                        return renderLine($depth, '      ', $key, renderValue($value, $depth + 2));
                    }
                )
                ->join("\n");
            $indent = indent($depth + 1);
            return "{\n{$rendered}\n{$indent}}";
        default:
            return "{$value}";
    }
}

function getRenderFn($type)
{
    switch ($type) {
        case "nested":
            return function ($node, $depth, $render) {
                return renderLine($depth, '  ', $node["name"], $render($node["children"], $depth + 1));
            };
        case "added":
            return function ($node, $depth) {
                return renderLine($depth, '+ ', $node["name"], renderValue($node["value"], $depth));
            };
        case "deleted":
            return function ($node, $depth) {
                return renderLine($depth, '- ', $node["name"], renderValue($node["value"], $depth));
            };
        case "changed":
            return function ($node, $depth) {
                $deletedLine = renderLine($depth, '- ', $node["name"], renderValue($node["prevValue"], $depth));
                $addedLine = renderLine($depth, '+ ', $node["name"], renderValue($node["newValue"], $depth));

                return "{$deletedLine}\n{$addedLine}";
            };
        case "unchanged":
            return function ($node, $depth) {
                return renderLine($depth, '  ', $node["name"], renderValue($node["value"], $depth));
            };
    }
}

function render(array $ast, int $depth = 0): string
{
    $lines = collect($ast)
        ->map(
            function ($node) use ($depth) {
                $type = $node["type"];
                return getRenderFn($type)($node, $depth + 1, __NAMESPACE__ . '\\' . 'render');
            }
        )
        ->join("\n");
    $indent = indent($depth);
    return "{\n{$lines}\n{$indent}}";
}

function renderStylish($ast): string
{
    return render($ast) . "\n";
}

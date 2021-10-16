<?php

namespace Differ\Formatters\Plain;

use Exception;

function renderValue(mixed $value): string
{
    switch (gettype($value)) {
        case "boolean":
            return (bool) $value ? "true" : "false";
        case "NULL":
            return "null";
        case "array":
            return "[complex value]";
        case "string":
            return "'{$value}'";
        default:
            return $value;
    }
}

function renderPath(array $parentNames, string $name): string
{
    return implode('.', [...$parentNames, $name]);
}

function renderPlain(array $ast, array $parentNames = []): string
{
    return collect($ast)
        ->map(
            function ($node) use ($parentNames): ?string {
                switch ($node["type"]) {
                    case "nested":
                        return renderPlain($node["children"], [...$parentNames, $node["name"]]);
                    case "added":
                        $path = renderPath($parentNames, $node["name"]);
                        $value = renderValue($node["value"]);
                        return "Property '{$path}' was added with value: {$value}";
                    case "deleted":
                        $path = renderPath($parentNames, $node["name"]);
                        return "Property '{$path}' was removed";
                    case "changed":
                        $path = renderPath($parentNames, $node["name"]);
                        $prevValue = renderValue($node["prevValue"]);
                        $newValue = renderValue($node["newValue"]);
                        return "Property '{$path}' was updated. From {$prevValue} to {$newValue}";
                    case "unchanged":
                        return null;
                    default:
                        throw new Exception("Unknown node type: {$node["type"]}");
                }
            }
        )
        ->filter(fn ($item) => $item)
        ->join("\n");
}
